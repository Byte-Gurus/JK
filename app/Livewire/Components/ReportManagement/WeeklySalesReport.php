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

    public function generateReport($month)
    {
        // Parse the month into start and end dates
        $startOfMonth = Carbon::parse($month . '-01')->startOfMonth();
        $endOfMonth = Carbon::parse($month . '-01')->endOfMonth();

        // Initialize weekly summaries
        $weeklySummaries = [];
        $totalGross = 0;
        $totalTax = 0;
        $totalNet = 0;
        $totalReturnAmount = 0;
        $totalReturnVatAmount = 0;
        $totalVoidAmount = 0;
        $totalVoidVatAmount = 0;
        $totalVoidItemAmount = 0;
        $totalVoidTaxAmount = 0;

        // Flag to check if there are any transactions in the month


        // Loop through each week in the month
        $currentDate = $startOfMonth->copy();
        while ($currentDate->lessThanOrEqualTo($endOfMonth)) {
            $startOfWeek = $currentDate->copy()->startOfWeek();
            $endOfWeek = $currentDate->copy()->endOfWeek();

            // Ensure the end of the week doesn't go beyond the end of the month
            if ($startOfWeek->lessThan($startOfMonth)) {
                $startOfWeek = $startOfMonth;
            }
            if ($endOfWeek->greaterThan($endOfMonth)) {
                $endOfWeek = $endOfMonth;
            }

            $this->transactions = TransactionMovement::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();

            // Initialize weekly summary
            $weeklySummaries[$startOfWeek->format('M d, Y') . ' to ' . $endOfWeek->format('M d, Y')] = [
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

            // Check if there are any transactions in the current week
            if ($this->transactions->isNotEmpty()) {
                $this->hasTransactions = true;
            }

            // Process transactions for the current week
            foreach ($this->transactions as $transaction) {
                switch ($transaction->transaction_type) {
                    case 'Sales':
                        $weeklySummaries[$startOfWeek->format('M d, Y') . ' to ' . $endOfWeek->format('M d, Y')]['totalGross'] += $transaction->transactionJoin->total_amount;
                        $weeklySummaries[$startOfWeek->format('M d, Y') . ' to ' . $endOfWeek->format('M d, Y')]['totalTax'] += $transaction->transactionJoin->total_vat_amount;
                        break;
                    case 'Return':
                        $weeklySummaries[$startOfWeek->format('M d, Y') . ' to ' . $endOfWeek->format('M d, Y')]['totalReturnAmount'] += $transaction->returnsJoin->return_total_amount;
                        $weeklySummaries[$startOfWeek->format('M d, Y') . ' to ' . $endOfWeek->format('M d, Y')]['totalReturnVatAmount'] += $transaction->returnsJoin->return_vat_amount;
                        break;
                    case 'Credit':
                        $weeklySummaries[$startOfWeek->format('M d, Y') . ' to ' . $endOfWeek->format('M d, Y')]['totalGross'] += $transaction->creditJoin->transactionJoin->total_amount;
                        $weeklySummaries[$startOfWeek->format('M d, Y') . ' to ' . $endOfWeek->format('M d, Y')]['totalTax'] += $transaction->creditJoin->transactionJoin->total_vat_amount;
                        break;
                    case 'Void':
                        $weeklySummaries[$startOfWeek->format('M d, Y') . ' to ' . $endOfWeek->format('M d, Y')]['totalVoidAmount'] += $transaction->voidTransactionJoin->void_total_amount;
                        $weeklySummaries[$startOfWeek->format('M d, Y') . ' to ' . $endOfWeek->format('M d, Y')]['totalVoidVatAmount'] += $transaction->voidTransactionJoin->void_vat_amount;
                        break;
                }
            }

            // Calculate weekly net values and accumulate totals if there were transactions
            if ($this->hasTransactions) {
                $weeklySummary = $weeklySummaries[$startOfWeek->format('M d, Y') . ' to ' . $endOfWeek->format('M d, Y')];
                $weeklyGross = $weeklySummary['totalGross'] - ($weeklySummary['totalReturnAmount'] + $weeklySummary['totalVoidAmount']);
                $weeklyTax = $weeklySummary['totalTax'] - ($weeklySummary['totalReturnVatAmount'] + $weeklySummary['totalVoidVatAmount']);
                $weeklyNet = $weeklyGross - $weeklyTax;

                $weeklySummaries[$startOfWeek->format('M d, Y') . ' to ' . $endOfWeek->format('M d, Y')]['totalGross'] = $weeklyGross;
                $weeklySummaries[$startOfWeek->format('M d, Y') . ' to ' . $endOfWeek->format('M d, Y')]['totalTax'] = $weeklyTax;
                $weeklySummaries[$startOfWeek->format('M d, Y') . ' to ' . $endOfWeek->format('M d, Y')]['totalNet'] = $weeklyNet;

                // Accumulate monthly totals
                $totalGross += $weeklyGross;
                $totalTax += $weeklyTax;
                $totalNet += $weeklyNet;
                $totalReturnAmount += $weeklySummary['totalReturnAmount'];
                $totalReturnVatAmount += $weeklySummary['totalReturnVatAmount'];
                $totalVoidAmount += $weeklySummary['totalVoidAmount'] + $weeklySummary['totalVoidItemAmount'];
                $totalVoidVatAmount += $weeklySummary['totalVoidVatAmount'];
                $totalVoidItemAmount += $weeklySummary['totalVoidItemAmount'];
                $totalVoidTaxAmount += $weeklySummary['totalVoidTaxAmount'];
            }

            // Move to the next week
            $currentDate->addWeek();
        }

        // If there were no transactions for the entire month, return null or a specific message
        if (!$this->hasTransactions) {
            return null;
        }

        // Prepare report information
        $this->transaction_info = [
            'date' => $startOfMonth->format('M d, Y') . ' - ' . $endOfMonth->format('M d, Y'), // This can remain as is
            'totalGross' => $totalGross,
            'totalTax' => $totalTax,
            'totalNet' => $totalNet,
            'totalReturnAmount' => $totalReturnAmount,
            'totalReturnVatAmount' => $totalReturnVatAmount,
            'totalVoidAmount' => $totalVoidAmount,
            'totalVoidVatAmount' => $totalVoidVatAmount,
            'totalVoidItemAmount' => $totalVoidItemAmount,
            'totalVoidTaxAmount' => $totalVoidTaxAmount,
            'weeklySummaries' => $weeklySummaries,
            'dateCreated' => Carbon::now()->format('M d, Y h:i A'),
            'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname
        ];
    }




}
