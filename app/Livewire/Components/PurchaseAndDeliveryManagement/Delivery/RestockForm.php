<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery;

use App\Livewire\Pages\DeliveryPage;
use App\Models\Delivery;
use App\Models\Inventory;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseDetails;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RestockForm extends Component
{
    use LivewireAlert;
    public $delivery_id, $po_number, $supplier, $purchase_id;
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

    // Initialize quantities array
    $quantities = [];

    // First pass: Accumulate restock quantities for each item
    foreach ($this->purchaseDetails as $index => $detail) {
        $details_id = $detail['id']; // Assuming 'id' refers to item_id

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
            $this->alert('error', "The total restock quantity for {$detail['item_name']} exceeds the purchased quantity of {$detail['purchase_quantity']}.");
            return; // Stop further processing
        }
    }

    // If any item falls short, prompt for confirmation
    foreach ($this->purchaseDetails as $index => $detail) {
        $details_id = $detail['id']; // Assuming 'id' refers to item_id

        if ($quantities[$details_id] < $detail['purchase_quantity']) {
            $this->confirm("The total restock quantity for some items falls short of the purchased quantity. Do you still want to add these items?", [
                'onConfirmed' => 'createConfirmed',
                'inputAttributes' => $validated,
            ]);
            return; // Ensure we don’t proceed if confirmation is needed
        }
    }

    // If all validations pass, prompt for final confirmation
    $this->confirm('Do you want to add these items?', [
        'onConfirmed' => 'createConfirmed',
        'inputAttributes' => $validated,
    ]);
}

    public function createConfirmed($data)
    {
        $validated = $data['inputAttributes'];
        $supplier = Delivery::find($this->delivery_id);

        foreach ($this->purchaseDetails as $index => $detail) {

            // Create a new inventory record
            $inventory = Inventory::create([
                'sku_code' => $detail['sku_code'],
                'cost' => $this->cost[$index],
                'mark_up_price' => $this->markup[$index],
                'selling_price' => $this->srp[$index],
                'current_stock_quantity' => $this->restock_quantity[$index],
                'expiration_date' => $this->expiration_date[$index],
                'stock_in_date' => now(),  // Assuming you want to set the current date as stock in date
                'status' => 'Available',   // Set default status or customize as needed
                'item_id' => $detail['id'],  // Assuming 'id' here refers to the item_id
                'supplier_id' => $supplier->purchaseJoin->supplierJoin->id, // Assuming you want to associate with the supplier
                'user_id' => Auth::id(), // Assuming you want to associate with the currently authenticated user
            ]);
        }

        $delivery = Delivery::find($this->purchase_id);
        $delivery->date_delivered = now();
        $delivery->status = "Stocked in";
        $delivery->save();

        $this->resetForm();
        $this->alert('success', 'stock adjusted successfully');

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
                $this->srp[$index] = $this->cost[$index] * (1 + $this->markup[$index] / 100);
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
            'item_name' => $originalItem->itemsJoin->item_name,
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
            $rules["restock_quantity.$index"] = ['required', 'numeric', 'min:1'];
            $rules["cost.$index"] = ['required', 'numeric', 'min:1'];
            $rules["markup.$index"] = ['required', 'numeric', 'min:1'];
            $rules["srp.$index"] = ['required', 'numeric', 'min:1'];
            $rules["expiration_date.$index"] = ['required', 'date'];
        }


        return $this->validate($rules);
    }


    public function restockForm($deliveryID)
    {
        $this->delivery_id = $deliveryID;
        $delivery = Delivery::find($this->delivery_id);
        $this->purchase_id = $delivery->purchase_id;

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
        $this->resetForm();
    }
    public function generateSKU()
    {
        $randomNumber = random_int(100000, 999999);
        return 'SKU-' . $randomNumber;
    }
}
