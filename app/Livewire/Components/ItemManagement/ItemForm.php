<?php

namespace App\Livewire\Components\ItemManagement;

use App\Events\ItemEvent;
use App\Livewire\Pages\ItemManagementPage;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ItemForm extends Component
{
    use LivewireAlert;
    //var null muna silang lahat hanggat d narerender
    public $vatType = null;


    public $item_id, $barcode, $item_name, $item_description, $vat_percent, $status, $create_barcode, $shelf_life_type, $bulk_quantity; //var form inputs
    //var diasble and vat amount by default
    public $proxy_item_id;  //var proxy id para sa supplier id, same sila ng value ng supplier id
    public $isCreate; //var true for create false for edit

    public $hasBarcode = true;

    public function render()
    {

        return view('livewire.components.ItemManagement.item-form');
    }
    protected $listeners = [
        'edit-item-from-table' => 'edit',  //* key:'edit-item-from-table' function:'edit'  galing sa ItemTable class
        //* key:'change-method' value:'changeMethod' galing sa ItemTable class,  laman false
        'change-method' => 'changeMethod',
        'generate-barcode' => 'generateBarcode',
        'updateConfirmed',
        'createConfirmed',
    ];



    public function updatedVatType($vat_type) //@params vat_type for enabling the vat amount
    {
        $this->vatType = $vat_type;

        if ($vat_type == 'Vat') {

            $this->vat_percent = 12;

        } elseif ($vat_type == 'Vat Exempt') {

            $this->vat_percent = 0;
        }
    }
    public function create() //* create process
    {

        $validated = $this->validateForm();

        $this->confirm('Do you want to add this item?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' => $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }

    public function createConfirmed($data) //* confirmation process ng create
    {

        $validated = $data['inputAttributes'];


        DB::beginTransaction();

        try {

            $item = [
                'item_name' => $validated['item_name'],
                'item_description' => $validated['item_description'],
                'vat_type' => $validated['vatType'],
                'shelf_life_type' => $validated['shelf_life_type'],
                'bulk_quantity' => $validated['bulk_quantity'],
                'vat_percent' => $validated['vat_percent'],
                'status_id' => $validated['status'],

            ];

            if ($this->hasBarcode) {
                $item['barcode'] = $validated['create_barcode'];
            } else {
                $item['barcode'] = $validated['barcode'];
            }

            $item = Item::create($item);

            $inventory = Inventory::create([
                'item_id' => $item->id,
            ]);

            $inventoryMovement = InventoryMovement::create([
                'inventory_id' => $inventory->id,
                'movement_type' => 'Inventory',
                'operation' => 'Stock In',
            ]);

            DB::commit();

            $this->alert('success', 'Item was created successfully');
            $this->refreshTable();
            ItemEvent::dispatch('refresh-item');
            $this->resetForm();
            $this->closeModal();


        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            DB::rollback();
            $this->alert('error', 'An error occurred while creating the Item, please refresh the page ');
        }

    }

    public function update() //* update process
    {
        $validated = $this->validateForm();


        $items = Item::find($this->proxy_item_id); //? kunin lahat ng data ng may ari ng proxy_item_id

        //* ipasa ang laman ng validated inputs sa models
        $items->item_name = $validated['item_name'];
        $items->item_description = $validated['item_description'];
        $items->bulk_quantity = $validated['bulk_quantity'];
        $items->shelf_life_type = $validated['shelf_life_type'];
        $items->bulk_quantity = $validated['bulk_quantity'];
        $items->vat_type = $validated['vatType'];
        $items->vat_percent = $validated['vat_percent'];
        $items->status_id = $validated['status'];



        if ($this->hasBarcode) {
            $items->barcode = $validated['create_barcode'];
        } else {
            $items->barcode = $validated['barcode'];
        }

        $attributes = $items->toArray();


        $this->confirm('Do you want to update this item?', [
            'onConfirmed' => 'updateConfirmed', //* call the confmired method
            'inputAttributes' => $attributes, //* pass the $attributes array to the confirmed method
        ]);
    }



    public function updateConfirmed($data) //* confirmation process ng update
    {


        $updatedAttributes = $data['inputAttributes'];

        DB::beginTransaction();

        try {

            $item = Item::find($updatedAttributes['id']);

            if (!$item) {
                // If the item does not exist, rollback and alert the user
                DB::rollback();
                $this->alert('error', 'Item not found.');
                return; // Exit the method
            }

            $item->fill($updatedAttributes);
            $item->save(); //* Save the item model to the database

            $inventories = Inventory::where('item_id', $item->id)->get();

            // Update vat_amount for each related Inventory record
            foreach ($inventories as $inventory) {

                // Update the vat_amount in the Inventory model
                $inventory->vat_amount = ($item->vat_percent / 100) * $inventory->selling_price;
                $inventory->save(); // Save each updated inventory record
            }

            DB::commit();

            $this->resetForm();
            $this->alert('success', 'items was updated successfully');
            ItemEvent::dispatch('refresh-item');
            $this->refreshTable();
            $this->closeModal();

        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            DB::rollback();
            $this->alert('error', 'An error occurred while updating the Item, please refresh the page ');
        }


    }
    public function changeBarcodeForm()
    {
        $this->hasBarcode = !$this->hasBarcode;
    }
    public function generateBarcode()  //* generate a random barcode and contatinate the ITM
    {

        $this->barcode = random_int(100000000000, 999999999999);
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }
    public function edit($itemID)
    {
        $this->item_id = $itemID; //var assign ang parameter value sa global variable
        $this->proxy_item_id = $itemID;  //var proxy_item_id para sa update ng item kasi i null ang item id sa update afetr populating the form

        $this->populateForm();
    }

    private function resetForm() //*tanggalin ang laman ng input pati $item_id value
    {
        $this->reset(['item_id', 'item_description', 'item_name', 'barcode', 'create_barcode', 'vatType', 'vat_percent', 'status', 'bulk_quantity', 'shelf_life_type']);

        $this->hasBarcode = true;
    }
    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(ItemManagementPage::class);
        $this->resetValidation();
    }

    protected function validateForm()
    {
        $this->item_name = trim($this->item_name);
        $this->create_barcode = trim($this->create_barcode);
        $this->barcode = trim($this->barcode);

        $rules = [
            'item_name' => 'required|string|max:255',
            'item_description' => 'required|string|max:255',

            'shelf_life_type' => 'required|in:Perishable,Non Perishable',
            'vat_percent' => ['required', 'numeric', 'min:0'],
            'bulk_quantity' => ['required', 'numeric', 'min:0', 'max:100'],
            'vatType' => 'required|in:Vat,Vat Exempt',
            'status' => 'required|in:1,2',
        ];

        if ($this->hasBarcode) {
            $rules['create_barcode'] = ['required', 'numeric ', 'digits:12', Rule::unique('items', 'barcode')->ignore($this->proxy_item_id)];
        } else {
            $rules['barcode'] = ['required', 'numeric ', 'digits:12', Rule::unique('items', 'barcode')->ignore($this->proxy_item_id)];
        }




        return $this->validate($rules);
    }
    private function populateForm() //*lagyan ng laman ang mga input
    {

        $item_details = Item::find($this->item_id); //? kunin lahat ng data ng may ari ng item_id

        $this->generateBarcode();

        //* ipasa ang laman ng model sa inputs
        //* fill() method [key => value] means [paglalagyan => ilalagay]
        $this->fill([
            'barcode' => $this->barcode,
            'create_barcode' => $item_details->barcode,
            'item_name' => $item_details->item_name,
            'item_description' => $item_details->item_description,
            'shelf_life_type' => $item_details->shelf_life_type,
            'bulk_quantity' => $item_details->bulk_quantity,
            'vatType' => $item_details->vat_type,
            'vat_percent' => $item_details->vat_percent,
            'status' => $item_details->status_id,

        ]);
    }
    public function refreshTable() //* refresh ang table after confirmation
    {
        $this->dispatch('refresh-table')->to(ItemTable::class);
    }
    public function changeMethod($isCreate)
    {
        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        if ($this->isCreate) {


            $this->resetForm();
            $this->status = 2;
            $this->bulk_quantity = 0;
        }

        $this->generateBarcode();
    }
}
