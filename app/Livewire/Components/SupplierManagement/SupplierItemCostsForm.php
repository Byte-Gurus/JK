<?php

namespace App\Livewire\Components\SupplierManagement;

use Livewire\Component;

class SupplierItemCostsForm extends Component
{
    public $isCreateSupplierItemCosts = true;

    public function render()
    {
        return view('livewire.components.SupplierManagement.supplier-item-costs-form');
    }

    protected $listeners = [
        'edit-supplier-item-costs-from-table' => 'edit',  //* key:'edit-supplier-from-table' value:'edit'  galing sa SupplierTable class
        //* key:'change-method' value:'changeMethod' galing sa SupplierTable class,  laman false
        'change-method' => 'changeMethod',
        'updateConfirmed',
        'createConfirmed',
    ];

    private function resetForm() //*tanggalin ang laman ng input pati $supplier_id value
    {
        $this->reset();
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }

    public function changeMethod($isCreateSupplierItemCosts)
    {
        $this->isCreateSupplierItemCosts = $isCreateSupplierItemCosts; //var assign ang parameter value sa global variable

        if ($this->isCreateSupplierItemCosts) {
            // $this->status = 1;
            $this->resetForm();
        }
    }
}
