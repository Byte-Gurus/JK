<?php

namespace App\Livewire\Components\CustomerCreditManagement;

use Livewire\Component;

class CustomerCreditForm extends Component
{
    public $isCreate; //var true for create false for edit
    public function render()
    {
        return view('livewire.components.CustomerCreditManagement.customer-credit-form');
    }
}
