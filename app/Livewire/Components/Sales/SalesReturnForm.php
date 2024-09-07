<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;

class SalesReturnForm extends Component
{

    public $showSalesReturnForm = false;
    public $showAdminLoginForm = false;

    public function render()
    {
        return view('livewire.components.sales.sales-return-form');
    }
}
