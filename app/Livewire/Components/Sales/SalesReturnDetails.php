<?php

namespace App\Livewire\Components\Sales;

use App\Models\Transaction;
use App\Models\TransactionDetails;
use Livewire\Component;

class SalesReturnDetails extends Component
{
    public $showSalesReturnForm = false;

    public $transaction_number, $transaction_date, $total_amount, $payment_method, $reference_number, $discount_amount, $change, $tendered_amount, $subtotal, $transaction_id, $transaction_type, $return_quantity;

    public function render()
    {

        $transactionDetails = TransactionDetails::where('transaction_id', $this->transaction_id)->get();

        return view('livewire.components.sales.sales-return-details', [
            'transactionDetails' => $transactionDetails,
        ]);
    }
    protected $listeners = [
        'get-transaction' => 'getTransaction',

    ];
    private function populateForm() //*lagyan ng laman ang mga input
    {

        $transaction = Transaction::find($this->transaction_id);

        $this->fill([
            'transaction_number' => $transaction->transaction_number,
            'transaction_date' => $transaction->created_at,
            'transaction_type' => $transaction->transaction_type,
            'total_amount' => $transaction->total_amount,
            'payment_method' => $transaction->paymentJoin->payment_type,
            'reference_number' => $transaction->paymentJoin->reference_number ?? 'N/A',
            'discount_amount' => $transaction->total_discount_amount,
            'change' => $transaction->paymentJoin->tendered_amount - $transaction->paymentJoin->amount,
            'tendered_amount' => $transaction->paymentJoin->tendered_amountm,
            'subtotal' => $transaction->subtotal,

        ]);
    }

    public function getTransaction($Transaction)
    {
        $this->transaction_id = $Transaction['id'];
        $this->populateForm();
    }

    public function displaySalesReturnForm()
    {
        $this->showSalesReturnForm = true;
    }
}
