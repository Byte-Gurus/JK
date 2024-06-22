<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Dashboard extends Component
{

    public $sidebarStatus;
    public function render()
    {
        return view('livewire.pages.dashboard');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'change-sidebar-status' => 'changeSidebarStatus'
    ];

    public function changeSidebarStatus($sidebarOpen)
    {
        $this->sidebarStatus = $sidebarOpen;
    }
}
