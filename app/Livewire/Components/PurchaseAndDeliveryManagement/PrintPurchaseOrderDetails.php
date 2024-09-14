<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement;

use App\Models\Purchase;
use Livewire\Component;

class PrintPurchaseOrderDetails extends Component
{
    public $purchase,  $purchase_id;
    public function render()
    {
        return view('livewire.components.PurchaseAndDeliveryManagement.print-purchase-order-details', [
            'purchase' => $this->purchase,
        ]);
    }

    protected $listeners = [
        'print-po-from-table' => 'printPO'
    ];

    public function printPO($purchase_ID)
    {
        $this->purchase_id = $purchase_ID;
        $this->purchase =  Purchase::find($purchase_ID);
    }
}
