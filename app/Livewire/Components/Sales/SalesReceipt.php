<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;

class SalesReceipt extends Component
{
    public $receiptDetails = [];
    public function render()
    {
        return view('livewire.components.Sales.sales-receipt');
    }

    protected $listeners = [
        'print-sales-receipt' => 'printSalesReceipt'
    ];

    public function printSalesReceipt($receiptData)
    {
        $this->receiptDetails = $receiptData;

    }

    public function generateInvoiceNumber()
    {
        $randomNumber = random_int(0, 9999);
        $formattedNumber = str_pad($randomNumber, 4, '0', STR_PAD_LEFT);


        return $formattedNumber;
    }
}
