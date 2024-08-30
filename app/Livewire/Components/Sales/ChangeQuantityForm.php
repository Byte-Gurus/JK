<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;

class ChangeQuantityForm extends Component
{

    public $change_quantity;

    public function render()
    {
        return view('livewire.components.sales.change-quantity-form');
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        // $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset([
            'change_quantity'
        ]);
    }
}
