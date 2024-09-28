<?php

namespace App\Livewire\Components\InventoryManagement;

use App\Livewire\Pages\InventoryManagementPage;
use App\Models\Inventory;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class InventoryTable extends Component
{
    use WithPagination,  WithoutUrlPagination;
    public $sortDirection = 'desc'; //var default sort direction is ascending
    public $sortColumn = 'id'; //var defualt sort is ID
    public $perPage = 10; //var for pagination
    public $search = '';  //var search component

    public $statusFilter = 0; //var filtering value = all
    public $vatFilter = 0; //var filtering value = all
    public $supplierFilter = 0;

    public $startDate, $endDate;

    public function render()
    {
        $suppliers = Supplier::select('id', 'company_name')
            ->where('status_id', '1')->get();

        $query = Inventory::query()
            ->where('status', '!=', 'New Item');

        if ($this->statusFilter != 0) {
            $query->where('status', $this->statusFilter); //?hanapin ang status na may same value sa statusFilter
        }

        if ($this->supplierFilter != 0) {
            // Use whereHas to filter deliveries based on the supplier_id through purchase
            $query->whereHas('deliveryJoin.purchaseJoin', function ($query) {
                $query->where('supplier_id', $this->supplierFilter);
            });
        }
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('stock_in_date', [$this->startDate, $this->endDate]);
        }


        $inventories = $query->search($this->search) //?search the user
            ->orderBy($this->sortColumn, $this->sortDirection) //? i sort ang column based sa $sortColumn na var
            ->paginate($this->perPage);

        return view('livewire.components.InventoryManagement.inventory-table', compact('inventories', 'suppliers'));
    }

    protected $listeners = [
        'refresh-table' => 'refreshTable', //*  galing sa UserTable class
        "echo:refresh-adjustment,AdjustmentEvent" => 'refreshFromPusher',
        "echo:refresh-stock,RestockEvent" => 'refreshFromPusher',
        "echo:refresh-transaction,TransactionEvent" => 'refreshFromPusher',
        "echo:refresh-inventory,InventoryEvent" => 'refreshFromPusher',

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

    public function getStockID($stockId)
    {
        $this->dispatch('adjust-stock-from-table', stockID: $stockId)->to(StockAdjustForm::class);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function refreshTable()
    {
        $this->resetPage();
    }

    public function displayInventoryForm()
    {
        $this->dispatch('display-inventory-form')->to(InventoryManagementPage::class);
    }

    public function displayStockAdjustPage()
    {
        $this->dispatch('display-stock-adjust-page')->to(InventoryManagementPage::class);
    }

    public function displayStockCard()
    {
        $this->dispatch('display-inventory-table', showInventoryTable: false)->to(InventoryManagementPage::class);
        $this->dispatch('display-stock-card', showStockCard: true)->to(InventoryManagementPage::class);
    }

    public function getStock($stockId)
    {

        $this->dispatch('stock-card', stockID: $stockId)->to(ViewStockCard::class);
    }

    public function refreshFromPusher()
    {
        $this->resetPage();
    }
}
