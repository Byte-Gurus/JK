<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement;

use Livewire\Component;

class PrintPurchaseOrderDetails extends Component
{
    public function render()
    {
        return view('livewire.components.PurchaseAndDeliveryManagement.print-purchase-order-details');
    }

    protected $listeners = [
        'print-po-from-table' => 'printPO'
    ];

    public function printPO($purchase_ID)
    {
        dd($purchase_ID);
    }
}
