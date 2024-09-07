<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;

class SalesReturnTable extends Component
{
    public function render()
    {
        return view('livewire.components.sales.sales-return-table');
    }

    public function dDisplaySalesReturnDetails()
    {
        $this->dispatch('d-display-sales-return-details', sShowSalesReturnDetails: true)->to(SalesReturn::class);
    }
}
