<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\TransactionMovement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MonthlySalesReport extends Component
{
    public $transactions = [], $transaction_info = [];
    public $hasTransactions = false;

    public function render()
    {
        return view('livewire.components.ReportManagement.monthly-sales-report', [
            'transactions' => $this->transactions
        ]);
    }

    protected $listeners = [
        'generate-report' => 'generateReport'
    ];

    public function generateReport($month)
    {

        $startDate = Carbon::parse($month)->startOfMonth();
        $endDate = Carbon::parse($month)->endOfMonth();
        // Initialize totals for the month
        // Initialize weekly summaries
        $totalGross = 0;
        $totalDiscount = 0;
        $totalTax = 0;
        $totalNet = 0;

        $totalReturnAmount = 0;
        $totalReturnVatAmount = 0;
        $totalVoidAmount = 0;
        $totalVoidVatAmount = 0;


        // Fetch transactions for the specific month (current year)
        $this->transactions = TransactionMovement::whereBetween('created_at', [$startDate, $endDate])
            ->get();
        // Check if transactions are not empty
        if ($this->transactions->isNotEmpty()) {
            $this->hasTransactions = true;

            // Iterate through transactions to sum up
            foreach ($this->transactions as $transaction) {
                // Summing monthly transactions
                switch ($transaction->transaction_type) {
                    case 'Sales':
                        $totalGross += $transaction->transactionJoin->subtotal;
                        $totalTax += $transaction->transactionJoin->total_vat_amount;

                        $totalDiscount += $transaction->transactionJoin->total_discount_amount;

                        break;
                    case 'Return':
                        $totalReturnAmount += $transaction->returnsJoin->return_total_amount;
                        $totalReturnVatAmount += $transaction->returnsJoin->return_vat_amount;
                        break;
                    case 'Credit':
                        $totalGross += $transaction->creditJoin->transactionJoin->subtotal;
                        $totalTax += $transaction->creditJoin->transactionJoin->total_vat_amount;

                        $totalDiscount += $transaction->creditJoin->transactionJoin->total_discount_amount;
                        break;
                    case 'Void':
                        $totalVoidAmount += $transaction->voidTransactionJoin->void_total_amount;
                        $totalVoidVatAmount += $transaction->voidTransactionJoin->void_vat_amount;
                        break;
                }
            }

            // Calculate net values for the month
            $totalGross -= $totalReturnAmount + $totalVoidAmount;
            $totalNet = $totalGross - ($totalTax + $totalReturnVatAmount + $totalVoidVatAmount + $totalDiscount);

            // Prepare report information
            $this->transaction_info = [
                'date' => Carbon::createFromDate($month)->format('Y M'), // Format the month and year
                'totalGross' => $totalGross,
                'totalTax' => $totalTax - $totalReturnVatAmount - $totalVoidVatAmount,
                'totalNet' => $totalNet,
                'totalDiscount' => $totalDiscount,
                'dateCreated' => Carbon::now()->format('M d, Y h:i A'),
                'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname,
            ];
        } else {
            // No transactions found
            $this->hasTransactions = false;
            $this->transaction_info = []; // Clear transaction info
        }
    }


}
