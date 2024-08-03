<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\CustomerManagement\CustomerForm;
use Livewire\Component;

class CustomerManagementPage extends Component
{
    public $showModal = false;

    public $sidebarStatus;

    public function render()
    {
        return view('livewire.pages.customer-management-page');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'change-sidebar-status' => 'changeSidebarStatus'
    ];

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function formCreate()
    {

        $this->dispatch('change-method', isCreate: true)->to(CustomerForm::class);
    }

    public function changeSidebarStatus($sidebarOpen)
    {
        $this->sidebarStatus = $sidebarOpen;
    }
}
