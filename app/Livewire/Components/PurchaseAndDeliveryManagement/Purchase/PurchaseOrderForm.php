<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase;

use App\Livewire\Pages\PurchasePage;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PurchaseOrderForm extends Component
{

    use LivewireAlert;

    public $isCreate;

    public $showModal;
    public $selectAllToRestore = false;
    public $selectAllToRemove = false;
    public $reorder_lists = [];
    public $supplier, $purchase_number, $proxy_purchase_number;
    public $purchase_quantities = [];
    public $removed_items = [];
    public $selectedToRemove = [];
    public $selectedToRestore = [];
    public $isReorderListsCleared = false;
    public $edit_reorder_lists = [];

    public $filtered_reorder_lists = [];

    public $index;
    public $isDisabled;

    /**
     * Summary of render
     * $suppliers gets the supplier id company name
     * $reorder_lists gets all the attributs in both table( inventory, item) but it ensures that the attributes form item table will return even if they don't have records in the inventory
     * DB:RAW COALESCE gets the sum of all quantities from inventory table and if no records then it will be 0
     * DB:RAW MAX sort the inventory status value in order
     * ->where filter out all the status_id that has value of 2 (Inactive), <> means not equal to
     * ->groupBy this is need to identify what columns to show especially when theres sum and max (aggregiate functions)
     * ->havingRaw has a condition and ensure that this columns gets retrieve
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $suppliers = Supplier::select('id', 'company_name')->get();


        if (empty($this->reorder_lists) && !$this->isReorderListsCleared) {
            $this->reorder_lists = Item::join('inventories', 'items.id', '=', 'inventories.item_id')
                ->select(
                    'items.id as item_id',
                    'items.barcode',
                    'items.item_name',
                    'items.reorder_point',
                    'items.status_id',
                    DB::raw('
                        COALESCE(SUM(inventories.current_stock_quantity), 0) -
                        COALESCE(SUM(CASE WHEN inventories.status = "Expired" THEN inventories.current_stock_quantity ELSE 0 END), 0) as total_quantity
                    '),
                    DB::raw('MAX(inventories.status) as inventory_status')
                )
                ->where('items.status_id', 1) // Ensure items are active
                // Ensure inventory status is Active
                ->groupBy(
                    'items.id',
                    'items.barcode',
                    'items.item_name',
                    'items.reorder_point',
                    'items.status_id'
                )
                ->havingRaw('total_quantity <= items.reorder_point') // Include items below reorder point
                ->get()
                ->toArray();
        }

        return view('livewire.components.PurchaseAndDeliveryManagement.Purchase.purchase-order-form', [
            'suppliers' => $suppliers,
            'reorder_lists' => $this->reorder_lists,
            'edit_reorder_lists' => $this->edit_reorder_lists,
            'filtered_reorder_lists' => $this->filtered_reorder_lists
        ]);
    }


    protected $listeners = [
        'edit-po-from-table' => 'edit',
        'change-method' => 'changeMethod',
        'display-modal' => 'displayModal',
        'updateConfirmed',
        'createConfirmed',
    ];


    public function removeRow()
    {
        if ($this->isCreate) {
            foreach ($this->selectedToRemove as $index) {
                if (isset($this->reorder_lists[$index])) {
                    $this->removed_items[] = [
                        'item_id' => $this->reorder_lists[$index]['item_id'],
                        'barcode' => $this->reorder_lists[$index]['barcode'],
                        'item_name' => $this->reorder_lists[$index]['item_name'],
                        'total_quantity' => $this->reorder_lists[$index]['total_quantity'],
                        'reorder_point' => $this->reorder_lists[$index]['reorder_point'],
                    ];
                }
            }

            // Remove the selected items from reorder_lists
            foreach ($this->selectedToRemove as $index) {
                unset($this->reorder_lists[$index]);
            }

            // Reindex the array after removal
            $this->reorder_lists = array_values($this->reorder_lists);


            // Clear the selected items array
            $this->selectedToRemove = [];

            // Check if all rows are removed
            if (empty($this->reorder_lists)) {
                $this->isReorderListsCleared = true;
            }
            $this->selectAllToRemove = false;
        } else {
            foreach ($this->selectedToRemove as $index) {
                if (isset($this->edit_reorder_lists[$index])) {
                    $this->filtered_reorder_lists[] = [
                        'item_id' => $this->edit_reorder_lists[$index]['item_id'],
                        'barcode' => $this->edit_reorder_lists[$index]['barcode'],
                        'item_name' => $this->edit_reorder_lists[$index]['item_name'],
                        'total_quantity' => $this->edit_reorder_lists[$index]['total_quantity'],
                        'reorder_point' => $this->edit_reorder_lists[$index]['reorder_point'],
                    ];
                }
            }

            foreach ($this->selectedToRemove as $index) {
                unset($this->edit_reorder_lists[$index]);
            }
            $this->reorder_lists = array_values($this->reorder_lists);

            $this->selectedToRemove = [];

            if (empty($this->edit_reorder_lists)) {
                $this->isReorderListsCleared = true;
            }

            $this->selectAllToRemove = false;
        }
    }

    public function restoreRow()
    {
        if ($this->isCreate) {
            foreach ($this->selectedToRestore as $index) {

                // Add the item back to reorder_lists
                $this->reorder_lists[] = $this->removed_items[$index];
                unset($this->removed_items[$index]);
            }

            $this->reorder_lists = array_values($this->reorder_lists);


            $this->selectedToRestore = [];
            $this->selectAllToRestore = false;
        } else {
            foreach ($this->selectedToRestore as $index) {

                // Add the item back to reorder_lists
                $this->edit_reorder_lists[] = $this->filtered_reorder_lists[$index];
                unset($this->filtered_reorder_lists[$index]);
            }

            $this->edit_reorder_lists = array_values($this->edit_reorder_lists);


            $this->selectedToRestore = [];
            $this->selectAllToRestore = false;
        }
    }
    public function removeAll()
    {

        if ($this->isCreate) {
            if ($this->selectAllToRemove) {
                $this->selectedToRemove = array_keys($this->reorder_lists);
            } else {
                $this->selectedToRemove = [];
            }
        } else {
            if ($this->selectAllToRemove) {
                $this->selectedToRemove = array_keys($this->edit_reorder_lists);
            } else {
                $this->selectedToRemove = [];
            }
        }
    }

    public function restoreAll()
    {
        if ($this->isCreate) {
            if ($this->selectAllToRestore) {
                $this->selectedToRestore = array_keys($this->removed_items);
            } else {
                $this->selectedToRestore = [];
            }
        } else {
            if ($this->selectAllToRestore) {
                $this->selectedToRestore = array_keys($this->filtered_reorder_lists);
            } else {
                $this->selectedToRestore = [];
            }
        }
    }


    public function create() //* create process
    {


        $validated = $this->validateForm();

        $this->confirm('Do you want to add this user?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' =>  $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }

    public function createConfirmed($data) //* confirmation process ng create
    {

        $validated = $data['inputAttributes'];

        $purchase_order = Purchase::create([
            'po_number' => $validated['purchase_number'],
            'supplier_id' => $validated['supplier'],

        ]);


        foreach ($this->reorder_lists as $index => $reorder_list) {
            PurchaseDetails::create([
                'item_id' => $reorder_list['item_id'], // Use item_id from reorder_list
                'po_number' => $validated['purchase_number'],
                'purchase_quantity' => $this->purchase_quantities[$index],
            ]);
        }


        $this->alert('success', 'Purchase order was created successfully');
        $this->refreshTable();

        redirect()->route('purchaseanddeliverymanagement.index');
        $this->resetForm();
        $this->closeModal();
    }

    public function update() //* update process
    {
        $validated = $this->validateForm();


        $purchase = Purchase::where('po_number', $this->proxy_purchase_number)->first();; //? kunin lahat ng data ng may ari ng proxy_item_id

        $purchase->supplier_id = $validated['supplier'];
        $purchase->po_number = $validated['purchase_number'];

        $attributes = $purchase->toArray();


        $this->confirm('Do you want to update this supplier?', [
            'onConfirmed' => 'updateConfirmed', //* call the confmired method
            'inputAttributes' =>  $attributes, //* pass the $attributes array to the confirmed method
        ]);
    }

    public function updateConfirmed($data) //* confirmation process of update
    {

        $updatedAttributes = $data['inputAttributes'];

        // Find the Purchase model using the ID
        $purchase = Purchase::where('po_number', $updatedAttributes['po_number'])->first();

        // Update the Purchase model with the attributes from the confirmation
        $purchase->fill($updatedAttributes);

        // Save the updated Purchase model to the database
        $purchase->save();

        // Handle the updating of PurchaseDetails
        foreach ($this->edit_reorder_lists as $index => $reorder_list) {
            $purchaseDetail = PurchaseDetails::where('po_number', $purchase->po_number)
                ->where('item_id', $reorder_list['item_id'])
                ->first();

            if ($purchaseDetail) {
                $purchaseDetail->purchase_quantity = $this->purchase_quantities[$index];
                $purchaseDetail->save();
            } else {
                PurchaseDetails::create([
                    'item_id' => $this->edit_reorder_lists[$index]['item_id'],
                    'po_number' => $this->proxy_purchase_number,
                    'purchase_quantity' => $this->purchase_quantities[$index],
                ]);
            }
        }

        $this->resetForm();
        $this->alert('success', 'Purchase order was updated successfully');

        $this->refreshTable();
        $this->closeModal();
    }

    protected function validateForm()
    {

        $rules = [
            'purchase_number' => 'required|string|max:255',
            'supplier' => 'required|numeric',
        ];

        if ($this->isCreate) {
            // Add validation rules for each purchase quantity
            foreach ($this->reorder_lists as $index => $reorder_list) {
                $rules["purchase_quantities.$index"] = ['required', 'numeric'];
            }
        } else {
            foreach ($this->edit_reorder_lists as $index => $reorder_list) {
                $rules["purchase_quantities.$index"] = ['required', 'numeric'];
            }
        }


        return $this->validate($rules);
    }

    public function closeModal() //* close ang modal after confirmation
    {

        $this->dispatch('close-modal')->to(PurchasePage::class);
    }
    private function resetForm() //*tanggalin ang laman ng input pati $item_id value
    {
        $this->reset(['purchase_number', 'proxy_purchase_number', 'purchase_quantities', 'supplier', 'removed_items', 'selectedToRemove', 'edit_reorder_lists', 'selectAllToRemove', 'selectAllToRestore']);
    }
    public function populateForm()
    {
        // Retrieve purchase details along with item data
        $purchaseDetails = PurchaseDetails::with('purchaseJoin')
            ->where('po_number', $this->purchase_number)
            ->get();

        $purchase = Purchase::where('po_number', $this->purchase_number)->first();

        foreach ($purchaseDetails as $index => $detail) {
            // Get the item details including total quantity from inventories
            $item = Item::select('id', 'barcode', 'item_name', 'item_description')
                ->leftJoin('inventories', 'items.id', '=', 'inventories.item_id')
                ->select(
                    'items.id as item_id',
                    'items.barcode',
                    'items.item_name',
                    'items.reorder_point',
                    DB::raw('COALESCE(SUM(inventories.current_stock_quantity), 0) as total_quantity')
                )
                ->where('items.id', $detail->item_id)
                ->groupBy('items.id', 'items.barcode', 'items.item_name', 'items.reorder_point')
                ->first();

            // If the item was found, add to reorder lists
            if ($item) {
                $this->edit_reorder_lists[] = [
                    'item_id' => $item->item_id,
                    'barcode' => $item->barcode,
                    'item_name' => $item->item_name,
                    'total_quantity' => $item->total_quantity, // Use the calculated total_quantity
                    'reorder_point' => $item->reorder_point, // Adjust this based on your needs

                ];

                $this->purchase_quantities[$index] = $detail->purchase_quantity;
            }
        }

        $this->supplier = $purchase->supplier_id;
    }

    public function compareAndFilterLists()
    {
        $filteredReorderLists = [];

        // Loop through reorder_lists and check if each item exists in edit_reorder_lists
        foreach ($this->reorder_lists as $reorder_item) {
            $exists_in_edit = false;

            foreach ($this->edit_reorder_lists as $edit_item) {
                if ($reorder_item['barcode'] === $edit_item['barcode']) {
                    $exists_in_edit = true;
                    break;
                }
            }

            // If the item does not exist in edit_reorder_lists, add it to unique_items
            if (!$exists_in_edit) {
                $filteredReorderLists[] = $reorder_item;
            }
        }

        // Loop through edit_reorder_lists and check if each item exists in reorder_lists
        foreach ($this->edit_reorder_lists as $edit_item) {
            $exists_in_reorder = false;

            foreach ($this->reorder_lists as $reorder_item) {
                if ($edit_item['barcode'] === $reorder_item['barcode']) {
                    $exists_in_reorder = true;
                    break;
                }
            }

            // If the item does not exist in reorder_lists, add it to unique_items
            if (!$exists_in_reorder) {
                $filteredReorderLists[] = $edit_item;
            }
        }

        // Now you have the filtered items that were not in edit_reorder_lists
        $this->filtered_reorder_lists = $filteredReorderLists;
    }



    public function edit($purchase_Number)
    {

        $this->resetForm();
        $this->purchase_number = $purchase_Number; //var assign ang parameter value sa global variable
        $this->proxy_purchase_number = $purchase_Number;  //var proxy_supplier_id para sa update ng supplier kasi i null ang supplier id sa update afetr populating the form


        $this->populateForm();
        $this->compareAndFilterLists();
    }
    public function generatePurchaseOrderNumber()  //* generate a random barcode and contatinate the ITM
    {

        $randomNumber = random_int(100000, 999999);
        $this->purchase_number = 'PO-' . $randomNumber;
    }

    public function refreshTable() //* refresh ang table after confirmation
    {
        $this->dispatch('refresh-table')->to(PurchaseOrderTable::class);
    }

    public function changeMethod($isCreate)
    {

        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        //* kapag true ang laman ng $isCreate mag reset ang form then  go to create form and ishow ang password else hindi ishow
        if ($this->isCreate) {
            $this->resetForm();
            $this->generatePurchaseOrderNumber();
            $this->isReorderListsCleared = false;
            // $this->resetForm();
        }
        $this->dispatch('display-modal', isCreate: false)->to(PurchasePage::class);
    }

    public function displayModal($showModal)
    {

        $this->showModal = $showModal; //var assign ang parameter value sa global variable

    }


    public function addRows() {}
}
