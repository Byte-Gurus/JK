<?php

namespace App\Livewire\Components\InventoryManagement;

use Livewire\Component;

class StockAdjustPage extends Component
{

    public $showStockAdjustForm = true;
    public $showInventoryAdminLoginForm = false;
    public function render()
    {
        return view('livewire.components.InventoryManagement.stock-adjust-page');
    }

}
