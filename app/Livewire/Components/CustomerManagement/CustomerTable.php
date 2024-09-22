<?php

namespace App\Livewire\Components\CustomerManagement;

use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class CustomerTable extends Component
{
    use WithPagination,  WithoutUrlPagination;
    public $sortDirection = 'desc'; //var default sort direction is ascending
    public $sortColumn = 'id'; //var defualt sort is ID
    public $perPage = 10; //var for pagination
    public $search = '';  //var search component
    public $imageUrl;
    public $typeFilter = 0; //var filtering value = all

    public $hideImage = 0;
    public function render()
    {
        $query = Customer::query();

        if ($this->typeFilter != 0) {
            $query->where('customer_type', $this->typeFilter); //?hanapin ang status na may same value sa statusFilter
        }
        $customers = $query->search($this->search) //?search the user
            ->orderBy($this->sortColumn, $this->sortDirection) //? i sort ang column based sa $sortColumn na var
            ->paginate($this->perPage);  //?  and paginate it

        return view('livewire.components.customer-management.customer-table', compact('customers'));
    }

    protected $listeners = [
        'refresh-table' => 'refreshTable', //*  galing sa UserTable class
        "echo:refresh-customer,CustomerEvent" => 'refreshFromPusher',

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

    public function getCustomerID($customerId)
    {
        //*call the listesner 'edit-supplier-from-table' galing sa UserForm class
        //@params supplierID name ng parameter na ipapasa, $supplierId parameter value na ipapasa
        $this->dispatch('edit-supplier-from-table', customerID: $customerId)->to(CustomerForm::class);

        //*call the listesner 'change-method' galing sa SupplierForm class
        //@params isCerate name ng parameter na ipapasa, false parameter value na ipapasa, false kasi d ka naman mag create supplier
        $this->dispatch('change-method', isCreate: false)->to(CustomerForm::class);
    }

    public function showImage($customer_id)
    {
        $customer = Customer::find($customer_id);
        $this->imageUrl = Storage::disk('r2')->get($customer->id_pictures) ?? null;
    }
    public function refreshFromPusher()
    {
        $this->resetPage();
    }
}
