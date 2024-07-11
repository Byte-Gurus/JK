<?php

namespace App\Livewire\Components\ItemManagement;

use App\Models\Item;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ItemForm extends Component
{
    use LivewireAlert;

    public $barcode, $item_name, $maximum_stock_ratio = 1.5, $reorder_point, $vat_type, $vat_amount, $status;
    public $isCreate; //var true for create false for edit

    public function render()
    {
        return view('livewire.components.ItemManagement.item-form')->with($this->barcode);
    }
    protected $listeners = [
        'edit-supplier-from-table' => 'edit',  //* key:'edit-supplier-from-table' value:'edit'  galing sa SupplierTable class
        //* key:'change-method' value:'changeMethod' galing sa SupplierTable class,  laman false
        'change-method' => 'changeMethod',
        'generate-barcode' => 'generateBarcode',
        'updateConfirmed',
        'createConfirmed',
    ];

    public function create() //* create process
    {

        $validated = $this->validateForm();

        $this->confirm('Do you want to add this supplier?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' =>  $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }

    public function createConfirmed($data) //* confirmation process ng create
    {

        $validated = $data['inputAttributes'];

        $user = Item::create([
            'barcode' => $validated['barcode'],
            'item_name' => $validated['item_name'],
            'maximum_stock_ratio' => $validated['maximum_stock_ratio'],
            'reorder_point' => $validated['reorder_point'],
            'vat_type' => $validated['vat_type'],
            'vat_amount' => $validated['vat_amount'],
            'status_id' => $validated['status'],
        ]);


        $this->alert('success', 'Item was created successfully');
        $this->refreshTable();

        $this->resetForm();
        $this->closeModal();
    }

    public function generateBarcode()
    {
        $numericCode = random_int(10000, 99999);
        $this->barcode = 'ITM-' . $numericCode;
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }

    private function resetForm() //*tanggalin ang laman ng input pati $supplier_id value
    {
        $this->reset(['item_name', 'barcode', 'reorder_point', 'vat_type', 'vat_amount', 'status']);
    }
    protected function validateForm()
    {
        $this->item_name = trim($this->item_name);

        $rules = [
            'barcode' => 'required', Rule::unique('barcode'),
            'item_name' => 'required|string|max:255',
            'maximum_stock_ratio' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'reorder_point' => ['required', 'numeric'],
            'vat_type' => 'required|in:1,2',
            'vat_amount' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'status' => 'required|in:1,2',
        ];

        return $this->validate($rules);
    }

    public function changeMethod($isCreate)
    {
        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        if ($this->isCreate) {

            $this->resetForm();
        }
    }
}
