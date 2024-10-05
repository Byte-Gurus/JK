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
        return view('livewire.components.sales.void-transaction-page');
    }

    protected $listeners = [
        'display-void-transaction-form' => 'displayVoidTransactionForm',
        'display-void-transaction-details' => 'displayVoidTransactionDetails'
    ];

    public function returnToSalesTransaction()
    {
        if ($this->showVoidTransactionTable) {
            $this->dispatch('display-sales-transaction', showSalesTransaction: true)->to(CashierPage::class);
        } else {
            $this->showVoidTransactionForm = false;
            $this->showVoidTransactionDetails = false;
            $this->showVoidTransactionTable = true;
        }
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
