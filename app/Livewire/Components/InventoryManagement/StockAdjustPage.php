<?php

namespace App\Livewire\Components\InventoryManagement;

use Livewire\Component;

class StockAdjustPage extends Component
{

    public $showStockAdjustForm = true;
    public $adminLoginForm = false;
    public function render()
    {
        return view('livewire.components.InventoryManagement.stock-adjust-page');
    }

    protected $listeners = [
        'adjust-stock-from-table' => 'adjustStock', //*  galing sa UserTable class
        'display-stock-adjust-confirmation' => 'displayStockAdjustConfirmation',
        'display-admin-login-form' => 'displayAdminLoginForm',
        'return-stock-adjust-form' => 'returnStockAdjustForm',
        'updateConfirmed',
        'createConfirmed',
    ];

    public function displayAdminLoginForm()
    {
        $this->showStockAdjustForm = false;
        $this->adminLoginForm = true;
    }

    public function returnStockAdjustForm()
    {
        $this->showStockAdjustForm = true;
        $this->adminLoginForm = false;
    }
}
