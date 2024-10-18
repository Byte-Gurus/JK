<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase;

use App\Models\PurchaseDetails;
use Livewire\Component;

class ViewPurchaseOrderDetails extends Component
{
    public $purchase_id, $po_number, $supplier, $dateCreated, $createdBy;

    public function render()
    {
        $purchaseDetails = PurchaseDetails::where('purchase_id', $this->purchase_id)
        ->with('itemsJoin') // Load related itemsJoin to avoid N+1 query problem
        ->get();


        return view('livewire.components.PurchaseAndDeliveryManagement.Purchase.view-purchase-order-details', compact('purchaseDetails'));
    }

    protected $listeners = [
        'view-po' => 'viewPO', //*  galing sa UserTable class

    ];

    public function populateForm()
    {
        $po_details = PurchaseDetails::find($this->purchase_id);

        $this->fill([
            'po_number' => $po_details->po_number,
            'supplier' => $po_details->purchaseJoin->supplierJoin->company_name,
            'dateCreated' => $po_details->created_at->format('M d Y h:i A'),
            'createdBy' => $po_details->purchaseJoin->userjoin->firstname . ' ' . $po_details->purchaseJoin->userjoin->lastname,
        ]);
    }

    public function viewPO($poID)
    {
        $this->purchase_id = $poID;

        $this->populateForm();
    }
}
