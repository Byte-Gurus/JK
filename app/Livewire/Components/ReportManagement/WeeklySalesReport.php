<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Transaction;
use App\Models\TransactionMovement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WeeklySalesReport extends Component
{
    public $showWeeklySalesReport = false;
    public $hasTransactions = false;

    public $transactions = [], $transaction_info = [];

    public function render()
    {
        return view('livewire.components.ReportManagement.weekly-sales-report', [
            'transactions' => $this->transactions
        ]);
    }

    protected $listeners = [
        'generate-report' => 'generateReport'
    ];

    public function generateReport($week)
    {
        // Parse the week into start and end dates
        $startOfWeek = Carbon::parse($week)->startOfWeek();
        $endOfWeek = Carbon::parse($week)->endOfWeek();

        // Initialize weekly summaries
        $totalGross = 0;
        $totalDiscount = 0;
        $totalTax = 0;
        $totalNet = 0;

        $totalReturnAmount = 0;
        $totalReturnVatAmount = 0;
        $totalVoidAmount = 0;
        $totalVoidVatAmount = 0;



        // Flag to check if there are any transactions in the week
        $this->hasTransactions = false;

        // Fetch transactions for the week
        $this->transactions = TransactionMovement::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();

        // Check if there are any transactions in the week
        if ($this->transactions->isNotEmpty()) {
            $this->hasTransactions = true;

            foreach ($this->transactions as $transaction) {
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

            $totalGross -= $totalReturnAmount + $totalVoidAmount;
            $totalNet = $totalGross - ($totalTax + $totalReturnVatAmount + $totalVoidVatAmount + $totalDiscount);

            // If there were no transactions for the week, return null or a specific message


            // Prepare report information
            $this->transaction_info = [
                'date' => $startOfWeek->format('M d, Y') . ' - ' . $endOfWeek->format('M d, Y'),
                'totalGross' => $totalGross,
                'totalTax' => $totalTax - $totalReturnVatAmount - $totalVoidVatAmount,
                'totalNet' => $totalNet,
                'totalDiscount' => $totalDiscount,
                'dateCreated' => Carbon::now()->format('M d, Y h:i A'),
                'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname
            ];
        }

        // Process transactions for the week

    }





}
