<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase;

use App\Livewire\Pages\PurchasePage;
use App\Models\Item;
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
    public $purchase_number;
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

    /**
     * Summary of removeRow
     * unset destroy a variable ($index) that  comes from the array of reorder_list
     * @return void
     */
    public function removeRow($index)
    {
        $this->removed_items = $this->reorder_lists[$index];


        unset($this->reorder_lists[$index]);
        $this->reorder_lists = array_values($this->reorder_lists);
    }
    public function restoreRow($index)
    {

        // Check if the row is in removed_items, then restore it
        if (isset($this->removed_items[$index])) {
            $this->reorder_lists = $this->removed_items[$index]; // Restore the row

            unset($this->removed_items[$index]); // Remove it from removed_items
            $this->removed_items = array_values($this->removed_items); // Reindex the removed items array
        }
    }
    public function getRemainingRows()
    {
        // This method returns the remaining rows and their values
        return $this->reorder_lists;
    }

    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(PurchasePage::class);
    }

    public function generatePurchaseNumber()  //* generate a random barcode and contatinate the ITM
    {

        $randomNumber = random_int(100000, 999999);
        $this->purchase_number = 'PO-' . $randomNumber;
    }


    public function changeMethod($isCreate)
    {
        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        //* kapag true ang laman ng $isCreate mag reset ang form then  go to create form and ishow ang password else hindi ishow
        if ($this->isCreate) {

            $this->generatePurchaseNumber();
            // $this->resetForm();
        } else {
        }
    }

    public function displayModal($showModal)
    {
        $this->showModal = $showModal; //var assign ang parameter value sa global variable

        if ($this->showModal) {
        } else {
        }
    }

    public function formCancel()
    {
        $this->dispatch('form-cancel', showModal: false)->to(PurchasePage::class);
    }

    public function addRows()
    {
        $this->rows[] = [];
    }
}
