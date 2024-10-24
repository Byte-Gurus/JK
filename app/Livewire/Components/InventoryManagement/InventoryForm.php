<?php

namespace App\Livewire\Components\InventoryManagement;

use App\Events\InventoryEvent;
use App\Livewire\Pages\InventoryManagementPage;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class InventoryForm extends Component
{
    use LivewireAlert;

    public $inventory_id, $cost, $markup, $seling_price, $barcode, $sku_code, $item_name, $item_description, $inventoryInfo, $vat_amount;
    public $showInventoryForm = true;

    public $isAdmin;
    public $showInventoryAdminLoginForm = false;

    public $fromPage = "InventoryTable";
    public function render()
    {
        return view('livewire.components.InventoryManagement.inventory-form');
    }

    protected $listeners = [
        'stock-price' => 'getStockPrice',
        'admin-confirmed' => 'adminConfirmed',
        'return-inventory-form' => 'returnInventoryForm',
        'updateConfirmed'
    ];
    public function update() //* update process
    {
        $validated = $this->validateForm();


        $inventories = Inventory::find($this->inventory_id); //? kunin lahat ng data ng may ari ng proxy_item_id

        //* ipasa ang laman ng validated inputs sa models
        $inventories->cost = $validated['cost'];
        $inventories->mark_up_price = $validated['cost'] * ($validated['markup'] / 100);
        $inventories->selling_price = $validated['seling_price'];
        $inventories->vat_amount = ($inventories->itemJoin->vat_percent / 100) * $validated['seling_price'];


        $this->inventoryInfo = $inventories->toArray();

        $this->dispatch('get-from-page', $this->fromPage)->to(InventoryAdminLoginForm::class);
        $this->displayInventoryAdminLoginForm();

        // $this->confirm('Do you want to update this stock?', [
        //     'onConfirmed' => 'updateConfirmed', //* call the confmired method
        //     'inputAttributes' => $attributes, //* pass the $attributes array to the confirmed method
        // ]);
    }



    public function updateConfirmed() //* confirmation process ng update
    {


        $updatedAttributes = $this->inventoryInfo;

        DB::beginTransaction();

        try {

            $inventories = Inventory::find($this->inventory_id);

            if (!$inventories) {

                DB::rollback();
                $this->alert('error', 'Inventory not found.');
                return; // Exit the method

            }

            $inventories->update([
                'cost' => $this->inventoryInfo['cost'],
                'mark_up_price' => $this->inventoryInfo['mark_up_price'],
                'selling_price' => $this->inventoryInfo['selling_price'],
                'vat_amount' => $this->inventoryInfo['vat_amount'],
            ]);
            DB::commit();

            $this->resetForm();
            $this->alert('success', 'Stock was updated successfully');
            InventoryEvent::dispatch('refresh-inventory');
            $this->displayInventoryAdminLoginForm();
            $this->dispatch('close-inventory-form')->to(InventoryManagementPage::class);
            $this->dispatch('refresh-table')->to(InventoryTable::class);
        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            DB::rollback();
            $this->alert('error', 'An error occurred while updating inventory, please refresh the page ');
        }
        //* hanapin id na attribute sa $updatedAttributes array




        // $this->refreshTable();
        // $this->closeModal();


    }
    public function resetFormWhenClosed()
    {
        $this->dispatch('close-inventory-form')->to(InventoryManagementPage::class);
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
            'markup' => number_format((($inventory->selling_price - $inventory->cost) / $inventory->cost) * 100, 2),
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
            $this->seling_price  = $cost * (1 + $markup / 100);

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

    public function displayInventoryAdminLoginForm()
    {
        $this->showInventoryForm = !$this->showInventoryForm;
        $this->showInventoryAdminLoginForm = !$this->showInventoryAdminLoginForm;
    }

    public function adminConfirmed($isAdmin)
    {
        $this->isAdmin = $isAdmin;


        if ($this->isAdmin) {
            $this->updateConfirmed();
        }
    }

    public function returnInventoryForm()
    {
        $this->showInventoryForm = !$this->showInventoryForm;
        $this->showInventoryAdminLoginForm = !$this->showInventoryAdminLoginForm;
    }


}
