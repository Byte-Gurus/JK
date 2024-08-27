<?php

namespace App\Livewire\Components\InventoryManagement;

use App\Models\Inventory;
use App\Models\InventoryMovement;
use Livewire\Component;

class ViewStockCard extends Component
{
    public $stock_id, $item_name, $item_description, $expiration_date, $supplier, $barcode, $selling_price;
    public $stock_cards = [];
    public function render()

    {
        if ($this->stock_id) {

            $this->stock_cards = InventoryMovement::with(['inventoryJoin', 'adjustmentJoin.inventoryJoin'])
                ->whereHas('inventoryJoin', function ($query) {
                    $query->where('id', $this->stock_id); // Filtering based on stock_id in Inventory
                })
                ->orWhereHas('adjustmentJoin.inventoryJoin', function ($query) {
                    $query->where('id', $this->stock_id); // Filtering based on stock_id in Inventory through InventoryAdjustment
                })
                ->get();
        }

        return view('livewire.components.InventoryManagement.view-stock-card', ['stock_cards' => $this->stock_cards]);
    }

    protected $listeners = [
        'stock-card' => 'stockCard', //*  galing sa UserTable class

    ];

    private function populateForm() //*lagyan ng laman ang mga input
    {

        $stock_details = Inventory::find($this->stock_id); //? kunin lahat ng data ng may ari ng item_id


        $this->fill([
            'item_name' => $stock_details->itemJoin->item_name,
            'item_description' =>  $stock_details->itemJoin->item_description,
            'expiration_date' => $stock_details->expiration_date,
            'barcode' => $stock_details->itemJoin->barcode,
            'supplier' => $stock_details->deliveryJoin->purchaseJoin->supplierJoin->company_name,
            'selling_price' =>  $stock_details->selling_price,
        ]);
    }

    public function stockCard($stockID)
    {
        $this->stock_id = $stockID;
        $this->populateForm();
    }
}
