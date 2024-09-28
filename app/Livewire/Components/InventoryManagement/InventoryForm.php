<?php

namespace App\Livewire\Components\InventoryManagement;

use Livewire\Component;

class InventoryForm extends Component
{
    public function render()
    {
        return view('livewire.components.InventoryManagement.inventory-form');
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }

    public function resetForm()
    {
        // $this->reset([
        //     'selectOperation',
        //     'adjustReason',
        //     'quantityToAdjust',
        //     'stock_id',
        //     'sku_code',
        //     'item_name',
        //     'current_quantity',
        //     'description',
        //     'selectOperation'
        // ]);
    }
}
