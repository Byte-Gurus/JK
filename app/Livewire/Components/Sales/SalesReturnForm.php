<?php

namespace App\Livewire\Components\Sales;

use App\Models\ReturnDetails;
use App\Models\Returns;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SalesReturnForm extends Component
{
    use LivewireAlert;

    public $transactionDetails_id, $sku_code, $item_quantity, $item_name, $return_quantity, $return_reason, $transaction_id, $selling_price;
    public $showSalesReturnForm = false;
    public $showAdminLoginForm = false;

    public function render()
    {
        return view('livewire.components.Sales.sales-return-form');
    }

    protected $listeners = [
        'get-transaction-details' => 'getTransactionDetails',
        'returnConfirmed'

    ];
    public function return()
    {
        $validated = $this->validateForm();

        $this->confirm('Do you want to return this item?', [
            'onConfirmed' => 'returnConfirmed', //* call the createconfirmed method
            'inputAttributes' =>  $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }

    public function returnConfirmed($data)
    {
        $validated = $data['inputAttributes'];

        $returns = Returns::create([
            'transaction_id' => $this->transaction_id,
        ]);

        $return_details = ReturnDetails::create([
            'return_quantity' => $this->return_quantity,
            'return_amount' => $this->return_quantity * $this->selling_price,
            'description' => $this->return_reason,
            'return_id' => $returns->id,
            'transaction_details_id' => $this->transactionDetails_id,
        ]);

        $this->alert('success', 'items was returned successfully');
    }


    private function populateForm() //*lagyan ng laman ang mga input
    {

        $transaction_details = TransactionDetails::find($this->transactionDetails_id);

        $this->transaction_id = $transaction_details->transaction_id;

        $this->selling_price = $transaction_details->inventoryJoin->selling_price;

        $this->fill([
            'sku_code' => $transaction_details->inventoryJoin->sku_code,
            'item_quantity' => $transaction_details->item_quantity,
            'item_name' => $transaction_details->itemJoin->item_name

        ]);
    }

    protected function validateForm()
    {
        $this->return_quantity = trim($this->return_quantity);

        $rules = [
            'return_quantity' => ['required', 'numeric', 'min:1', 'lte:item_quantity'],
            'return_reason' => 'required|string|max:255',

        ];
        return $this->validate($rules);
    }

    public function getTransactionDetails($transactionDetails_ID)
    {

        $this->transactionDetails_id = $transactionDetails_ID;

        $this->populateForm();
    }
}
