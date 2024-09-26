<?php

namespace App\Livewire\Components\Sales;

use App\Models\ReturnDetails;
use App\Models\Returns;
use Auth;
use Carbon\Carbon;
use Livewire\Component;

class SalesReturnSlip extends Component
{
    public $return_details =[], $dateCreated, $return_number, $transaction_number, $transaction_date, $user, $item_return_amount;
    public function render()
    {
        return view('livewire.components.Sales.sales-return-slip');
}

    protected $listeners = [
        'get-return-details' => 'getReturnDetails'
    ];

    private function populateForm()
    {
        $returns = Returns::find($this->return_details['return_id'])->first();

        $this->fill([
            'dateCreated' => Carbon::now()->format('M d Y h:i:s A'),
            'return_number' => $returns->return_number,
            'transaction_number' => $returns->transactionJoin->transaction_number,
            'transaction_date' => $returns->transactionJoin->created_at,
            'user' =>  Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname,
            'item_return_amount' => $this->return_details['item_return_amount']
            // 'total_amount' => $transaction->total_amount,
            // 'payment_method' => $transaction->paymentJoin->payment_type ?? 'N/A',
            // 'reference_number' => $transaction->paymentJoin->reference_number ?? 'N/A',
            // 'discount_amount' => $transaction->total_discount_amount,
            // 'change' => ($transaction->paymentJoin->tendered_amount ?? 0) - ($transaction->paymentJoin->amount ?? 0),
            // 'tendered_amount' => $transaction->paymentJoin->tendered_amount ?? 0,
            // 'subtotal' => $transaction->subtotal,
        ]);
    }
    public function getReturnDetails($return_details){
        $this->return_details = $return_details;
        dd($return_details);
        $this->populateForm();


    }
}
