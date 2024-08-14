<?php

namespace App\Livewire\Components\ItemManagement;

use App\Livewire\Pages\ItemManagementPage;
use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ItemForm extends Component
{
    use LivewireAlert;
    //var null muna silang lahat hanggat d narerender
    public $vatType = null;


    public $item_id, $barcode, $item_name, $item_description, $maximum_stock_ratio = 1.5, $reorder_point, $reorderPercentage, $vat_amount, $status, $create_barcode; //var form inputs
    public $vat_amount_enabled = false; //var diasble and vat amount by default
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

    public function updatedReorderPercentage()
    {
        // Fetch the item's quantity from the inventory
        $inventoryItem = Inventory::where('item_id', $this->proxy_item_id)->first();

        // Check if the inventory item exists and multiply the reorder percentage by the quantity
        if ($inventoryItem) {
            $this->reorder_point = $this->reorderPercentage * $inventoryItem->quantity;
        } else {
            $this->reorder_point = 0; // Default to 0 if the item is not found
        }
    }

    public function updatedVatType($vat_type) //@params vat_type for enabling the vat amount
    {
        $this->vatType = $vat_type;

        if ($vat_type == 'Vat') {
            $this->vat_amount_enabled = true;
        } elseif ($vat_type == 'Non vat') {
            $this->vat_amount_enabled = false;
            $this->vat_amount = 0;
        }
    }
    public function create() //* create process
    {

        $validated = $this->validateForm();

        $this->confirm('Do you want to add this item?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' =>  $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }

    public function createConfirmed($data) //* confirmation process ng create
    {

        $validated = $data['inputAttributes'];


        $item = [
            'item_name' => $validated['item_name'],
            'item_description' => $validated['item_description'],
            'maximum_stock_ratio' => $validated['maximum_stock_ratio'],
            'reorder_point' => $validated['reorder_point'],
            'reorder_percentage' => $validated['reorderPercentage'],
            'vat_type' => $validated['vatType'],
            'vat_amount' => $validated['vat_amount'],
            'status_id' => $validated['status'],
        ];

        // Add barcode based on the condition
        if ($this->hasBarcode) {
            $item['barcode'] = $validated['create_barcode'];
        } else {
            $item['barcode'] = $validated['barcode'];
        }

        $item = Item::create($item);

        $this->alert('success', 'Item was created successfully');
        $this->refreshTable();

        $this->resetForm();
        $this->closeModal();
    }

    public function update() //* update process
    {
        $validated = $this->validateForm();


        $items = Item::find($this->proxy_item_id); //? kunin lahat ng data ng may ari ng proxy_item_id

        //* ipasa ang laman ng validated inputs sa models
        $items->item_name = $validated['item_name'];
        $items->item_description = $validated['item_description'];
        $items->maximum_stock_ratio = $validated['maximum_stock_ratio'];
        $items->reorder_percentage = $validated['reorderPercentage'];
        $items->reorder_point = $validated['reorder_point'];
        $items->vat_type = $validated['vatType'];
        $items->vat_amount = $validated['vat_amount'];
        $items->status_id = $validated['status'];

        if ($this->hasBarcode) {
            $items->barcode = $validated['create_barcode'];
        } else {
            $items->barcode = $validated['barcode'];
        }

        $attributes = $items->toArray();


        $this->confirm('Do you want to update this supplier?', [
            'onConfirmed' => 'updateConfirmed', //* call the confmired method
            'inputAttributes' =>  $attributes, //* pass the $attributes array to the confirmed method
        ]);
    }



    public function updateConfirmed($data) //* confirmation process ng update
    {


        //var sa loob ng $data array, may array pa ulit (inputAttributes), extract the inputAttributes then assign the array to a variable array
        $updatedAttributes = $data['inputAttributes'];

        //* hanapin id na attribute sa $updatedAttributes array
        $item = Item::find($updatedAttributes['id']);

        //* fill() method [key => value] means [paglalagyan => ilalagay]
        //* the fill() method automatically knows kung saan ilalagay ang elements as long as mag match ang mga keys, $item have same keys with $updatedAttributes array
        //var ipasa ang laman ng $updatedAttributes sa $item model
        $item->fill($updatedAttributes);

        $item->save(); //* Save the item model to the database

        $this->resetForm();
        $this->alert('success', 'items was updated successfully');

        $this->refreshTable();
        $this->closeModal();
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
        $this->reset(['item_id', 'item_description', 'item_name', 'barcode', 'create_barcode', 'reorder_point', 'reorderPercentage', 'vatType', 'vat_amount', 'status',]);
        $this->vat_amount_enabled = false;
        $this->hasBarcode = true;
    }
    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(ItemManagementPage::class);
    }

    protected function validateForm()
    {
        $this->item_name = trim($this->item_name);

        $rules = [
            'item_name' => 'required|string|max:255',
            'item_description' => 'required|string|max:255',
            'maximum_stock_ratio' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'reorderPercentage' => ['required', 'numeric','min:1'],
            'reorder_point' => ['required', 'numeric','min:0'],
            'vat_amount' => ['required', 'numeric','min:0'],
            'vatType' => 'required|in:Vat,Non vat',
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
            'maximum_stock_ratio' => $item_details->maximum_stock_ratio,
            'reorderPercentage' => $item_details->reorder_percentage,
            'reorder_point' => $item_details->reorder_point,
            'vatType' => $item_details->vat_type,
            'vat_amount' => $item_details->vat_amount,
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
        }

        $this->generateBarcode();
    }
}
