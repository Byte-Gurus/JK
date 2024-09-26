<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;

class SalesReturnSlip extends Component
{
    public function render()
    {
        return view('livewire.components.Sales.sales-return-slip');
    }

    protected $listeners = [
        'get-return-details' => 'getReturnDetails'
    ];

    public function getReturnDetails($return_details){
        dd($return_details);
    }
}
