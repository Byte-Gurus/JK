<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement;

use App\Models\Delivery;
use App\Models\Inventory;
use App\Models\RestockDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PrintDeliveryDetails extends Component
{
    public $delivery_id, $po_number, $supplier, $dateCreated, $createdBy;

    public function render()
    {
        $restockDetails = RestockDetails::where('delivery_id', $this->delivery_id)->get();

        dump($this->delivery_id, $restockDetails);

        return view('livewire.components.PurchaseAndDeliveryManagement.print-delivery-details', [
            'restockDetails' => $restockDetails
        ]);
    }

    protected $listeners = [
        'print-delivery-from-table' => 'printDelivery'
    ];

    public function populateForm()
    {
        $delivery_details = Delivery::find($this->delivery_id);

        $this->fill([
            'po_number' => $delivery_details->po_number,
            'supplier' => $delivery_details->purchaseJoin->supplierJoin->company_name,
            'dateCreated' => $delivery_details->created_at,
            'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname,
        ]);
    }
    public function printDelivery($delivery_id)
    {
        $this->delivery_id = $delivery_id;

        $this->populateForm();
    }
}
