<?php

namespace App\Livewire\Components\InventoryManagement;

use App\Models\Inventory;
use Livewire\Component;

class InventoryForm extends Component
{
    public $inventory_id, $item_cost,$markup,$seling_price;
    public function render()
    {
        return view('livewire.components.InventoryManagement.inventory-form');
    }

    protected $listeners = [
        'stock-price' => 'getStockPrice'
    ];

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }

    public function populateForm()
    {
        $inventory = Inventory::find($this->inventory_id);

        $this->fill([
            'item_cost' => $inventory->cost,
            'markup' => (($inventory->selling_price - $inventory->cost) / $inventory->cost) * 100,
            'seling_price' => $inventory->selling_price
        ]);
    }

    protected function validateForm()
    {

        $rules = [
            'item_cost' => 'required|numeric',
            'markup' =>  'required|numeric',
            'seling_price' =>   'required|numeric',

        ];

        return $this->validate($rules);
    }
    public function resetForm()
    {
        $this->reset([
            'item_cost',
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
