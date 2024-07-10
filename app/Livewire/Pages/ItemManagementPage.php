<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class ItemManagementPage extends Component
{

    public $showModal = false;
    public $sidebarStatus;

    public function render()
    {
        return view('livewire.pages.item-management-page');
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
        $this->dispatch('change-method', isCreate: true)->to(ItemManagementPage::class);
    }

    public function changeSidebarStatus($sidebarOpen)
    {
        $this->sidebarStatus = $sidebarOpen;
    }
}
