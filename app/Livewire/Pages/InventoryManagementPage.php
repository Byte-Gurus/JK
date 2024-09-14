<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\InventoryManagement\InventoryForm;
use Livewire\Component;

class InventoryManagementPage extends Component
{
    public $showModal = false;
    public $showInventoryTable = true;
    public $showStockAdjustModal = false;
    public $showInventoryHistory = false;

    public $showInventoryAdminLoginForm = false;
    public $sidebarStatus;
    public $showStockCard = false;
    public function render()
    {
        return view('livewire.pages.inventory-management-page');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'change-sidebar-status' => 'changeSidebarStatus',
        'display-inventoyry-table' => 'displayInventoryTable',
        'display-inventory-admin-login-form' => 'displayInventoryAdminLoginForm',
        'close-inventory-admin-login-form' => 'closeAdminLoginForm',
        'display-stock-card' => 'displayStockCard',
    ];

    public function closeModal()
    {
        $this->showModal = false;
        $this->showStockAdjustModal = false;
    }

    public function formCreate()
    {
        $this->dispatch('change-method', isCreate: true)->to(InventoryForm::class);
    }

    public function returnToInventoryTable()
    {
        $this->showInventoryTable = true;
        $this->showInventoryHistory = false;
        $this->showStockCard = false;
        $this->showStockAdjustModal = false;
    }

    public function displayInventoryHistory()
    {
        $this->showInventoryTable = false;
        $this->showInventoryHistory = !$this->showInventoryHistory;
    }

    public function changeSidebarStatus($sidebarOpen)
    {
        $this->sidebarStatus = $sidebarOpen;
    }

    public function displayStockCard($showStockCard)
    {
        $this->showInventoryTable = false;
        $this->showStockCard = $showStockCard;
    }

    public function displayInventoryAdminLoginForm()
    {
        $this->showStockAdjustModal = false;
        $this->showInventoryAdminLoginForm = true;
    }

    public function closeAdminLoginForm()
    {
        $this->showStockAdjustModal = true;
        $this->showInventoryAdminLoginForm = false;
    }
}
