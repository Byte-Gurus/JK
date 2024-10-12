<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\InventoryManagement\InventoryForm;
use App\Livewire\Components\InventoryManagement\InventoryTable;
use Illuminate\Support\Sleep;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryManagementPage extends Component
{
    public $showModal = false;
    public $showInventoryTable = true;
    public $showInventoryHistory = false;
    public $showStockAdjustPage = false;
    public $showInventoryForm = false;
    public $sidebarStatus;
    public $showStockCard = false;

    public $sku_code;
    public function mount($sku_code = null)
    {
        $this->sku_code = $sku_code;
    }

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
        'display-inventory-form' => 'displayInventoryForm',
        'close-inventory-form' => 'closeInventoryForm',
        'close-stock-adjust-page' => 'closeStockAdjustPage',
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

    public function closeInventoryForm()
    {
        $this->showInventoryForm = false;
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

    public function closeStockAdjustPage()
    {
        $this->showStockAdjustPage = false;
    }
}
