<?php

namespace App\Livewire\Components\CreditManagement;

use App\Livewire\Pages\CreditManagementPage;
use App\Models\Credit;
use Livewire\Component;
use Livewire\WithPagination;

class CreditTable extends Component
{

    use WithPagination;
    public $sortDirection = 'desc'; //var default sort direction is ascending
    public $sortColumn = 'id'; //var defualt sort is ID
    public $perPage = 10; //var for pagination
    public $search = '';  //var search component

    public $statusFilter = 'Pending'; //var filtering value = all
    public $vatFilter = 0; //var filtering value = all
    public $supplierFilter = 0;

    public $startDate, $endDate;

    public $credit_number;
    public function mount($credit_number = null)
    {
        $this->search = $credit_number;
    }


    public function render()
    {
        $query = Credit::query();


        if ($this->statusFilter != 0) {
            $query->where('status', $this->statusFilter); //?hanapin ang status na may same value sa statusFilter
        } else {
        }

        if ($this->credit_number) {
            $this->search = $this->credit_number;
        }

        $credits = $query->search($this->search) //?search the user
            ->orderBy($this->sortColumn, $this->sortDirection) //? i sort ang column based sa $sortColumn na var
            ->paginate($this->perPage);

        return view('livewire.components.CreditManagement.credit-table', [
            'credits' => $credits
        ]);
    }

    protected $listeners = [
        'refresh-table' => 'refreshTable', //*  galing sa UserTable class
        "echo:refresh-credit,CreditEvent" => 'refreshFromPusher',
        'set-search' => 'setSearch'

    ];
    public function setSearch($credit_number)
    {
        $this->search = $credit_number;
    }

    public function refreshTable()
    {
        $this->resetPage();
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

    public function getCredit($credit_id)
    {
        $this->dispatch('credit-payment', credit_ID: $credit_id)->to(CreditPaymentForm::class);
    }

    public function displayCreditPaymentForm()
    {
        $this->dispatch('display-credit-payment-form', showCreditPaymentForm: true)->to(CreditManagementPage::class);
    }

    public function refreshFromPusher()
    {
        $this->resetPage();
    }
}
