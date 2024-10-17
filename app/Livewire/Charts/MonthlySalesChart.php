<?php

namespace App\Livewire\Charts;

use App\Models\Transaction;
use App\Models\TransactionMovement;
use Carbon\Carbon;
use Livewire\Component;

class MonthlySalesChart extends Component
{
    public $year, $totalAmount, $transactionCount;
    public $monthlyTotal = [];
    public function render()
    {

        if (!$this->year) {
            $currentYear = Carbon::now()->format('Y');
            $this->updatedYear($currentYear);
        }
        return view('livewire.charts.monthly-sales-chart');
    }

    public function updatedYear($currentYear)
    {
        // If year is not set, use the current year
        if (!$this->year) {
            $currentYear = Carbon::now()->format('Y');
        }

        // Reset monthly totals
        $this->monthlyTotal = [];

        // Set the start and end of the year
        $startOfYear = Carbon::createFromFormat('Y', $currentYear)->startOfYear();
        $endOfYear = Carbon::createFromFormat('Y', $currentYear)->endOfYear();

        // Fetch transactions for the entire year
        $transactions = TransactionMovement::whereBetween('created_at', [$startOfYear, $endOfYear])->get();

        // Count all transactions for the year
        $this->transactionCount = $transactions->count();

        // Initialize monthly summaries
        $monthlySummaries = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::createFromDate($currentYear, $i, 1)->format('Y-M');
            $monthName = Carbon::createFromDate($currentYear, $i, 1)->format('F');

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

        // Initialize yearly totals
        $totalGross = 0;
        $totalTax = 0;
        $totalNet = 0;
        $totalReturnAmount = 0;
        $totalReturnVatAmount = 0;
        $totalVoidAmount = 0;
        $totalVoidVatAmount = 0;

        // Process each transaction
        foreach ($transactions as $transaction) {
            $month = $transaction->created_at->format('Y-M'); // Format to 'YYYY-MM'

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
                $monthlySummaries[$month]['totalVoidAmount'] += $transaction->voidTransactionJoin->void_total_amount;
                $monthlySummaries[$month]['totalVoidVatAmount'] += $transaction->voidTransactionJoin->void_vat_amount;
            }
        }

        // Calculate monthly net values and accumulate yearly totals
        foreach ($monthlySummaries as $month => $summary) {
            $monthlyGross = $summary['totalGross'] - ($summary['totalReturnAmount'] + $summary['totalVoidAmount']);
            $monthlyTax = $summary['totalTax'] - ($summary['totalReturnVatAmount'] + $summary['totalVoidVatAmount']);
            $monthlyNet = $monthlyGross - $monthlyTax;

            // Update the monthly summaries with calculated values
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

            // Store the results for the front-end
            $this->monthlyTotal[] = [
                'month' => $summary['monthName'],
                'totalAmount' => $monthlyNet
            ];
        }

        // Set the total amount for the entire year
        $this->totalAmount = $totalNet;

        // Dispatch the updated monthly totals for the frontend
        $this->dispatch('monthlyTotalUpdated', $this->monthlyTotal);
    }

}
