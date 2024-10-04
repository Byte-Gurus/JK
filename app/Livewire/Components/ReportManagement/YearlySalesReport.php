<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Transaction;
use App\Models\TransactionMovement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class YearlySalesReport extends Component
{
    public $transactions = [], $transaction_info = [];
    public function render()
    {
        return view('livewire.components.ReportManagement.yearly-sales-report', [
            'transactions' => $this->transactions
        ]);
    }

    protected $listeners = [
        'generate-report' => 'generateYearlyReport'
    ];

    public function generateYearlyReport($year)
    {
        // Parse the year into start and end dates
        $startOfYear = Carbon::parse($year)->startOfYear();
        $endOfYear = Carbon::parse($year)->endOfYear();

        // Fetch transactions within the year range
        $this->transactions = TransactionMovement::whereBetween('created_at', [$startOfYear, $endOfYear])->get();

        // Initialize totals and monthly summaries
        $monthlySummaries = [];
        $totalGross = 0;
        $totalTax = 0;
        $totalNet = 0;
        $totalReturnAmount = 0;
        $totalReturnVatAmount = 0;
        $totalVoidAmount = 0;
        $totalVoidVatAmount = 0;

        // Iterate through transactions to group and sum by month
        foreach ($this->transactions as $transaction) {
            $month = $transaction->created_at->format('Y-m'); // Format to 'YYYY-MM'
            $monthName = $transaction->created_at->format('F');

            if (!isset($monthlySummaries[$month])) {
                $monthlySummaries[$month] = [
                    'monthName' => $monthName,
                    'totalGross' => 0,
                    'totalTax' => 0,
                    'totalNet' => 0,
                    'totalReturnAmount' => 0,
                    'totalReturnVatAmount' => 0,
                    'totalVoidAmount' => 0,
                    'totalVoidVatAmount' => 0
                ];
            }

            // Summing monthly transactions
            if ($transaction->transaction_type == 'Sales') {
                $monthlySummaries[$month]['totalGross'] += $transaction->transactionJoin->total_amount;
                $monthlySummaries[$month]['totalTax'] += $transaction->transactionJoin->total_vat_amount;
            } elseif ($transaction->transaction_type == 'Return') {
                $monthlySummaries[$month]['totalReturnAmount'] += $transaction->returnsJoin->return_total_amount;
                $monthlySummaries[$month]['totalReturnVatAmount'] += $transaction->returnsJoin->return_vat_amount;
            } elseif ($transaction->transaction_type == 'Credit') {
                $monthlySummaries[$month]['totalGross'] += $transaction->creditJoin->transactionJoin->total_amount;
                $monthlySummaries[$month]['totalTax'] += $transaction->creditJoin->transactionJoin->total_vat_amount;
            } elseif ($transaction->transaction_type == 'Void') {
                $monthlySummaries[$month]['totalVoidAmount'] += $transaction->transactionJoin->total_amount;
                $monthlySummaries[$month]['totalVoidVatAmount'] += $transaction->transactionJoin->total_vat_amount;
            }
        }

        // Calculate monthly net values and accumulate yearly totals
        foreach ($monthlySummaries as $month => $summary) {
            $monthlyGross = $summary['totalGross'] - $summary['totalReturnAmount'] - $summary['totalVoidAmount'];
            $monthlyTax = $summary['totalTax'] - $summary['totalReturnVatAmount'] - $summary['totalVoidVatAmount'];
            $monthlyNet = $monthlyGross - $monthlyTax;

            $monthlySummaries[$month]['totalGross'] = $monthlyGross;
            $monthlySummaries[$month]['totalTax'] = $monthlyTax;
            $monthlySummaries[$month]['totalNet'] = $monthlyNet;

            // Accumulate yearly totals
            $totalGross += $monthlyGross;
            $totalTax += $monthlyTax;
            $totalNet += $monthlyNet;
            $totalReturnAmount += $summary['totalReturnAmount'];
            $totalReturnVatAmount += $summary['totalReturnVatAmount'];
            $totalVoidAmount += $summary['totalVoidAmount'];
            $totalVoidVatAmount += $summary['totalVoidVatAmount'];
        }

        // Prepare report information
        $this->transaction_info = [
            'totalGross' => $totalGross,
            'totalTax' => $totalTax,
            'totalNet' => $totalNet,
            'totalReturnAmount' => $totalReturnAmount,
            'totalReturnVatAmount' => $totalReturnVatAmount,
            'totalVoidAmount' => $totalVoidAmount,
            'totalVoidVatAmount' => $totalVoidVatAmount,
            'date' => $startOfYear->format('Y'), // Year format
            'dateCreated' => Carbon::now()->format('M d Y h:i A'),
            'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname,
            'monthlySummaries' => $monthlySummaries,
        ];

    }


}
