<?php

namespace App\Livewire\Components\InventoryManagement;

use App\Models\Inventory;
use App\Models\InventoryAdjustment;
use App\Models\InventoryMovement;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;


class InventoryHistory extends Component
{

    use WithPagination,  WithoutUrlPagination;
    public $sortDirection = 'asc'; //var default sort direction is ascending
    public $sortColumn = 'id'; //var defualt sort is ID
    public $perPage = 10; //var for pagination
    public $search = '';  //var search component

    public $statusFilter = 0; //var filtering value = all
    public $movementFilter = 0;
    public $vatFilter = 0; //var filtering value = all

    public $operationFilter = 0;
    public function render()
    {



        $query = InventoryMovement::query();

        if ($this->statusFilter != 0) {
            $query->whereHas('inventoryJoin.adjustmentJoin', function ($query) {
                $query->where('status', $this->statusFilter);
            });
        }

        if ($this->movementFilter != 0) {
            $query->where('movement_type', $this->movementFilter); //?hanapin ang status na may same value sa statusFilter
        }

        if ($this->operationFilter != 0) {
            $query->where('operation', $this->operationFilter); //?hanapin ang status na may same value sa statusFilter
        }


        $InventoryHistory = $query->search($this->search) //?search the user
            ->orderBy($this->sortColumn, $this->sortDirection) //? i sort ang column based sa $sortColumn na var
            ->paginate($this->perPage);

        return view('livewire.components.InventoryManagement.inventory-history', [
            'InventoryHistories' => $InventoryHistory
        ]);
    }

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
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function refreshTable()
    {
        $this->resetPage();
    }
}
