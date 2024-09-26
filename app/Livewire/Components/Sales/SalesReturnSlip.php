<?php

namespace App\Livewire\Components\Sales;

use App\Models\ReturnDetails;
use App\Models\Returns;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Livewire\Component;

class SalesReturnSlip extends Component
{
    public $return_details, $dateCreated, $return_number, $transaction_number, $transaction_date, $user, $item_return_amount;
    public function render()
    {
        $this->return_details = ReturnDetails::where('return_id', $this->return_id)->get();
        return view('livewire.components.Sales.sales-return-slip', [
            'return_details' => $this->return_details
        ]);
}

    protected $listeners = [
        'get-return-details' => 'getReturnDetails'
    ];

    private function populateForm()
    {
        $returns = Returns::find($this->return_id);

        $this->fill([
            'dateCreated' => Carbon::now()->format('M d Y h:i:s A'),
            'return_number' => $returns->return_number,
            'transaction_number' => $returns->transactionJoin->transaction_number,
            'transaction_date' => $returns->transactionJoin->created_at,
            'user' =>  Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname,
            'item_return_amount' => $returns->return_total_amount

        ]);
    }
    public function getReturnDetails($return_id){

        $this->return_id = $return_id;
        $this->populateForm();


    }
}
