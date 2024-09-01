<?php

namespace App\Livewire\Components\CreditManagement;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreditForm extends Component
{
    use LivewireAlert;

    public $isCreate;
    public function render()
    {
        return view('livewire.components.CreditManagement.credit-form');
    }

    protected $listeners = [
        'edit-supplier-from-table' => 'edit',  //* key:'edit-supplier-from-table' value:'edit'  galing sa SupplierTable class
        //* key:'change-method' value:'changeMethod' galing sa SupplierTable class,  laman false
        'change-method' => 'changeMethod',
        'updateConfirmed',
        'createConfirmed',
    ];

    public function resetFormWhenClosed()
    {
        // $this->resetForm();
        // $this->resetValidation();
        // $this->cities = null;
        // $this->barangays = null;
    }

    public function changeMethod($isCreate)
    {
        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        if ($this->isCreate) {

            // $this->resetForm();
        }
    }
}
