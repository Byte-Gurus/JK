<?php

namespace App\Livewire\Components\InventoryManagement;

use App\Models\Inventory;
use Livewire\Component;

class InventoryForm extends Component
{
    public $inventory_id, $cost, $markup, $seling_price, $barcode, $sku_code, $item_name, $item_description;
    public function render()
    {
        return view('livewire.components.InventoryManagement.inventory-form');
    }

    protected $listeners = [
        'stock-price' => 'getStockPrice'
    ];
    // public function update() //* update process
    // {
    //     $validated = $this->validateForm();


    //     $inventories = Inventory::find($this->inventory_id); //? kunin lahat ng data ng may ari ng proxy_item_id



    //     //* ipasa ang laman ng validated inputs sa models
    //     $inventories->item_cost = $validated['item_cost'];
    //     $inventories->markup = $validated['markup'];
    //     $inventories->seling_price = $validated['seling_price'];


    //     if ($this->hasBarcode) {
    //         $items->barcode = $validated['create_barcode'];
    //     } else {
    //         $items->barcode = $validated['barcode'];
    //     }

    //     $attributes = $items->toArray();


    //     $this->confirm('Do you want to update this item?', [
    //         'onConfirmed' => 'updateConfirmed', //* call the confmired method
    //         'inputAttributes' =>  $attributes, //* pass the $attributes array to the confirmed method
    //     ]);
    // }



    // public function updateConfirmed($data) //* confirmation process ng update
    // {


    //     //var sa loob ng $data array, may array pa ulit (inputAttributes), extract the inputAttributes then assign the array to a variable array
    //     $updatedAttributes = $data['inputAttributes'];


    //     //* hanapin id na attribute sa $updatedAttributes array
    //     $item = Item::find($updatedAttributes['id']);

    //     $item->fill($updatedAttributes);
    //     $item->save(); //* Save the item model to the database

    //     $inventories = Inventory::where('item_id', $item->id)->get();

    //     // Update vat_amount for each related Inventory record
    //     foreach ($inventories as $inventory) {

    //         // Update the vat_amount in the Inventory model
    //         $inventory->vat_amount = ($item->vat_percent / 100) * $inventory->selling_price;
    //         $inventory->save(); // Save each updated inventory record
    //     }

    //     $this->resetForm();
    //     $this->alert('success', 'items was updated successfully');
    //     ItemEvent::dispatch('refresh-item');
    //     $this->refreshTable();
    //     $this->closeModal();
    // }
    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }

    public function populateForm()
    {
        $inventory = Inventory::find($this->inventory_id);

        $this->fill([
            'barcode' => $inventory->itemJoin->barcode,
            'sku_code' => $inventory->sku_code,
            'item_name' => $inventory->itemJoin->item_name,
            'item_description' => $inventory->itemJoin->item_description,
            'cost' => $inventory->cost,
            'markup' => round((($inventory->selling_price - $inventory->cost) / $inventory->cost) * 100),
            'seling_price' => $inventory->selling_price
        ]);
    }

    protected function validateForm()
    {

        $rules = [
            'cost' => 'required|numeric',
            'markup' => 'required|numeric',
            'seling_price' => 'required|numeric',

        ];

        return $this->validate($rules);
    }

    public function updatedMarkup($markup)
    {
        $this->calculateSRP($this->cost, $markup);
    }
    public function updatedCost($cost)
    {
        $this->calculateSRP($cost, $this->markup);
    }
    public function calculateSRP($cost, $markup)
    {

        if ($cost !== null && $markup !== null) {
            $srp = $cost * (1 + $markup / 100);
            $this->seling_price = ceil($srp);
        }

    }
    public function resetForm()
    {
        $this->reset([
            'cost',
            'markup',
            'seling_price',
        ]);
    }
    public function getStockPrice($stockID)
    {
        $this->inventory_id = $stockID;
        $this->populateForm();
    }
}
