<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\UserManagement\UserForm;
use Livewire\Component;

class UserManagementPage extends Component
{
 

    public function render()
    {
        return view('livewire.pages.user-management-page');
    }


    public function formCreate()
    {
        $this->dispatch('change-method', isCreate: true)->to(UserForm::class);
    }


}
