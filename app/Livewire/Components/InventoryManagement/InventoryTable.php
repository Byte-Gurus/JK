<?php

namespace App\Livewire\Components\InventoryManagement;

use App\Models\Inventory;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class InventoryTable extends Component
{
    use WithPagination,  WithoutUrlPagination;
    public $sortDirection = 'asc'; //var default sort direction is ascending
    public $sortColumn = 'id'; //var defualt sort is ID
    public $perPage = 10; //var for pagination
    public $search = '';  //var search component

    public $statusFilter = 0; //var filtering value = all
    public $vatFilter = 0; //var filtering value = all
    public $supplierFilter = 0;
    public function render()
    {
        $suppliers = Supplier::select('id', 'company_name')->get();

        $query = Inventory::query();

        if ($this->statusFilter != 0) {
            $query->where('status', $this->statusFilter); //?hanapin ang status na may same value sa statusFilter
        }

        if ($this->supplierFilter != 0) {
            // Use whereHas to filter deliveries based on the supplier_id through purchase
            $query->where('supplier_id', $this->supplierFilter); //
        }

        $inventories = $query->search($this->search) //?search the user
            ->orderBy($this->sortColumn, $this->sortDirection) //? i sort ang column based sa $sortColumn na var
            ->paginate($this->perPage);

        return view('livewire.components.InventoryManagement.inventory-table', compact('inventories', 'suppliers'));
    }

    protected $listeners = [
        'refresh-table' => 'refreshTable', //*  galing sa UserTable class

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
}
