<?php

namespace App\Livewire\Components\Sales;

use App\Livewire\Pages\CashierPage;
use Livewire\Component;

class VoidTransactionPage extends Component
{

    public $showVoidTransactionTable = true;
    public $showVoidTransactionForm = false;
    public $showVoidTransactionModal = false;
    public $showVoidTransactionDetails = false;
    public function render()
    {
        return view('livewire.components.Sales.void-transaction-page');
    }

    protected $listeners = [
        'display-void-transaction-form' => 'displayVoidTransactionForm',
        'display-void-transaction-details' => 'displayVoidTransactionDetails',
        'return-void-transaction-page' => 'returnVoidTransactionPage'
    ];

    public function returnToVoidTransactionPageFromVoidTransactionForm()
    {
        $this->dispatch('return-to-void-transaction-page', showVoidTransactionPage: true)->to(CashierPage::class);
        $this->dispatch('display-sales-transaction-history', showSalesTransactionHistory: false)->to(CashierPage::class);
        $this->showVoidTransactionTable = true;
        $this->showVoidTransactionForm = false;
    }

    public function returnToVoidTransactionPageFromVoidTransactionDetails()
    {
        $this->dispatch('return-to-void-transaction-page', showVoidTransactionPage: true)->to(CashierPage::class);
        $this->dispatch('display-sales-transaction-history', showSalesTransactionHistory: false)->to(CashierPage::class);
        $this->showVoidTransactionDetails = false;
        $this->showVoidTransactionTable = true;
    }

    public function returnToTransactionHistory()
    {
        $this->dispatch('display-sales-transaction-history', showSalesTransactionHistory: true)->to(CashierPage::class);
        $this->dispatch('return-to-void-transaction-page', showVoidTransactionPage: false)->to(CashierPage::class);
        $this->showVoidTransactionForm = false;
        $this->showVoidTransactionDetails = false;
        $this->showVoidTransactionTable = true;
    }

    public function returnVoidTransactionPage()
    {
        $this->showVoidTransactionForm = false;
        $this->showVoidTransactionTable = true;
    }

    public function displayVoidTransactionModal()
    {
        $this->showVoidTransactionModal = true;
    }

    public function displayVoidTransactionForm()
    {
        $this->showVoidTransactionModal = false;
        $this->showVoidTransactionTable = false;
        $this->showVoidTransactionForm = true;
    }

    public function displayVoidTransactionDetails($showVoidTransactionDetails)
    {
        $this->showVoidTransactionTable = false;
        $this->showVoidTransactionForm = false;
        $this->showVoidTransactionDetails = $showVoidTransactionDetails;
    }
}
