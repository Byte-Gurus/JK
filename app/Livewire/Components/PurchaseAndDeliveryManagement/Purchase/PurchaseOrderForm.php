<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase;

use App\Livewire\Pages\PurchasePage;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PurchaseOrderForm extends Component
{

    use LivewireAlert;

    public $isCreate;
    public $rows = [];
    public $reorder_lists = [];
    public $purchase_number;
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
                DB::raw('COALESCE(SUM(inventories.quantity), 0) as total_quantity'),
                DB::raw('MAX(inventories.status) as inventory_status')
            )
            ->where('items.status_id', '<>', '2') // Replace 'inactive_status_id' with the actual value representing inactive status
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
        'edit-user-from-table' => 'edit',  //* key:'edit-user-from-table' value:'edit'  galing sa UserTable class
        //* key:'change-method' value:'changeMethod' galing sa UserTable class,  laman false
        'change-method' => 'changeMethod',
        'updateConfirmed',
        'createConfirmed',
    ];

    public function removeRow($index)
    {
        unset($this->reorder_lists[$index]);
        $this->reorder_lists = array_values($this->reorder_lists); // Reindex the array
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

        dd("sasa");
        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        //* kapag true ang laman ng $isCreate mag reset ang form then  go to create form and ishow ang password else hindi ishow
        if ($this->isCreate) {


            // $this->resetForm();
        } else {
        }
    }

    public function addRows()
    {
        $this->rows[] = [];
    }
}
