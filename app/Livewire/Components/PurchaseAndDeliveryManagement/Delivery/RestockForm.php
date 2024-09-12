<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery;

use App\Events\RestockEvent;
use App\Livewire\Pages\DeliveryPage;
use App\Models\BackOrder;
use App\Models\Delivery;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseDetails;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RestockForm extends Component
{
    use LivewireAlert;
    public $delivery_id, $po_number, $supplier, $purchase_id,  $delivery_date, $po_date;
    public $purchaseDetails = [];
    public $restock_quantity = [null], $cost = [null], $markup = [null], $srp = [null], $expiration_date = [null];

    public function render()
    {

        if (empty($this->purchaseDetails)) {
            // Fetch purchase details with related itemsJoin data
            $this->purchaseDetails = PurchaseDetails::with('itemsJoin')
                ->where('purchase_id', $this->purchase_id)
                ->get()
                ->map(function ($details) {
                    return $details->toArray() + [
                        'barcode' => $details->itemsJoin->barcode,
                        'item_name' => $details->itemsJoin->item_name,
                        'reorder_point' => $details->itemsJoin->reorder_point,
                        'item_id' => $details->item_id,
                        'shelf_life_type' => $details->itemsJoin->shelf_life_type,
                        'item_description' => $details->itemsJoin->item_description,
                        'purchased_quantity' => $details->purchase_quantity,
                        'sku_code' => $this->generateSKU(),
                        'isDuplicate' => false,
                    ];
                })
                ->toArray();
        }

        return view('livewire.components.PurchaseAndDeliveryManagement.Delivery.restock-form', [
            'purchaseDetails' => $this->purchaseDetails,
        ]);
    }
    protected $listeners = [
        'restock-form' => 'restockForm',
        'close-modal' => 'closeModal',
        'createConfirmed', //*  galing sa UserTable class
    ];

    public function create()
    {

        $validated = $this->validateForm(); // Validate form data

        $quantities = [];


        // First pass: Accumulate restock quantities for each item
        foreach ($this->purchaseDetails as $index => $detail) {

            $this->getReorderPoint($detail['item_id']);

            $details_id = $detail['id']; // get all the id of each purchase details

            if (!isset($quantities[$details_id])) {
                $quantities[$details_id] = 0;
            }
            $quantities[$details_id] += $this->restock_quantity[$index];
        }

        // Second pass: Check each item's quantity individually
        foreach ($this->purchaseDetails as $index => $detail) {

            $details_id = $detail['id']; // Assuming 'id' refers to item_id

            // Check if the accumulated restock quantity exceeds the purchased quantity
            if ($quantities[$details_id] > $detail['purchase_quantity']) {
                // Stop further processing
                $this->addError('restock_quantity.' . $index, "Restock quantity exceeds the purchased quantity ");
                return;
            }
        }

        // If any item falls short, prompt for confirmation
        foreach ($this->purchaseDetails as $index => $detail) {
            $details_id = $detail['id']; // Assuming 'id' refers to item_id

            if ($quantities[$details_id] < $detail['purchase_quantity']) {
                $this->confirm("The total restock quantity for some items falls short of the purchased quantity. Do you still want to restock these items?", [
                    'onConfirmed' => 'createConfirmed',
                    'inputAttributes' => $validated,
                ]);


                return; // Ensure we don’t proceed if confirmation is needed
            }
        }

        // If all validations pass, prompt for final confirmation
        $this->confirm('Do you want to restock these items?', [
            'onConfirmed' => 'createConfirmed',
            'inputAttributes' => $validated,
        ]);
    }

    public function createConfirmed($data)
    {


        $validated = $data['inputAttributes'];
        $hasBackorder = false;


        $backorder_Items = [];

        $this->getMaximumLevel();

        foreach ($this->purchaseDetails as $index => $detail) {
            $details = $detail['item_id'];

            if (!isset($backorder_Items[$details])) {
                $backorder_Items[$details] = [
                    'details' => $detail,
                    'total_restock_quantity' => 0
                ];
            }
            $backorder_Items[$details]['total_restock_quantity'] += $this->restock_quantity[$index];
        }



        foreach ($backorder_Items as $index => $backorder) {

            $detail = $backorder['details'];


            $totalRestockQuantity = $backorder['total_restock_quantity'];

            if ($totalRestockQuantity < $detail['purchase_quantity'] && !$detail['isDuplicate']) {
                $hasBackorder = true;

                BackOrder::create([
                    'purchase_id' => $this->purchase_id,
                    'item_id' => $detail['item_id'],
                    'backorder_quantity' => $detail['purchase_quantity'] - $totalRestockQuantity,
                    'status' => 'Missing',
                ]);
            }
        }

        foreach ($this->purchaseDetails as $index => $detail) {


            $item = Item::find($detail['item_id']);
            $item->status_id = "1";
            $item->save();

            $inventory = Inventory::create([
                'sku_code' => $detail['sku_code'],
                'cost' => $this->cost[$index],
                'mark_up_price' => $validated['markup'][$index],
                'selling_price' => $validated['srp'][$index],
                'vat_amount' => ($item->vat_percent / 100) * $validated['srp'][$index],
                'current_stock_quantity' =>  $validated['restock_quantity'][$index],
                'stock_in_quantity' =>  $validated['restock_quantity'][$index],
                'expiration_date' =>  $validated['expiration_date'][$index] ?? null,
                'stock_in_date' => now(),  // Assuming you want to set the current date as stock in date
                'status' => 'Available',   // Set default status or customize as needed
                'item_id' => $detail['item_id'],  // Assuming 'id' here refers to the item_id
                'delivery_id' => $this->delivery_id, // Assuming you want to associate with the supplier
                'user_id' => Auth::id(), // Assuming you want to associate with the currently authenticated user
            ]);



            $inventoryMovement = InventoryMovement::create([
                'inventory_id' => $inventory->id,
                'movement_type' => 'Inventory',
                'operation' => 'Stock In',
            ]);
        }

        $delivery = Delivery::where('purchase_id', $this->purchase_id)->first();



        if ($hasBackorder) {
            $delivery->status = "Stocked in with backorder";
        } else {
            $delivery->status = "Complete Stock in";
        }
        $delivery->save();



        $this->resetForm();
        $this->alert('success', 'Restocked successfully');

        RestockEvent::dispatch('refresh-stock');
        $this->refreshTable();
        $this->closeModal();
    }

    public function updatedCost($value, $index)
    {
        $this->calculateSRP($index);
    }

    public function updatedMarkup($value, $index)
    {
        $this->calculateSRP($index);
    }

    public function calculateSRP($index)
    {
        // Check if both cost and markup are set and are numeric
        if (isset($this->cost[$index]) && isset($this->markup[$index])) {
            if (is_numeric($this->cost[$index]) && is_numeric($this->markup[$index])) {
                $srp = $this->cost[$index] * (1 + $this->markup[$index] / 100);
                $this->srp[$index] = ceil($srp); // Round up to the nearest whole number
            } else {
                // Handle the case where cost or markup is not numeric
                $this->srp[$index] = null; // Or set it to some default value or handle the error accordingly
            }
        }
    }
    private function populateForm() //*lagyan ng laman ang mga input
    {

        $delivery_details = Delivery::find($this->delivery_id); //? kunin lahat ng data ng may ari ng item_id


        $this->fill([
            'po_number' => $delivery_details->purchaseJoin->po_number,
            'supplier' => $delivery_details->purchaseJoin->supplierJoin->company_name,
        ]);
    }
    public function duplicateItem($item_id)
    {
        // Find the original PurchaseDetails item
        $originalItem = PurchaseDetails::with('itemsJoin')->find($item_id);


        $newItem = [

            'barcode' => $originalItem->itemsJoin->barcode,
            'item_id' => $originalItem->item_id,
            'item_name' => $originalItem->itemsJoin->item_name,
            'shelf_life_type' => $originalItem->itemsJoin->shelf_life_type,

            'item_description' => $originalItem->itemsJoin->item_description,
            'purchase_quantity' => $originalItem->purchase_quantity,
            'sku_code' => $this->generateSKU(),  // Preserve the original SKU code
            'id' => $originalItem->id,  // Keep the original ID for tracking purposes
            'isDuplicate' => true,
        ];

        // Find the index of the original item in the purchaseDetails array
        $index = array_search($originalItem->id, array_column($this->purchaseDetails, 'id'));

        // Insert the duplicated item directly after the original item
        array_splice($this->purchaseDetails, $index + 1, 0, [$newItem]);
        array_splice($this->restock_quantity, $index + 1, 0, [$newItem]);
        array_splice($this->markup, $index + 1, 0, [$newItem]);
        array_splice($this->cost, $index + 1, 0, [$newItem]);
        array_splice($this->expiration_date, $index + 1, 0, [$newItem]);
        array_splice($this->srp, $index + 1, 0, [$newItem]);

        // Reindex the array to ensure consistency
        $this->purchaseDetails = array_values($this->purchaseDetails);
        $this->restock_quantity = array_values($this->restock_quantity);
        $this->markup = array_values($this->markup);
        $this->cost = array_values($this->cost);
        $this->expiration_date = array_values($this->expiration_date);
        $this->srp = array_values($this->srp);
    }

    public function removeItem($index)
    {
        unset($this->purchaseDetails[$index]);
        unset($this->restock_quantity[$index]);
        unset($this->cost[$index]);
        unset($this->markup[$index]);
        unset($this->srp[$index]);
        unset($this->expiration_date[$index]);


        $this->purchaseDetails = array_values($this->purchaseDetails);
        $this->restock_quantity = array_values($this->restock_quantity);
        $this->markup = array_values($this->markup);
        $this->cost = array_values($this->cost);
        $this->expiration_date = array_values($this->expiration_date);
        $this->srp = array_values($this->srp);
    }
    protected function validateForm()
    {
        $rules = [];


        foreach ($this->purchaseDetails as $index => $purchaseDetail) {
            $rules["restock_quantity.$index"] = ['required', 'numeric', 'min:0'];
            $rules["cost.$index"] = ['required', 'numeric', 'min:1'];
            $rules["markup.$index"] = ['required', 'numeric', 'min:1'];
            $rules["srp.$index"] = ['required', 'numeric', 'min:1'];


            if ($purchaseDetail['shelf_life_type'] === 'Perishable') {
                $rules["expiration_date.$index"] = ['required', 'date', 'after_or_equal:today'];
            }
        }



        return $this->validate($rules);
    }


    public function restockForm($deliveryID)
    {
        $this->delivery_id = $deliveryID;
        $delivery = Delivery::find($this->delivery_id);
        $this->purchase_id = $delivery->purchase_id;

        $this->delivery_date = $delivery->date_delivered;
        $this->po_date = $delivery->purchaseJoin->created_at;



        $this->populateForm();
    }

    private function resetForm() //*tanggalin ang laman ng input pati $item_id value
    {
        $this->reset(['delivery_id', 'po_number', 'supplier', 'purchase_id', 'purchaseDetails', 'restock_quantity', 'cost', 'markup', 'srp', 'expiration_date']);
    }
    public function refreshTable()
    {
        $this->dispatch('refresh-table')->to(DeliveryTable::class);
    }

    public function closeModal()
    {
        $this->resetValidation();
        $this->dispatch('display-restock-form', showRestockForm: false)->to(DeliveryPage::class);
        $this->dispatch('display-delivery-table', showDeliveryTable: true)->to(DeliveryPage::class);
        $this->resetForm();
    }
    public function generateSKU()
    {


        $randomNumber = random_int(0, 9999);
        $formattedNumber = str_pad($randomNumber, 4, '0', STR_PAD_LEFT);
        $SKU = 'SKU-' . $formattedNumber . '-' . now()->format('dmY');

        return $SKU;
    }

    public function getReorderPoint($item_id)
    {
        $deliveryDate = Carbon::parse($this->delivery_date);
        $poDate = Carbon::parse($this->po_date);

        // Define the start and end dates
        $startDate = $poDate->startOfDay();
        $endDate = $deliveryDate->endOfDay();


        $totalQuantity = TransactionDetails::where('item_id', $item_id)
            ->whereHas('transactionJoin', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->sum('item_quantity');


        // Calculate the number of days in the date range
        $days = floor($startDate->diffInDays($endDate));
        // dd($totalQuantity);

        // Calculate the demand rate
        $demandRate =  $totalQuantity / $days;
        $reorder_point = ($days * $demandRate);

        $item = Item::find($item_id);
        $item->reorder_point = $reorder_point;
        $item->save();
    }

    public function getMaximumLevel()
    {
        $maximum_level_req = [];

        foreach ($this->purchaseDetails as $detail) {
            $itemId = $detail['item_id'];

            // Calculate the date range from the same day last week to today
            $startDate = Carbon::now()->subWeek()->startOfDay()->toDateTimeString();
            $endDate = Carbon::now()->endOfDay()->toDateTimeString();

            // Calculate minimum consumption within the period
            $minQuantity = TransactionDetails::where('item_id', $itemId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->min('item_quantity');

            // Find the minimum reorder period for the item
            $minReorderPeriod = PurchaseDetails::where('purchase_details.item_id', $itemId)
                ->join('purchases', 'purchase_details.purchase_id', '=', 'purchases.id')
                ->join('deliveries', 'purchases.id', '=', 'deliveries.purchase_id')
                ->select(DB::raw("EXTRACT(DAY FROM AGE(deliveries.date_delivered, purchases.created_at)) AS reorder_period"))
                ->orderBy('reorder_period', 'asc')
                ->value('reorder_period');

            // Calculate maximum level using the formula
            $reorderPoint = $detail['reorder_point'];
            $reorderQuantity = $detail['purchase_quantity'];
            $minConsumption = $minQuantity ?? 0;
            $minReorderPeriod = $minReorderPeriod ?? 0;

            $maximumLevel = $reorderPoint + $reorderQuantity - ($minConsumption * $minReorderPeriod);

            Item::where('id', $itemId)->update(['maximum_stock_level' => $maximumLevel]);

            $maximum_level_req[] = [
                'item_id' => $itemId,
                'min_quantity' => $minConsumption,
                'purchase_quantity' => $reorderQuantity,
                'reorder_point' => $reorderPoint,
                'min_reorder_period' => $minReorderPeriod,
                'maximum_level' => $maximumLevel
            ];
        }
    }
}
