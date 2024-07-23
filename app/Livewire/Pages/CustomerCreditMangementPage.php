<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\CustomerCreditManagement\CustomerCreditForm;
use Livewire\Component;

class CustomerCreditMangementPage extends Component
{
    public $showModal = false;

    public $sidebarStatus;

    public function render()
    {
        return view('livewire.pages.customer-credit-mangement-page');
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
        $this->dispatch('change-method', isCreate: true)->to(CustomerCreditForm::class);
    }

    public function changeSidebarStatus($sidebarOpen)
    {
        $this->sidebarStatus = $sidebarOpen;
    }
}
