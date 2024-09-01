<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\CreditManagement\CreditForm;
use Livewire\Component;

class CreditManagementPage extends Component
{

    public $sidebarStatus;
    public function render()
    {
        return view('livewire.pages.credit-management-page');
    }

    public function formCreate()
    {
        $this->dispatch('change-method', isCreate: true)->to(CreditForm::class);
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
