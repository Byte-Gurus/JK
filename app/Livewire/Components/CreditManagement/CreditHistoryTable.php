<?php

namespace App\Livewire\Components\CreditManagement;

use App\Models\CreditHistory;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class CreditHistoryTable extends Component
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

        $query = CreditHistory::query();


        if ($this->statusFilter != 0) {
            $query->whereHas('creditJoin', function ($query) {
                $query->where('status', $this->statusFilter);
            });
        }

        $creditHistories = $query->search($this->search) //?search the user
            ->orderBy($this->sortColumn, $this->sortDirection) //? i sort ang column based sa $sortColumn na var
            ->paginate($this->perPage);

        return view('livewire.components.credit-management.credit-history-table', [
            'creditHistories' => $creditHistories
        ]);
    }
    protected $listeners = [
        "echo:refresh-credit,CreditEvent" => 'refreshFromPusher',
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
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function refreshTable()
    {
        $this->resetPage();
    }
    public function refreshFromPusher()
    {
        $this->resetPage();
    }
}
