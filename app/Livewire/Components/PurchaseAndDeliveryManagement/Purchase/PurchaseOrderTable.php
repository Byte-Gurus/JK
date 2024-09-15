<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase;

use App\Livewire\Components\PurchaseAndDeliveryManagement\PrintPurchaseOrderDetails;
use App\Livewire\Pages\PurchaseAndDeliveryManagementPage;
use App\Livewire\Pages\PurchasePage;
use App\Models\Purchase;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class PurchaseOrderTable extends Component
{
    use WithPagination,  WithoutUrlPagination;
    public $sortDirection = 'desc'; //var default sort direction is ascending
    public $sortColumn = 'id'; //var defualt sort is ID
    public $perPage = 10; //var for pagination
    public $search = '';  //var search component

    public $supplierFilter = 0; //var filtering value = all

    public function render()
    {
        $suppliers = Supplier::select('id', 'company_name')->where('status_id', '1')->get();

        $query = Purchase::query();

        if ($this->supplierFilter != 0) {
            $query->where('supplier_id', $this->supplierFilter); //?hanapin ang status na may same value sa statusFilter
        }
        $purchases = $query->search($this->search) //?search the user
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage); //? i sort ang column based sa $sortColumn

        return view('livewire.components.PurchaseAndDeliveryManagement.Purchase.purchase-order-table', compact('purchases', 'suppliers'));
    }
    protected $listeners = [
        'refresh-table' => 'refreshTable',
        "echo:refresh-purchase-order,PurchaseOrderEvent" => 'refreshFromPusher',
        "echo:refresh-backorder,BackorderEvent" => 'refreshFromPusher',
    ];

    public function sortByColumn($column)
    { //* sort the column

        //* if ang $column is same sa global variable na sortColumn then if ang sortDirection is desc then it will be asc
        if ($this->sortColumn = $column) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            //* if hindi same ang $column sa global variable na sortColumn, then gawing asc ang column
            $this->sortDirection = 'asc';
        }

        $this->sortColumn = $column; //* gawing global variable ang $column
    }

    public function getPO($purchase_id)
    {

        $this->dispatch('edit-po-from-table', purchase_ID: $purchase_id)->to(PurchaseOrderForm::class);

        $this->dispatch('change-method', isCreate: false)->to(PurchaseOrderForm::class);

        $this->dispatch('display-modal', showModal: true)->to(PurchaseOrderForm::class);

        $this->dispatch('display-edit-modal', showEditModal: true)->to(PurchasePage::class);
    }

    public function printPO($purchase_id)
    {
        $this->dispatch('print-po-from-table', purchase_ID: $purchase_id)->to(PrintPurchaseOrderDetails::class);
    }
    public function displayPrintPurchaseOrderDetails()
    {
        $this->dispatch('hide-navbar')->to(PurchaseAndDeliveryManagementPage::class);
        $this->dispatch('display-print-purchase-order-details')->to(PurchasePage::class);
    }

    public function refreshTable()
    {
        $this->resetPage();
    }

    public function displayPurchaseOrderDetails()
    {
        $this->dispatch('display-table')->to(PurchasePage::class);

        $this->dispatch('display-purchase-order-details', viewPurchaseOrderDetails: true)->to(PurchasePage::class);
    }
    public function getPo_ID($po_Id)
    {

        $this->dispatch('view-po', poID: $po_Id)->to(ViewPurchaseOrderDetails::class);
    }
    public function refreshFromPusher()
    {
        $this->resetPage();
    }
}
