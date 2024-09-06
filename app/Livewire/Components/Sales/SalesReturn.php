<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;

class SalesReturn extends Component
{

    public $showSalesReturnTable = false;
    public $showSalesReturnModal = true;

    public function render()
    {
        return view('livewire.components.sales.sales-return');
    }

    public function displaySalesReturnModal()
    {
        dd('g');
    }

}
