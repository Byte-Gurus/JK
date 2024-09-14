<?php

namespace App\Livewire\Components\InventoryManagement;

use Livewire\Component;

class StockAdjustPage extends Component
{

    public $showStockAdjustForm = true;
    public $showInventoryAdminLoginForm = false;
    public function render()
    {
        return view('livewire.components.inventorymanagement.stock-adjust-page');
    }

}
