<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\UserManagement\UserForm;
use Livewire\Component;

class UserManagementPage extends Component
{

    public $showModal = false;
    public $sidebarStatus;

    public function render()
    {
        return view('livewire.pages.user-management-page');
    }


    protected $listeners = [
        'close-modal' => 'closeModal',
        'change-sidebar-status' => 'changeSidebarStatus'
        ];

    public function closeModal(){
        $this->showModal = false;
    }


    public function formCreate()
    {
        $this->dispatch('change-method', isCreate: true)->to(UserForm::class);
    }

    public function changeSidebarStatus($sidebarOpen)
    {
       $this->sidebarStatus = $sidebarOpen;
    }


}
