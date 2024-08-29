<?php

namespace App\Livewire\Pages;

use App\Models\Inventory;
use App\Models\Item;
use Livewire\Component;

class CashierPage extends Component
{

    public $showSalesTransaction = true;

    public $showSalesTransactionHistory = false;

    public function render()
    {
        return view('livewire.pages.cashier-page');
    }

    protected $listeners = [
        'close-backorder-form' => 'closeBackorderForm',
        'display-sales-transaction' => 'displaySalesTransaction',
        'display-sales-transaction-history' => 'displaySalesTransactionHistory',
        'display-sales-return' => 'displaySalesReturn',
    ];

    public function displaySalesTransactionHistory($showSalesTransactionHistory)
    {
        $this->showSalesTransaction = false;
        $this->showSalesTransactionHistory = $showSalesTransactionHistory;
    }

    public function displaySalesTransaction($showSalesTransaction)
    {
        $this->showSalesTransaction = $showSalesTransaction;
        $this->showSalesTransactionHistory = false;
    }
}
