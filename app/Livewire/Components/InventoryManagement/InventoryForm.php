<?php

namespace App\Livewire\Components\InventoryManagement;

use App\Models\Inventory;
use Livewire\Component;

class InventoryForm extends Component
{
    public $inventory;
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

        $this->fill([
            'item_cost' => $this->inventory->cost,
            'markup' => (($this->inventory->selling_price - $this->inventory->cost) / $this->inventory->cost) * 100,
            'seling_price' => $this->inventory->selling_price
        ]);
    }

    protected function validateForm()
    {
        $this->item_name = trim($this->item_name);

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
    public function getStockPrice($stockId)
    {
        $this->inventory = Inventory::find($stockId);
        $this->populateForm();
    }
}
