<?php

namespace App\Livewire\Components\Sales;

use App\Livewire\Pages\CashierPage;
use Livewire\Component;

class SalesReturn extends Component
{

    public $showSalesReturnTable = true;
    public $showSalesReturnModal = false;
    public $showSalesReturnDetails = false;
    public $sShowSalesReturnDetails = false;

    public function render()
    {
        return view('livewire.components.sales.sales-return');
    }

    protected $listeners = [
        'display-sales-return-details' => 'displaySalesReturnDetails',
        'd-display-sales-return-details' => 'dDisplaySalesReturnDetails'
    ];

    public function returnToSalesTransaction()
    {
        $this->dispatch('display-sales-transaction', showSalesTransaction: true)->to(CashierPage::class);
    }

    public function displaySalesReturnModal()
    {
        $this->showSalesReturnModal = true;
    }

    public function displaySalesReturnDetails()
    {
        $this->showSalesReturnModal = false;
        $this->showSalesReturnTable = false;
        $this->showSalesReturnDetails = true;
    }

    public function dDisplaySalesReturnDetails($sShowSalesReturnDetails)
    {
        $this->showSalesReturnTable = false;
        $this->showSalesReturnDetails = false;
        $this->sShowSalesReturnDetails = $sShowSalesReturnDetails;
    }

}