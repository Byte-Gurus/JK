<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase;

use App\Livewire\Pages\PurchasePage;
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

    public $rows = [];
    public $reorder_lists = [];
    public $po_number, $supplier;
    public $purchase_quantities = [];
    public $removed_items = [];

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

        if (empty($this->reorder_lists)) {
            $this->reorder_lists = Item::leftJoin('inventories', 'items.id', '=', 'inventories.item_id')
                ->select(
                    'items.id as item_id',
                    'items.barcode',
                    'items.item_name',
                    'items.item_description',
                    'items.maximum_stock_ratio',
                    'items.reorder_percentage',
                    'items.reorder_point',
                    'items.vat_amount',
                    'items.vat_type',
                    'items.status_id',
                    DB::raw('COALESCE(SUM(inventories.current_stock_quantity), 0) as total_quantity'),
                    DB::raw('MAX(inventories.status) as inventory_status')
                )
                ->where('items.status_id', '<>', '2')
                ->groupBy(
                    'items.id',
                    'items.barcode',
                    'items.item_name',
                    'items.item_description',
                    'items.maximum_stock_ratio',
                    'items.reorder_percentage',
                    'items.reorder_point',
                    'items.vat_amount',
                    'items.vat_type',
                    'items.status_id'
                )
                ->havingRaw('total_quantity = 0 OR inventory_status = "Available"')
                ->get()
                ->toArray();
        }

        return view('livewire.components.PurchaseAndDeliveryManagement.Purchase.purchase-order-form', [
            'suppliers' => $suppliers,
            'reorder_lists' => $this->reorder_lists,
        ]);
    }


    protected $listeners = [
        'edit-user-from-table' => 'edit',
        'change-method' => 'changeMethod',
        'display-modal' => 'displayModal',
        'updateConfirmed',
        'createConfirmed',
    ];


    public function removeRow($index)
    {
        // Store the removed item
        $this->removed_items[] = $this->reorder_lists[$index];
        unset($this->reorder_lists[$index]);
    }
    public function restoreRow($index)
    {
        // Check if the index exists in the removed items array
        if (isset($this->removed_items[$index])) {
            // Restore the item to reorder_lists
            $this->reorder_lists[] = $this->removed_items[$index];

            // Remove the item from removed_items
            unset($this->removed_items[$index]);

            // Reindex the removed_items array
            $this->removed_items = array_values($this->removed_items);
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
            'po_number' => $this->po_number,
            'supplier_id' => $this->supplier,

        ]);


        foreach ($this->reorder_lists as $index => $reorder_list) {
            PurchaseDetails::create([
                'item_id' => $reorder_list['item_id'], // Use item_id from reorder_list
                'po_number' => $this->po_number,
                'purchase_quantity' => $this->purchase_quantities[$index],
            ]);
        }


        $this->alert('success', 'Purchase order was created successfully');
        // $this->refreshTable();

        // $this->resetForm();
        // $this->closeModal();
    }

    protected function validateForm()
    {

        $rules = [
            'po_number' => 'required|string|max:255',
        ];

        // Add validation rules for each purchase quantity
        foreach ($this->reorder_lists as $index => $reorder_list) {
            $rules["purchase_quantities.$index"] = ['required', 'numeric'];
        }

        return $this->validate($rules);
    }

    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(PurchasePage::class);
    }

    public function generatePurchaseOrderNumber()  //* generate a random barcode and contatinate the ITM
    {

        $randomNumber = random_int(100000, 999999);
        $this->po_number = 'PO-' . $randomNumber;
    }


    public function changeMethod($isCreate)
    {
        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        //* kapag true ang laman ng $isCreate mag reset ang form then  go to create form and ishow ang password else hindi ishow
        if ($this->isCreate) {

            $this->generatePurchaseOrderNumber();
            // $this->resetForm();
        } else {
        }
    }

    public function displayModal($showModal)
    {
        $this->showModal = $showModal; //var assign ang parameter value sa global variable

    }


    public function addRows()
    {
        $this->rows[] = [];
    }
}
