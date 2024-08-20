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
    public $purchase_id, $purchaseDetails = [];
    public function render()
    {
        if (empty($this->purchaseDetails)) {
            // Fetch purchase details with related itemsJoin data
            $this->purchaseDetails = PurchaseDetails::with('itemsJoin')
                ->where('purchase_id', $this->purchase_id)
                ->get()
                ->map(function ($details) {
                    return $details->toArray() + [
                        'barcode' => $details->itemsJoin->barcode,
                        'item_name' => $details->itemsJoin->item_name,
                        'purchased_quantity' => $details->purchase_quantity,
                        'sku_code' => $this->generateSKU(),
                        'reorder_point' =>  $details->itemsJoin->reorder_point,
                    ];
                })
                ->toArray();
        }

        return view('livewire.components.PurchaseAndDeliveryManagement.Delivery.restock-form', [
            'purchaseDetails' => $this->purchaseDetails,
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
    public function duplicateItem($item_id)
    {
        // Find the original PurchaseDetails item
        $originalItem = PurchaseDetails::with('itemsJoin')->find($item_id);

        if ($originalItem) {
            $newItem = [
                'barcode' => $originalItem->itemsJoin->barcode,
                'item_name' => $originalItem->itemsJoin->item_name,
                'purchase_quantity' => $originalItem->purchase_quantity,
                'sku_code' => $this->generateSKU(),  // Generate a new SKU for the duplicated item
                'reorder_point' => $originalItem->itemsJoin->reorder_point,
                'id' => $originalItem->id,
            ];

            $this->purchaseDetails[] = $newItem;
           
            $this->purchaseDetails = array_values($this->purchaseDetails);
        }
    }

    public function restockForm($deliveryID)
    {

        $this->delivery_id = $deliveryID;
        $delivery = Delivery::find($this->delivery_id);
        $this->purchase_id = $delivery->purchase_id;

        $this->populateForm();
    }

    public function restock()
    {
        dd($this->purchaseDetails);
    }

    public function generateSKU()
    {
        $randomNumber = random_int(100000, 999999);
        return 'SKU-' . $randomNumber;
    }
}
