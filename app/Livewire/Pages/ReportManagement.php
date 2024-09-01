<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class ReportManagement extends Component
{
    public $sidebarStatus;

    public function render()
    {
        return view('livewire.pages.report-management');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'change-sidebar-status' => 'changeSidebarStatus',
        'display-inventoyry-table' => 'displayInventoryTable',
        'display-stock-card' => 'displayStockCard',
    ];

    public function changeSidebarStatus($sidebarOpen)
    {
        $this->sidebarStatus = $sidebarOpen;
    }
}
