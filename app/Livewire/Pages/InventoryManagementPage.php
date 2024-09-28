<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\InventoryManagement\InventoryForm;
use Livewire\Component;

class InventoryManagementPage extends Component
{
    public $showModal = false;
    public $showInventoryTable = true;
    public $showInventoryHistory = false;
    public $showStockAdjustPage = false;
    public $showInventoryForm = false;
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
        'display-stock-adjust-page' => 'displayStockAdjustPage',
        'display-stock-card' => 'displayStockCard',
        'display-inventory-form' => 'displayInventoryForm'
    ];

    public function closeModal()
    {
        $this->showStockAdjustPage = false;
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

    public function displayInventoryForm()
    {
        $this->showInventoryForm = true;
    }

    public function displayStockCard($showStockCard)
    {
        $this->showInventoryTable = false;
        $this->showStockCard = $showStockCard;
    }

    public function displayStockAdjustPage()
    {
        $this->showStockAdjustPage = true;
    }
}
