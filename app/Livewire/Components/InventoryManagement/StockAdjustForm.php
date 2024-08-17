<?php

namespace App\Livewire\Components\InventoryManagement;

use App\Livewire\Pages\InventoryManagementPage;
use App\Models\Inventory;
use App\Models\InventoryAdjustment;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class StockAdjustForm extends Component
{
    use LivewireAlert;


    public $stock_id;
    public $sku_code, $item_name, $current_quantity, $description, $selectOperation, $quantityToAdjust, $adjustReason;

    public function render()
    {
        return view('livewire.components.InventoryManagement.stock-adjust-form');
    }

    protected $listeners = [
        'adjust-stock-from-table' => 'adjustStock', //*  galing sa UserTable class
        'updateConfirmed',
        'createConfirmed',
    ];

    public function adjust()
    {
        $validated = $this->validateForm();

        $stockAdjust = Inventory::find($this->stock_id);



        $stockAdjust->quantityToAdjust = $validated['quantityToAdjust'];
        $stockAdjust->adjustReason = $validated['adjustReason'];
        $stockAdjust->selectOperation = $validated['selectOperation'];

        $attributes = $stockAdjust->toArray();



        $this->confirm('Do you want to update this supplier?', [
            'onConfirmed' => 'updateConfirmed', //* call the confmired method
            'inputAttributes' =>  $attributes, //* pass the $attributes array to the confirmed method
        ]);
    }



    public function updateConfirmed($data) //* confirmation process ng update
    {


        //var sa loob ng $data array, may array pa ulit (inputAttributes), extract the inputAttributes then assign the array to a variable array
        $updatedAttributes = $data['inputAttributes'];

        if ($this->selectOperation == "add") {
            $adjustedQuantity = $this->current_quantity + $updatedAttributes['quantityToAdjust'];
        } elseif ($this->selectOperation == "deduct") {
            $adjustedQuantity = $this->current_quantity - $updatedAttributes['quantityToAdjust'];
        }

        $inventory = Inventory::find($updatedAttributes['id']);
        $inventory->current_stock_quantity = $adjustedQuantity;
        $inventory->save();


        $inventoryAdjust = InventoryAdjustment::create([
            'reason' => $updatedAttributes['adjustReason'],
            'operation' => $updatedAttributes['selectOperation'],
            'adjusted_quantity' => $updatedAttributes['quantityToAdjust'],
            'inventory_id' => $inventory->id,

        ]);

        $this->resetForm();
        $this->alert('success', 'items was updated successfully');

        $this->refreshTable();
        $this->closeModal();
    }
    protected function validateForm()
    {
        $this->adjustReason = trim($this->adjustReason);

        $rules = [
            'selectOperation' => 'required',
            'adjustReason' => 'required|string|max:255',
            'quantityToAdjust' => ['required', 'numeric', 'min:0'],

        ];

        return $this->validate($rules);
    }
    private function populateForm() //*lagyan ng laman ang mga input
    {

        $stock_details = Inventory::find($this->stock_id); //? kunin lahat ng data ng may ari ng item_id


        $this->fill([
            'sku_code' => $stock_details->sku_code,
            'item_name' => $stock_details->itemJoin->item_name,
            'current_quantity' => $stock_details->current_stock_quantity,
            'description' => $stock_details->itemJoin->item_description
        ]);
    }


    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset([
            'selectOperation',
            'adjustReason',
            'quantityToAdjust',
            'stock_id',
            'sku_code',
            'item_name',
            'current_quantity',
            'description',
            'selectOperation'
        ]);
    }
    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(InventoryManagementPage::class);
    }

    public function refreshTable() //* refresh ang table after confirmation
    {
        $this->dispatch('refresh-table')->to(InventoryTable::class);
    }
    public function adjustStock($stockID)
    {

        $this->stock_id = $stockID;

        $this->populateForm();
    }
}
