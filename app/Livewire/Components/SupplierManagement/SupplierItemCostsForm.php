<?php

namespace App\Livewire\Components\SupplierManagement;

use App\Models\SupplierItems;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class SupplierItemCostsForm extends Component
{
    use LivewireAlert;
    public $isCreateSupplierItemCosts = true;
    public $supplier_id, $item_cost, $item_id;
    public function render()
    {
        return view('livewire.components.SupplierManagement.supplier-item-costs-form');
    }

    protected $listeners = [
        'edit-supplier-item-costs-from-table' => 'edit',  //* key:'edit-supplier-from-table' value:'edit'  galing sa SupplierTable class
        //* key:'change-method' value:'changeMethod' galing sa SupplierTable class,  laman false
        'change-method' => 'changeMethod',
        'set-supplier-cost' => 'setSupplierCost',
        'updateConfirmed',
        'createConfirmed',
    ];

    private function resetForm() //*tanggalin ang laman ng input pati $supplier_id value
    {
        $this->reset();
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }

    public function create()
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

            $supplierItem = [
                'item_cost' => $validated['item_cost'],
                'item_id' => $this->item_id,
                'supplier_id' => $this->supplier_id,

            ];

            $supplierItem = SupplierItems::create($supplierItem);

            $userName = Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname;

            $log = Log::create([
                'user_id' => Auth::user()->id,
                'message' => $userName . ' (' . Auth::user()->username . ') ' . 'Created an item',
                'action' => 'Supplier Item Create'
            ]);

            DB::commit();

            $this->alert('success', 'Item was created successfully');
            $this->refreshTable();
            // ItemEvent::dispatch('refresh-item');
            $this->resetForm();
            $this->closeModal();


        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            dump($e);
            DB::rollback();
            $this->alert('error', 'An error occurred while creating the Item, please refresh the page ');
        }

    }
    public function changeMethod($isCreateSupplierItemCosts)
    {
        $this->isCreateSupplierItemCosts = $isCreateSupplierItemCosts; //var assign ang parameter value sa global variable

        if ($this->isCreateSupplierItemCosts) {
            // $this->status = 1;
            $this->resetForm();
        }
    }

    public function setSupplierCost($itemId, $supplier_id)
    {
        dump()
        $this->supplier_id = $supplier_id;
        $this->item_id = $itemId;

    }

    protected function validateForm()
    {

        $rules = [
            "item_cost" => "required|numeric|min:0"
        ];

        return $this->validate($rules);
    }
}
