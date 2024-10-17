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

    public function generateReport($year)
    {
        // Initialize totals for each month
        $monthlySummaries = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlySummaries[$month] = [
                'totalGross' => 0,
                'totalTax' => 0,
                'totalNet' => 0,
                'totalReturnAmount' => 0,
                'totalReturnVatAmount' => 0,
                'totalVoidAmount' => 0,
                'totalVoidVatAmount' => 0,
                'totalVoidItemAmount' => 0,
                'totalVoidTaxAmount' => 0,
            ];
        }

        // Fetch transactions within the year
        $this->transactions = TransactionMovement::whereYear('created_at', $year)->get();

        // Check if transactions are not empty
        if ($this->transactions->isNotEmpty()) {
            $this->hasTransactions = true;

            // Iterate through transactions to group and sum by month
            foreach ($this->transactions as $transaction) {
                $month = $transaction->created_at->format('n'); // Get month number (1-12)

                // Summing monthly transactions
                switch ($transaction->transaction_type) {
                    case 'Sales':
                        $monthlySummaries[$month]['totalGross'] += $transaction->transactionJoin->total_amount;
                        $monthlySummaries[$month]['totalTax'] += $transaction->transactionJoin->total_vat_amount;
                        break;
                    case 'Return':
                        $monthlySummaries[$month]['totalReturnAmount'] += $transaction->returnsJoin->return_total_amount;
                        $monthlySummaries[$month]['totalReturnVatAmount'] += $transaction->returnsJoin->return_vat_amount;
                        break;
                    case 'Credit':
                        $monthlySummaries[$month]['totalGross'] += $transaction->creditJoin->transactionJoin->total_amount;
                        $monthlySummaries[$month]['totalTax'] += $transaction->creditJoin->transactionJoin->total_vat_amount;
                        break;
                    case 'Void':
                        $monthlySummaries[$month]['totalVoidAmount'] += $transaction->voidTransactionJoin->void_total_amount;
                        $monthlySummaries[$month]['totalVoidVatAmount'] += $transaction->voidTransactionJoin->void_vat_amount;
                        break;
                }
            }

            // Calculate net values for each month and accumulate totals
            $totalGross = 0;
            $totalTax = 0;
            $totalNet = 0;

            foreach ($monthlySummaries as $month => $summary) {
                $monthlyGross = $summary['totalGross'] - ($summary['totalReturnAmount'] + $summary['totalVoidAmount']);
                $monthlyTax = $summary['totalTax'] - ($summary['totalReturnVatAmount'] + $summary['totalVoidVatAmount']);
                $monthlyNet = $monthlyGross - $monthlyTax;

                $monthlySummaries[$month]['totalGross'] = $monthlyGross;
                $monthlySummaries[$month]['totalTax'] = $monthlyTax;
                $monthlySummaries[$month]['totalNet'] = $monthlyNet;

                // Accumulate overall totals
                $totalGross += $monthlyGross;
                $totalTax += $monthlyTax;
                $totalNet += $monthlyNet;
            }

            // Check if any month has transactions
            $hasDataToShow = collect($monthlySummaries)->contains(function ($summary) {
                return $summary['totalGross'] > 0 || $summary['totalNet'] > 0 || $summary['totalTax'] > 0;
            });

            // Prepare report information only if there is data
            if ($hasDataToShow) {
                $this->transaction_info = [
                    'monthlySummaries' => $monthlySummaries,
                    'date' => $year,
                    'dateCreated' => Carbon::now()->format('M d Y h:i A'),
                    'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname,
                    'totalGross' => $totalGross,
                    'totalTax' => $totalTax,
                    'totalNet' => $totalNet,
                ];
            } else {
                $this->transaction_info = []; // Clear transaction info if no data
                $this->hasTransactions = false; // Set flag to indicate no transactions
            }
        } else {
            // No transactions found
            $this->hasTransactions = false;
            $this->transaction_info = []; // Clear transaction info
        }
    }

}
