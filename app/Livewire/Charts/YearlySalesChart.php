<?php

namespace App\Livewire\Charts;

use App\Models\Transaction;
use App\Models\TransactionMovement;
use Carbon\Carbon;
use Livewire\Component;

class YearlySalesChart extends Component
{

    public $year, $totalAmount, $transactionCount;
    public $yearlyTotal = [];

    public function render()
    {
        if (!$this->year) {
            $currentYear = Carbon::now()->format('Y');
            $this->updatedYear($currentYear);
        }
        return view('livewire.charts.yearly-sales-chart');
    }

    public function updatedYear($currentYear)
    {


        if (!$this->year) {
            $currentYear = Carbon::now()->format('Y');
        }

        $this->yearlyTotal = [];

        $startOfYear = Carbon::createFromFormat('Y', $currentYear)->startOfYear();
        $endOfYear = Carbon::createFromFormat('Y', $currentYear)->endOfYear();


        $transactions = TransactionMovement::whereBetween('created_at', [$startOfYear, $endOfYear])->get();

       

        $this->transactionCount = TransactionMovement::whereBetween('created_at', [$startOfYear, $endOfYear])->count();

        $monthlySummaries = [];
        $totalGross = 0;
        $totalTax = 0;
        $totalNet = 0;
        $totalReturnAmount = 0;
        $totalReturnVatAmount = 0;
        $totalVoidAmount = 0;
        $totalVoidVatAmount = 0;

        foreach ($transactions as $transaction) {
            $month = $transaction->created_at->format('Y-M'); // Format to 'YYYY-MM'
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
                $monthlySummaries[$month]['totalVoidAmount'] += $transaction->voidTransactionJoin->void_total_amount;
                $monthlySummaries[$month]['totalVoidVatAmount'] += $transaction->voidTransactionJoin->void_vat_amount;
            }
        }

        // Calculate monthly net values and accumulate yearly totals
        foreach ($monthlySummaries as $month => $summary) {
            $monthlyGross = $summary['totalGross'] - ($summary['totalReturnAmount'] + $summary['totalVoidAmount']);
            $monthlyTax = $summary['totalTax'] - ($summary['totalReturnVatAmount'] + $summary['totalVoidVatAmount']);
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

        $this->yearlyTotal[] = [
            'date' => $month ?? '',
            'totalAmount' => $monthlyNet ?? ''
        ];

        $this->totalAmount = $totalNet;

        $this->dispatch('yearlyTotalUpdated', $this->yearlyTotal);
        // Uncomment the line below to debug the yearly total
        // dd($this->yearlyTotal);
    }
}
