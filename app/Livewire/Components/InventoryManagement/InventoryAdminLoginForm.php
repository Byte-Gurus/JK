<?php

namespace App\Livewire\Components\InventoryManagement;

use App\Livewire\Pages\InventoryManagementPage;
use Livewire\Component;

class InventoryAdminLoginForm extends Component
{
    public $showStockAdjustModal = false;
    public function render()
    {
        return view('livewire.components.InventoryManagement.inventory-admin-login-form');
    }

    public function closeInventoryAdminLoginForm()
    {
        $this->dispatch('close-inventory-admin-login-form')->to(InventoryManagementPage::class);
    }


}
