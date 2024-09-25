<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;

class SalesAdminLoginForm extends Component
{

    public $showSalesAdminLoginForm = false;

    public $showPassword = false;


    public function render()
    {
        return view('livewire.components.Sales.sales-admin-login-form');
    }

    public function closeSalesAdminLoginForm()
    {
        $this->dispatch('return-sales-return-details')->to(SalesReturnDetails::class);
    }

    public function showPasswordStatus()
    {
        $this->showPassword = !$this->showPassword;
    }
}
