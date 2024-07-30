<?php

namespace App\Livewire\Components\CustomerCreditManagement;

use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CustomerCreditTable extends Component
{
    public $sortDirection = 'asc'; //var default sort direction is ascending
    public $sortColumn = 'id'; //var defualt sort is ID
    public $perPage = 10; //var for pagination
    public $search = '';  //var search component
    public $imageUrl;
    public $typeFilter = 0; //var filtering value = all
    public function render()
    {
        $query = Customer::query();

        if ($this->typeFilter != 0) {
            $query->where('status_id', $this->typeFilter); //?hanapin ang status na may same value sa statusFilter
        }
        $customers = $query->search($this->search) //?search the user
            ->orderBy($this->sortColumn, $this->sortDirection) //? i sort ang column based sa $sortColumn na var
            ->paginate($this->perPage);  //?  and paginate it

        return view('livewire.components.CustomerCreditManagement.customer-credit-table', compact('customers'));
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



    public function showImage($customer_id)
    {

        $customer = Customer::find($customer_id);
        $this->imageUrl = $customer->id_picture ? Storage::url($customer->id_picture) : null;

    }
}
