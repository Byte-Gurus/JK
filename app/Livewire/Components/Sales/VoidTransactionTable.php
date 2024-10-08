<?php

namespace App\Livewire\Components\Sales;

use App\Models\VoidTransaction;
use App\Models\VoidTransactionDetails;
use Illuminate\Support\Carbon;
use Livewire\Component;

class VoidTransactionTable extends Component
{
    public $sortDirection = 'desc'; //var default sort direction is ascending
    public $sortColumn = 'id'; //var defualt sort is ID
    public $perPage = 10; //var for pagination
    public $search = '';
    public $startDate, $endDate;
    public function render()
    {
        $query = VoidTransaction::query();

        if ($this->startDate && $this->endDate) {
            $startDate = Carbon::parse($this->startDate)->startOfDay();
            $endDate = Carbon::parse($this->endDate)->endOfDay();
            $query->whereBetween('stock_in_date', [$startDate, $endDate]);
        }

        $voidTransactions = $query->search($this->search) //?search the user
        ->orderBy($this->sortColumn, $this->sortDirection) //? i sort ang column based sa $sortColumn na var
        ->paginate($this->perPage);

        return view('livewire.components.Sales.void-transaction-table', [
            'voidTransactions' => $voidTransactions
        ]);
    }

    protected $listeners = [
        'refresh-table' => 'refreshTable', //*  galing sa UserTable class
        "echo:refresh-void,VoidEvent" => 'refreshFromPusher',

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

    public function displayVoidTransactionDetails()
    {
        $this->dispatch('display-void-transaction-details', showVoidTransactionDetails: true)->to(VoidTransactionPage::class);
    }

    public function getVoid($voidTransaction_id)
    {
        $this->dispatch('get-void', voidTransaction_ID: $voidTransaction_id)->to(ViewVoidTransactionDetails::class);
    }
    public function refreshFromPusher()
    {
        $this->resetPage();
    }
}
