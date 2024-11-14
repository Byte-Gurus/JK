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



    public $items, $selectAll, $isAnyChecked, $orderTotal = 0.00;

    public $reorderLists = [], $toOrderItems = [], $selectedItems = [], $purchaseQuantities = [], $selectSuppliers = [], $po_numbers = [], $lowestSupplier = [], $orders = [], $clickRemove = [];
    public $search = '';


    public function render()
    {
        $suppliers = Supplier::select('id', 'company_name')->where('status_id', '1')->get();

        $this->isAnyChecked = in_array(true, $this->toOrderItems, true);


        $orderItemIds = array_map(function ($order) {
            return $order['item']->id;
        }, $this->orders);

        $this->items = Item::with('inventoryJoin')
            ->withSum('inventoryJoin as total_stock_quantity', 'current_stock_quantity')
            ->orderBy('total_stock_quantity', 'asc')
            ->whereNotIn('id', $orderItemIds)
            ->get();

        $this->reorderLists = [];

        if (empty($this->search)) {

            foreach ($this->items as $item) {
                // Only include items with low stock quantity
                if ($item->inventoryJoin->isNotEmpty() && $item->total_stock_quantity <= $item->reorder_point) {
                    $this->reorderLists[] = $item;
                }
            }
        } else {
            $this->items = Item::withSum('inventoryJoin as total_stock_quantity', 'current_stock_quantity')
                ->whereRaw('LOWER(item_name) like ?', ["%{$this->search}%"])
                ->orWhereRaw('LOWER(item_description) like ?', ["%{$this->search}%"])
                ->get();


            $this->reorderLists = [];

            foreach ($this->items as $item) {
                // Check if item is already in orders
                $itemInOrders = false;
                foreach ($this->orders as $order) {
                    if ($order['item']->id == $item->id) {
                        $itemInOrders = true;
                        break;
                    }
                }

                // Ensure the item matches your criteria and is not in orders
                if ($item->inventoryJoin->isNotEmpty() && !$itemInOrders) {
                    $this->reorderLists[] = $item;
                }
            }
        }

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


        foreach ($this->orders as $index => $order) {

            $this->orderTotal = 0;

            if ($order['supplierItem'] !== null) {
                // Assuming supplierItem has a property like 'item_cost' to sum
                $itemCost = $order['supplierItem']->item_cost ?? 0; // Replace 'item_cost' with the actual property
                $purchaseQuantity = $order['purchaseQuantities'];
                $this->orderTotal += $itemCost * $purchaseQuantity;
            } else {
                // Handle cases where supplierItem is null
                // You might want to log this or handle it in some way
                // For now, we'll just skip it
                continue;
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

        $this->confirm('Do you want to create this purchase order?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
        ]);
    }

    public function createConfirmed()
    {

        DB::beginTransaction();

        try {
            // Group items by supplier and combine quantities
            $groupedItemsBySupplier = [];

            // Loop through orders to group items by supplier
            foreach ($this->orders as $order) {
                $supplierId = $order['supplier']->id;  // Assuming the supplier object is in the 'supplier' key
                $itemId = $order['item']->id;  // Assuming the item object is in the 'item' key
                $quantity = $order['purchaseQuantities'];  // Assuming 'purchaseQuantities' holds the quantity

                // Initialize the supplier group if it doesn't exist
                if (!isset($groupedItemsBySupplier[$supplierId])) {
                    $groupedItemsBySupplier[$supplierId] = [];
                }

                // If the item already exists for this supplier, add to quantity
                if (isset($groupedItemsBySupplier[$supplierId][$itemId])) {
                    $groupedItemsBySupplier[$supplierId][$itemId]['quantity'] += $quantity;
                } else {
                    // Otherwise, add the item with its quantity
                    $groupedItemsBySupplier[$supplierId][$itemId] = [
                        'item' => $order['item'],
                        'quantity' => $quantity,
                    ];
                }
            }

            // Process each supplier's grouped items
            foreach ($groupedItemsBySupplier as $supplierId => $items) {
                $poNumber = $this->generatePurchaseOrderNumber();

                // Ensure the purchase order number is unique
                $existingPurchaseOrder = Purchase::where('po_number', $poNumber)->first();
                if ($existingPurchaseOrder) {
                    $this->alert('error', 'Purchase order number already exists.');
                    return;
                }

                // Create the purchase order for the supplier
                $purchase_order = Purchase::create([
                    'po_number' => $poNumber,
                    'supplier_id' => $supplierId,
                    'user_id' => Auth::id(),
                ]);

                // Create the delivery for the purchase order
                $delivery = Delivery::create([
                    'status' => "In Progress",
                    'date_delivered' => "N/A",
                    'purchase_id' => $purchase_order->id
                ]);

                // Create purchase details for each item
                foreach ($items as $itemData) {
                    $selectedItem = $itemData['item'];
                    $combinedQuantity = $itemData['quantity'];

                    // Create purchase details with the combined quantity
                    PurchaseDetails::create([
                        'purchase_id' => $purchase_order->id,
                        'item_id' => $selectedItem->id,  // Use item_id from selected items
                        'po_number' => $purchase_order->po_number,
                        'purchase_quantity' => $combinedQuantity,
                    ]);
                }
            }

            // Log the creation
            $userName = Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname;
            Log::create([
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
            $this->alert('error', 'An error occurred while creating the purchase order, please refresh the page');
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



    }

    public function getSelectedItems()
    {

        $validated = $this->validateForm();

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


            unset($this->selectedItems[$index]);
            unset($this->toOrderItems[$index]);
            unset($this->purchaseQuantities[$index]);
            unset($this->selectSuppliers[$index]);
            unset($this->po_numbers[$index]);
        }

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
            'lowestSupplier' => $this->lowestSupplier,
            'orders' => $this->orders
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


    public function removeItem($index)
    {
        if (isset($this->orders[$index]['supplierItem']) && $this->orders[$index]['supplierItem'] !== null) {
            $itemCost = $this->orders[$index]['supplierItem']->item_cost ?? 0; // Replace 'item_cost' with the actual property
            $purchaseQuantity = $this->orders[$index]['purchaseQuantities'];
            $this->orderTotal -= $itemCost * $purchaseQuantity;
        }

        unset($this->orders[$index]);

        $this->orders = array_values($this->orders);
    }


    private function resetForm() //*tanggalin ang laman ng input pati $item_id value
    {

        $this->reset(['po_numbers', 'items', 'selectAll', 'selectSuppliers', 'reorderLists', 'toOrderItems', 'selectedItems', 'purchaseQuantities', 'search', 'lowestSupplier', 'orders']);
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



        // Loop through reorderLists and assign the supplier with the lowest cost



    }

}
