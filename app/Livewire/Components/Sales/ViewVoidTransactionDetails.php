<?php

namespace App\Livewire\Components\Sales;

use App\Models\VoidTransaction;
use App\Models\VoidTransactionDetails;
use Livewire\Component;

class ViewVoidTransactionDetails extends Component
{

    public $reasonFilter = 0;

    public $void_transaction_id, $transaction_number, $transaction_date, $void_date, $orignal_amount, $void_total_amount, $current_amount, $void_number;
    public function render()
    {

        $query = VoidTransactionDetails::where('void_transaction_id', $this->void_transaction_id);


        if ($this->reasonFilter != 0) {
            $query->where('reason', $this->reasonFilter);
        }

        // Execute the query and get the results
        $voidTransactionDetails = $query->get();
        return view('livewire.components.Sales.view-void-transaction-details',[
            'voidTransactionDetails' => $voidTransactionDetails
        ]);
    }

    protected $listeners = [
        'get-void' => 'getVoid', //*  galing sa UserTable class

    ];

    private function populateForm() //*lagyan ng laman ang mga input
    {

        $void_info = VoidTransaction::find($this->void_transaction_id); //? kunin lahat ng data ng may ari ng item_id


        $this->fill([
            'transaction_number' => $void_info->transactionJoin->transaction_number,
            'transaction_date' => $void_info->transactionJoin->created_at,
            'void_date' => $void_info->created_at,
            'orignal_amount' => $void_info->original_amount,
            'void_total_amount' => $void_info->void_total_amount,
            'current_amount' => $void_info->transactionJoin->total_amount,
            'void_number' => $void_info->void_number
        ]);
    }

    public function getVoid($voidTransaction_ID)
    {
        $this->void_transaction_id = $voidTransaction_ID;
        $this->populateForm();
    }

}