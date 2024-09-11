<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;

class SalesReceipt extends Component
{
    public $receiptDetails = [];
    public function render()
    {
        return view('livewire.components.sales.sales-receipt');
    }

    protected $listeners = [
        'print-sales-receipt' => 'printSalesReceipt'
    ];

    public function printSalesReceipt($receiptData)
    {
        $this->receiptDetails = $receiptData;

        // dd($this->receiptDetails);
    }
}
