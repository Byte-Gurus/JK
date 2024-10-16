<?php

namespace App\Livewire\Components\Sales;

use App\Models\ReturnDetails;
use App\Models\Returns;
use Livewire\Component;

class ViewSalesReturnDetails extends Component
{
    public $statusFilter = 0;
    public $operationFilter = 0;

    public $return_id, $transaction_number, $transaction_date, $return_date, $original_amount, $return_total_amount, $current_amount, $return_number,$refund_amount, $exchange_amount, $returnedBy, $approvedBy;
    public function render()
    {
        $query = ReturnDetails::where('return_id', $this->return_id);

        if ($this->statusFilter != 0) {
            $query->where('description', $this->statusFilter);
        }
        if ($this->operationFilter != 0) {
            $query->where('operation', $this->operationFilter);
        }

        // Execute the query and get the results
        $return_details = $query->get();

        return view('livewire.components.Sales.view-sales-return-details', [
            'return_details' => $return_details
        ]);
    }

    protected $listeners = [
        'get-return' => 'getReturn', //*  galing sa UserTable class

    ];

    private function populateForm() //*lagyan ng laman ang mga input
    {

        $return_info = Returns::find($this->return_id); //? kunin lahat ng data ng may ari ng item_id


        $this->fill([
            'transaction_number' => $return_info->transactionJoin->transaction_number,
            'transaction_date' => $return_info->transactionJoin->created_at->format('M d Y h:i A'),
            'return_date' => $return_info->created_at->format('M d Y h:i A'),
            'original_amount' => number_format($return_info->original_amount, 2),
            'return_total_amount' => number_format($return_info->return_total_amount, 2),
            'current_amount' => number_format($return_info->transactionJoin->total_amount, 2),
            'return_number' => $return_info->return_number,
            'refund_amount' => $return_info->refund_amount,
            'exchange_amount' => $return_info->exchange_amount,
            'returnedBy' => $return_info->returnedBy,
            'approvedBy' => $return_info->approvedBy,
        ]);
    }

    public function getReturn($return_ID)
    {
        $this->return_id = $return_ID;
        $this->populateForm();
    }
}
