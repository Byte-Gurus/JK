<?php

namespace App\Livewire\Components\InventoryManagement;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class StockAdjustForm extends Component
{
    use LivewireAlert;
    public function render()
    {
        return view('livewire.components.InventoryManagement.stock-adjust-form');
    }
}
