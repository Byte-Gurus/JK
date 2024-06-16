<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class HomePage extends Component
{

    public $showModal = false;

    public $sidebarStatus;

    public function render()
    {
        return view('livewire.pages.home-page');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'change-sidebar-status' => 'changeSidebarStatus'
    ];

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function changeSidebarStatus($sidebarOpen)
    {
        $this->sidebarStatus = $sidebarOpen;
    }
}
