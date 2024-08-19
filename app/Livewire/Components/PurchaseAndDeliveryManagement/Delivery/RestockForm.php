<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery;

use App\Livewire\Pages\DeliveryPage;
use App\Models\Delivery;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use Livewire\Component;

class RestockForm extends Component
{
    public $delivery_id, $po_number, $supplier;
    public $purchase_id, $purchaseDetails;
    public function render()
    {
        // Fetch purchase details based on purchase_id and assign it to $purchaseDetails
        $this->purchaseDetails = PurchaseDetails::where('purchase_id', $this->purchase_id)->get();

        return view('livewire.components.PurchaseAndDeliveryManagement.Delivery.restock-form', [
            'purchaseDetails' => $this->purchaseDetails
        ]);
    }
    protected $listeners = [
        'restock-form' => 'restockForm', //*  galing sa UserTable class

    ];
    private function populateForm() //*lagyan ng laman ang mga input
    {

        $delivery_details = Delivery::find($this->delivery_id); //? kunin lahat ng data ng may ari ng item_id
        ;

        $this->fill([
            'po_number' => $delivery_details->purchaseJoin->po_number,
            'supplier' => $delivery_details->purchaseJoin->supplierJoin->company_name,
        ]);
    }

    public function restockForm($deliveryID)
    {

        $this->delivery_id = $deliveryID;
        $delivery = Delivery::find($this->delivery_id);
        $this->purchase_id = $delivery->purchase_id;

        $this->populateForm();
    }
}
