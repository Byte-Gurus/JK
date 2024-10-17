<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\TransactionMovement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class YearlySalesReport extends Component
{
    public $transactions = [], $transaction_info = [];
    public $hasTransaction = false;

    public function render()
    {
        return view('livewire.components.ReportManagement.yearly-sales-report', [
            'transactions' => $this->transactions,
            'transaction_info' => $this->transaction_info,
        ]);
    }

    protected $listeners = [
        'generate-report' => 'generateYearlyReport'
    ];

    public function generateYearlyReport($fromYear, $toYear)
    {
        // Initialize an array to hold yearly data
        $yearlySummaries = [];
        $this->hasTransaction = false; // Default to false

        // Initialize overall totals
        $totalGross = 0;
        $totalTax = 0;
        $totalNet = 0;

        // Iterate over the years from fromYear to toYear
        for ($year = $fromYear; $year <= $toYear; $year++) {
            // Parse the year into start and end dates
            $startOfYear = Carbon::createFromFormat('Y', $year)->startOfYear();
            $endOfYear = Carbon::createFromFormat('Y', $year)->endOfYear();

            // Fetch transactions within the year range
            $transactions = TransactionMovement::whereBetween('created_at', [$startOfYear, $endOfYear])->get();

            $totalGrossForYear = 0;
            $totalTaxForYear = 0;
            $totalNetForYear = 0;
            $totalReturnAmount = 0;
            $totalReturnVatAmount = 0;
            $totalVoidAmount = 0;
            $totalVoidVatAmount = 0;

            // Check if there are any transactions for the year
            if ($transactions->isNotEmpty()) {
                $this->hasTransaction = true; // Set to true if there are transactions

                // Iterate through transactions to group and sum
                foreach ($transactions as $transaction) {
                    if ($transaction->transaction_type == 'Sales') {
                        $totalGrossForYear += $transaction->transactionJoin->total_amount;
                        $totalTaxForYear += $transaction->transactionJoin->total_vat_amount;
                    } elseif ($transaction->transaction_type == 'Return') {
                        $totalReturnAmount += $transaction->returnsJoin->return_total_amount;
                        $totalReturnVatAmount += $transaction->returnsJoin->return_vat_amount;
                    } elseif ($transaction->transaction_type == 'Credit') {
                        $totalGrossForYear += $transaction->creditJoin->transactionJoin->total_amount;
                        $totalTaxForYear += $transaction->creditJoin->transactionJoin->total_vat_amount;
                    } elseif ($transaction->transaction_type == 'Void') {
                        $totalVoidAmount += $transaction->voidTransactionJoin->void_total_amount;
                        $totalVoidVatAmount += $transaction->voidTransactionJoin->void_vat_amount;
                    }
                }

                // Calculate net values for the year
                $yearlyGross = $totalGrossForYear - ($totalReturnAmount + $totalVoidAmount);
                $yearlyTax = $totalTaxForYear - ($totalReturnVatAmount + $totalVoidVatAmount);
                $yearlyNet = $yearlyGross - $yearlyTax;

                // Store the results for the year
                $yearlySummaries[$year] = [
                    'totalGross' => $yearlyGross,
                    'totalTax' => $yearlyTax,
                    'totalNet' => $yearlyNet,
                    'totalReturnAmount' => $totalReturnAmount,
                    'totalReturnVatAmount' => $totalReturnVatAmount,
                    'totalVoidAmount' => $totalVoidAmount,
                    'totalVoidVatAmount' => $totalVoidVatAmount,
                ];

                // Accumulate total values for the report
                $totalGross += $yearlyGross;
                $totalTax += $yearlyTax;
                $totalNet += $yearlyNet;
            } else {
                // If there are no transactions for this year, add a placeholder with zeros
                $yearlySummaries[$year] = [
                    'totalGross' => 0,
                    'totalTax' => 0,
                    'totalNet' => 0,
                    'totalReturnAmount' => 0,
                    'totalReturnVatAmount' => 0,
                    'totalVoidAmount' => 0,
                    'totalVoidVatAmount' => 0,
                ];
            }
        }

        // Prepare report information
        $this->transaction_info = [
            'yearlySummaries' => $yearlySummaries,
            'totalGross' => $totalGross, // Set overall totals
            'totalTax' => $totalTax,
            'totalNet' => $totalNet,
            'date' => $fromYear . ' to ' . $toYear,
            'dateCreated' => Carbon::now()->format('M d Y h:i A'),
            'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname,
        ];

        // Check if there were transactions across the years
        $this->hasTransaction = !empty(array_filter($yearlySummaries, function ($summary) {
            return $summary['totalGross'] > 0;
        }));
    }
}
