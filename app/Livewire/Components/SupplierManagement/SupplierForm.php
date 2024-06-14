<?php

namespace App\Livewire\Components\SupplierManagement;

use Livewire\Component;

class SupplierForm extends Component
{

    public $isCreate; //var true for create false for edit

    //var form inputs
    public $supplier_id, $company_name, $contact_no, $province_id, $city, $brgy_id;

    public function render()
    {
        return view('livewire.components.SupplierManagement.supplier-form');
    }

    //* assign all the listners in one array
    //* for methods
    protected $listeners = [
        'edit-user-from-table' => 'edit',  //* key:'edit-user-from-table' value:'edit'  galing sa UserTable class
        //* key:'change-method' value:'changeMethod' galing sa UserTable class,  laman false
        'change-method' => 'changeMethod',
        'updateConfirmed',
        'createConfirmed',
    ];


    public function edit($supplierID)
    {
        $this->supplier_id = $supplier_id; //var assign ang parameter value sa global variable
    }

    private function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        $this->reset(['company_name', 'contact_no', 'province_id', 'city', 'brgy_id', 'supplier_id']);
    }

    //* pag iclose ang form using close hindi natatanggal ang validation, this method resets form input and validation
    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }
}
