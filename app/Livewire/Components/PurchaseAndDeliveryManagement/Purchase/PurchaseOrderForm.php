<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase;

use App\Events\PurchaseOrderEvent;
use App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery\DeliveryTable;
use App\Livewire\Pages\PurchasePage;
use App\Models\Delivery;
use App\Models\Item;
use App\Models\Log;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Supplier;
use App\Models\SupplierItems;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class PurchaseOrderForm extends Component
{

    use LivewireAlert, WithPagination, WithoutUrlPagination;



    public $items, $selectAll, $isAnyChecked;

    public $reorderLists = [], $toOrderItems = [], $selectedItems = [], $purchaseQuantities = [], $selectSuppliers = [], $po_numbers = [], $lowestSupplier = [], $orders = [];
    public $search = '';


    public function render()
    {
        $suppliers = Supplier::select('id', 'company_name')->where('status_id', '1')->get();

        foreach ($this->reorderLists as $index => $reorderList) {
            // Retrieve the supplier with the lowest cost
            $lowestSupplierItem = SupplierItems::where('item_id', $reorderList->id)
                ->orderBy('item_cost', 'asc')
                ->first();  // Get the supplier with the lowest item cost

            // Ensure lowestSupplier is not null before accessing its properties
            if ($lowestSupplierItem) {
                $reorderList->lowestSupplier = Supplier::find($lowestSupplierItem->supplier_id);
                if ($reorderList->lowestSupplier) {
                    $reorderList->lowestSupplier->supplierItemsJoin = $lowestSupplierItem;
                    $this->lowestSupplier[$index] = $reorderList->lowestSupplier;
                }
            } else {
                $reorderList->lowestSupplier = null;  // No supplier with the lowest cost
                $this->lowestSupplier[$index] = $reorderList->lowestSupplier;
            }
        }
        return view('livewire.components.PurchaseAndDeliveryManagement.Purchase.purchase-order-form', [
            'suppliers' => $suppliers,
            'reorderLists' => $this->reorderLists,
            'po_numbers' => $this->po_numbers,
            'orders' => $this->orders
        ]);
    }


    protected $listeners = [
        'edit-po-from-table' => 'edit',
        'create-po' => 'po',
        'change-method' => 'changeMethod',
        'updateConfirmed',
        'createConfirmed',
    ];

    public function create() //* create process
    {
        $validated = $this->validateForm();


        $this->confirm('Do you want to create this purchase order?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' => $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }

    public function createConfirmed($data) //* confirmation process ng create
    {

        $validated = $data['inputAttributes'];

        DB::beginTransaction();

        try {





            foreach ($this->selectSuppliers as $index => $selectSupplier) {

                $poNumber = $this->generatePurchaseOrderNumber();

                $existingPurchaseOrder = Purchase::where('po_number', $poNumber)->first();

                if ($existingPurchaseOrder) {
                    $this->alert('error', 'Purchase order number already exists.');
                    return; // Exit if it exists
                }

                $purchase_order = Purchase::create([
                    'po_number' => $poNumber,
                    'supplier_id' => $selectSupplier,
                    'user_id' => Auth::id(),
                ]);


                $delivery = Delivery::create([
                    'status' => "In Progress",
                    'date_delivered' => "N/A",
                    'purchase_id' => $purchase_order->id
                ]);


                foreach ($this->selectedItems as $itemIndex => $selectedItem) {
                    // Only create PurchaseDetails if the item matches the current supplier index
                    if (isset($this->selectSuppliers[$itemIndex]) && $this->selectSuppliers[$itemIndex] == $selectSupplier) {
                        PurchaseDetails::create([
                            'purchase_id' => $purchase_order->id,
                            'item_id' => $selectedItem['id'], // Use item_id from selected items
                            'po_number' => $purchase_order->po_number,
                            'purchase_quantity' => $this->purchaseQuantities[$itemIndex],
                        ]);
                    }
                }
            }






            $userName = Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname;

            $log = Log::create([
                'user_id' => Auth::user()->id,
                'message' => $userName . ' (' . Auth::user()->username . ') ' . 'Created a purchase order',
                'action' => 'PO Create'
            ]);

            DB::commit();

            $this->alert('success', 'Purchase order was created successfully');
            $this->refreshTable();
            PurchaseOrderEvent::dispatch('refresh-purchase-order');

            $this->resetForm();
            $this->closeModal();
        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            dump($e);
            DB::rollback();
            $this->alert('error', 'An error occurred while creating the purchase order, please refresh the page ');
        }
    }

    public function updatedSelectAll()
    {
        if ($this->selectAll === true) {

            $this->toOrderItems = array_fill(0, count($this->reorderLists), true);
            foreach ($this->reorderLists as $index => $reorderList) {
                if (!isset($this->selectedItems[$index])) {
                    $this->selectedItems[$index] = $reorderList;
                }
            }


        } else {
            $this->toOrderItems = array_fill(0, count($this->reorderLists), false);
            $this->selectedItems = [];
            $this->purchaseQuantities = [];
            $this->selectSuppliers = [];
            $this->po_numbers = [];
        }
    }

    public function updatedSearch()
    {
        $items = Item::withSum('inventoryJoin as total_stock_quantity', 'current_stock_quantity')
            ->where('item_name', 'like', '%' . $this->search . '%')
            ->get();

        $this->reorderLists = [];

        foreach ($items as $item) {
            if ($item->inventoryJoin->isNotEmpty() && $item->total_stock_quantity <= $item->reorder_point) {
                $this->reorderLists[] = $item;
            }
        }

        // $this->toOrderItems = array_fill(0, count($this->reorderLists), false);

    }

    public function getSelectedItems()
    {

        foreach ($this->selectedItems as $index => $selectedItem) {

            $supplier = Supplier::find($this->selectSuppliers[$index]);

            $supplierItem = SupplierItems::where('supplier_id', $supplier->id)
                ->where('item_id', $selectedItem->id)  // Assuming you're filtering by item_id as well
                ->first();

            $this->orders[] = [
                'item' => $selectedItem,
                'supplier' => $supplier,
                'supplierItem' => $supplierItem,
                'purchaseQuantities' => $this->purchaseQuantities[$index]
            ];


            unset($this->reorderLists[$index]);
            unset($this->selectedItems[$index]);
            unset($this->toOrderItems[$index]);
            unset($this->purchaseQuantities[$index]);
            unset($this->selectSuppliers[$index]);
            unset($this->po_numbers[$index]);
        }

        $this->reorderLists = array_values($this->reorderLists);
        $this->toOrderItems = array_values($this->toOrderItems);
        $this->selectedItems = array_values($this->selectedItems);
        $this->purchaseQuantities = array_values($this->purchaseQuantities);
        $this->selectSuppliers = array_values($this->selectSuppliers);
        $this->po_numbers = array_values($this->po_numbers);

    }

    public function updateSelectSupplier($index, $supplierID)
    {
        if (isset($this->selectSuppliers[$index])) {
            // Update the supplier ID at the given index
            $this->selectSuppliers[$index] = $supplierID;
        } else {
            // If the index doesn't exist, add it to the array
            $this->selectSuppliers[$index] = $supplierID;
        }

    }

    public function updatedPurchaseQuantities($index, $value)
    {

    }

    public function updatedToOrderItems($state, $index)
    {
        // Get the item from the reorderLists using the index
        $reorderList = $this->reorderLists[$index];

        if ($state === true) {
            // Add the item to the selectedItems array if it is checked
            $this->selectedItems[$index] = $reorderList;

            if ($this->lowestSupplier[$index]) {
                $this->selectSuppliers[$index] = $this->lowestSupplier[$index]->id;

            }



        } else {
            // Remove the item from the selectedItems array if it is unchecked
            $this->selectedItems = collect($this->selectedItems)
                ->reject(function ($item) use ($reorderList) {
                    return $item['id'] === $reorderList['id']; // Remove based on the 'id'
                })
                ->values()
                ->toArray();
        }

    }

    public function test()
    {
        dump([
            'toOrder' => $this->toOrderItems,
            'selectedItems' => $this->selectedItems,
            'selectSuppliers' => $this->selectSuppliers,
            'purchaseQuantities' => $this->purchaseQuantities,
            'reorderLists' => $this->reorderLists,
            'lowestSupplier' => $this->lowestSupplier
        ]);
    }




    protected function validateForm()
    {

        $rules = [];
        // Add validation rules for each purchase quantity
        foreach ($this->selectedItems as $index => $selectedItem) {


            if (isset($this->purchaseQuantities[$index])) {


                $maxStockLevel = $selectedItem->maximum_stock_level;

                if ($maxStockLevel > 0) {
                    $rules["purchaseQuantities.$index"] = [
                        'required',
                        'numeric',
                        'min:1',
                        'lte:' . $maxStockLevel
                    ];


                } else {
                    $rules["purchaseQuantities.$index"] = ['required', 'numeric', 'min:1'];
                    $rules["selectSuppliers.$index"] = ['required', 'numeric'];


                }
            }


        }



        return $this->validate($rules);
    }

    private function resetForm() //*tanggalin ang laman ng input pati $item_id value
    {

        $this->reset(['po_numbers', 'items', 'selectAll', 'selectSuppliers', 'reorderLists', 'toOrderItems', 'selectedItems', 'purchaseQuantities', 'search', 'lowestSupplier']);
    }

    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(PurchasePage::class);
        $this->dispatch('refresh-table')->to(PurchaseOrderTable::class);
        $this->resetValidation();
    }

    public function generatePurchaseOrderNumber()
    {
        do {
            $randomNumber = random_int(0, 9999);
            $formattedNumber = str_pad($randomNumber, 4, '0', STR_PAD_LEFT);
            $purchaseOrderNumber = 'PO-' . $formattedNumber . '-' . now()->format('mdY');

            // Check if the purchase order number already exists
            $exists = Purchase::where('po_number', $purchaseOrderNumber)->exists();
        } while ($exists);

        // Assign the unique purchase order number
        return $purchaseOrderNumber;
    }

    public function refreshTable() //* refresh ang table after confirmation
    {
        $this->dispatch('refresh-table')->to(PurchaseOrderTable::class);
        $this->dispatch('refresh-table')->to(DeliveryTable::class);
    }

    public function po()
    {

        $this->isAnyChecked = in_array(true, $this->toOrderItems, true);

        if (empty($this->search)) {
            $this->items = Item::with('inventoryJoin')
                ->withSum('inventoryJoin as total_stock_quantity', 'current_stock_quantity')
                ->addSelect([
                    'lowest_item_cost' => SupplierItems::select('item_cost')
                        ->whereColumn('supplier_items.item_id', 'items.id')
                        ->orderBy('item_cost', 'asc')
                        ->limit(1)
                ])
                ->get();

            $this->reorderLists = [];

            foreach ($this->items as $item) {
                // Only include items with low stock quantity
                if ($item->inventoryJoin->isNotEmpty() && $item->total_stock_quantity <= $item->reorder_point) {
                    $this->reorderLists[] = $item;
                }
            }
        }

        // Loop through reorderLists and assign the supplier with the lowest cost



    }

}
