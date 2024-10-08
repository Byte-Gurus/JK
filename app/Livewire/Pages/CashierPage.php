<?php

namespace App\Livewire\Pages;

use App\Models\Inventory;
use App\Models\Item;
use Livewire\Component;

class CashierPage extends Component
{

    public $showNavbarNoSidebar = true;

    public $showSalesTransaction = true;

    public $showSalesTransactionHistory = false;

    public $showSalesReceipt = false;

    public $showSalesReturn = false;

    public $showSalesReturnSlip = false;

    public $showVoidTransactionPage = false;

    public function render()
    {
        return view('livewire.pages.cashier-page');
    }

    protected $listeners = [
        'close-backorder-form' => 'closeBackorderForm',
        'display-sales-transaction' => 'displaySalesTransaction',
        'display-sales-transaction-history' => 'displaySalesTransactionHistory',
        'display-sales-return-slip' => 'displaySalesReturnSlip',
        'display-sales-return' => 'displaySalesReturn',
        'display-sales-receipt' => 'displaySalesReceipt',
        'display-void-transaction' => 'displayVoidTransaction',
        'return-to-void-transaction-page' => 'returnToVoidTransactionPage',
    ];

    public function displaySalesTransactionHistory($showSalesTransactionHistory)
    {
        $this->showSalesTransaction = false;
        $this->showSalesTransactionHistory = $showSalesTransactionHistory;
    }

    public function displayVoidTransaction($showVoidTransactionPage)
    {
        $this->showSalesTransactionHistory = false;
        $this->showVoidTransactionPage = $showVoidTransactionPage;
    }

    public function returnToVoidTransactionPage($showVoidTransactionPage)
    {
        $this->showSalesTransactionHistory = true;
        $this->showVoidTransactionPage = $showVoidTransactionPage;
    }

    public function displaySalesTransaction($showSalesTransaction)
    {
        $this->showNavbarNoSidebar = true;
        $this->showSalesTransaction = $showSalesTransaction;
        $this->showSalesReturn = false;
        $this->showSalesTransactionHistory = false;
    }

    public function displaySalesReceipt($showSalesReceipt)
    {
        $this->showNavbarNoSidebar = false;
        $this->showSalesTransaction = false;
        $this->showSalesReceipt = $showSalesReceipt;
    }

    public function displaySalesReturn($showSalesReturn)
    {
        $this->showSalesTransaction = false;
        $this->showSalesReturn = $showSalesReturn;
    }

    public function displaySalesReturnSlip($showSalesReturnSlip)
    {
        $this->showNavbarNoSidebar = false;
        $this->showSalesTransaction = false;
        $this->showSalesReturn = false;
        $this->showSalesReturnSlip = $showSalesReturnSlip;
    }
}
