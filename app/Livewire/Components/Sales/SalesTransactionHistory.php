<?php

namespace App\Livewire\Components\Sales;

use App\Livewire\Pages\CashierPage;
use Livewire\Component;

class SalesTransactionHistory extends Component
{
    public function render()
    {
        return view('livewire.components.Sales.sales-transaction-history');
    }

    public function returnToSalesTransaction()
    {
        $this->dispatch('display-sales-transaction', showSalesTransaction: true)->to(CashierPage::class);
    }
}
