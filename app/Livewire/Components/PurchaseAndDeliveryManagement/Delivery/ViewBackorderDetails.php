<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery;

use App\Models\Delivery;
use App\Models\Purchase;
use App\Models\Supplier;
use Livewire\Component;

class ViewBackorderDetails extends Component
{

    public $backorderList = [];
    public $po_number, $purchase_id, $supplier, $delivery_id, $purchase, $select_supplier;
    public $selectedToReorder = [];
    public $selectedToCancel = [];
    public $selectAllToReorder = false;
    public $selectAllToCancel = false;
    public function render()
    {
        $suppliers = Supplier::select('id', 'company_name')->where('status_id', '1')->get();
        // Fetch the purchase with related backorders and items
        $this->purchase = Purchase::with('backorderJoin.itemJoin')
            ->find($this->purchase_id);


        if ($this->purchase && $this->purchase->backorderJoin->isNotEmpty()) {
            $this->backorderList = $this->purchase->backorderJoin->map(function ($backOrder) {
                return [
                    'backorder_quantity' => $backOrder->backorder_quantity,
                    'status' => $backOrder->status,
                    'barcode' => $backOrder->itemJoin->barcode,
                    'item_name' => $backOrder->itemJoin->item_name,
                    'item_description' => $backOrder->itemJoin->item_description,
                    // Provide an empty array if no item details
                ];
            })->toArray();
        }

        return view('livewire.components.PurchaseAndDeliveryManagement.delivery.view-backorder-details', [
            'backorder_lists' => $this->backorderList,
            'suppliers' => $suppliers,
        ]);
    }


    protected $listeners = [
        'refresh-table' => 'refreshTable', //*  galing sa UserTable class
        'backorder-form' => 'backorderForm',
        'updateConfirmed',
        'cancelConfirmed',
    ];
    private function populateForm() //*lagyan ng laman ang mga input
    {

        $purchase_details = Purchase::find($this->purchase_id);

        $this->fill([
            'po_number' => $purchase_details->po_number,
            'supplier' => $purchase_details->supplierJoin->company_name,
        ]);
    }

    public function reorderAll()
    {

        if ($this->selectAllToReorder) {
            $this->selectedToReorder = array_keys($this->backorderList);
        } else {
            $this->selectAllToReorder = [];
        }


    }

    public function backorderForm($deliveryID)
    {

        $this->delivery_id = $deliveryID;
        $delivery = Delivery::find($this->delivery_id);
        $this->purchase_id = $delivery->purchase_id;



        $this->populateForm();
    }
}
