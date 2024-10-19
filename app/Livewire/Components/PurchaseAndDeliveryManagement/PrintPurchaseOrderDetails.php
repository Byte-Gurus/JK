<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement;

use App\Models\Purchase;
use App\Models\PurchaseDetails;
use Livewire\Component;

class PrintPurchaseOrderDetails extends Component
{
    public $purchase_id, $po_number, $supplier, $dateCreated, $createdBy;
    public function render()
    {
        $purchaseDetails = PurchaseDetails::where('purchase_id', $this->purchase_id)
            ->with('itemsJoin') // Load related itemsJoin to avoid N+1 query problem
            ->get();

        return view('livewire.components.PurchaseAndDeliveryManagement.print-purchase-order-details', compact('purchaseDetails'));
    }

    protected $listeners = [
        'print-po-from-table' => 'printPO'
    ];

    public function populateForm()
    {
        $po_details = Purchase::find($this->purchase_id);

        $this->fill([
            'po_number' => $po_details->po_number,
            'supplier' => $po_details->supplierJoin->company_name,
            'dateCreated' => $po_details->created_at,
           'createdBy' => $po_details->userJoin->firstname . ' ' . ($po_details->userJoin->middlename ? $po_details->userJoin->middlename . ' ' : '') . $po_details->userJoin->lastname,
        ]);
    }
    public function printPO($purchase_ID)
    {
        $this->purchase_id = $purchase_ID;

        $this->populateForm();
    }
}
