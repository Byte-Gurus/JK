<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery;

use App\Livewire\Pages\DeliveryPage;
use App\Models\Delivery;
use Livewire\Component;

class RestockForm extends Component
{
    public $delivery_id, $po_number;
    public function render()
    {
        return view('livewire.components.PurchaseAndDeliveryManagement.Delivery.restock-form');
    }
    protected $listeners = [
        'restock-form' => 'restockForm', //*  galing sa UserTable class

    ];
    private function populateForm() //*lagyan ng laman ang mga input
    {
        $delivery_details = Delivery::find($this->delivery_id); //? kunin lahat ng data ng may ari ng item_id
        dd($delivery_details);

        // $this->fill([
        //     'po_number' => $delivery_details->purchase_id->purchaseJoin->po_number,

        // ]);
    }

    public function restockForm($deliveryID)
    {
        $this->delivery_id = $deliveryID;
        $this->populateForm();
    }
}
