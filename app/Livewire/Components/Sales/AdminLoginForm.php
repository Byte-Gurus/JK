<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;

class AdminLoginForm extends Component
{

    public $showAdminLoginForm = false;


    public function render()
    {
        return view('livewire.components.sales.admin-login-form');
    }
}
