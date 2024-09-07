<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;

class SalesReturn extends Component
{

    public $showSalesReturnTable = true;
    public $showSalesReturnModal = false;
    public $showSalesReturnDetails = false;

    public function render()
    {
        return view('livewire.components.sales.sales-return');
    }

    protected $listeners = [
        'display-sales-return-details' => 'displaySalesReturnDetails'
    ];

    public function displaySalesReturnModal()
    {
        $this->showSalesReturnModal = true;
    }

    public function displaySalesReturnDetails()
    {
        $this->showSalesReturnModal = false;
        $this->showSalesReturnDetails = true;
    }

}
