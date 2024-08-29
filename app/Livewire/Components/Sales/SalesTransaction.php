<?php

namespace App\Livewire\Components\Sales;

use App\Livewire\Pages\CashierPage;
use Livewire\Component;

class SalesTransaction extends Component
{

    public $showSalesTransactionHistory = false ;
    public function render()
    {
        return view('livewire.components.Sales.sales-transaction');
    }

    public function displaySalesTransactionHistory()
    {
        $this->dispatch('display-sales-transaction-history', showSalesTransactionHistory: true)->to(CashierPage::class);
    }
}
