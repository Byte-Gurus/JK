<?php

namespace App\Livewire\Charts;

use App\Models\Transaction;
use App\Models\TransactionMovement;
use Carbon\Carbon;
use Livewire\Component;

class MonthlySalesChart extends Component
{
    public $month, $totalAmount, $transactionCount;
    public $monthlyTotal = [];
    public function render()
    {

        if (!$this->month) {
            $currentMonth = Carbon::now()->format('Y-m');
            $this->updatedMonth($currentMonth);
        }
        return view('livewire.charts.monthly-sales-chart');
    }

    public function updatedMonth($currentMonth)
    {

        if (!$this->month) {
            $currentMonth = Carbon::now()->format('Y-m');

        }
        $this->monthlyTotal = [];
        // Get the start and end dates of the month
        $startOfMonth = Carbon::parse($currentMonth)->startOfMonth();
        $endOfMonth = Carbon::parse($currentMonth)->endOfMonth();

        $transactions = TransactionMovement::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        $this->transactionCount = TransactionMovement::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        // Loop through each day of the month
        $dailySummaries = [];
        $totalGross = 0;
        $totalTax = 0;
        $totalNet = 0;
        $totalReturnAmount = 0;
        $totalReturnVatAmount = 0;
        $totalVoidAmount = 0;
        $totalVoidVatAmount = 0;
        $totalVoidItemAmount = 0;
        $totalVoidTaxAmount = 0;

        foreach ($transactions as $transaction) {
            $date = $transaction->created_at->format('M d Y');

            if (!isset($dailySummaries[$date])) {
                $dailySummaries[$date] = [
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

            // Summing daily transactions
            switch ($transaction->transaction_type) {
                case 'Sales':
                    $dailySummaries[$date]['totalGross'] += $transaction->transactionJoin->total_amount;
                    $dailySummaries[$date]['totalTax'] += $transaction->transactionJoin->total_vat_amount;

                    break;
                case 'Return':
                    $dailySummaries[$date]['totalReturnAmount'] += $transaction->returnsJoin->return_total_amount;
                    $dailySummaries[$date]['totalReturnVatAmount'] += $transaction->returnsJoin->return_vat_amount;

                    break;
                case 'Credit':
                    $dailySummaries[$date]['totalGross'] += $transaction->creditJoin->transactionJoin->total_amount;
                    $dailySummaries[$date]['totalTax'] += $transaction->creditJoin->transactionJoin->total_vat_amount;

                    break;
                case 'Void':
                    $dailySummaries[$date]['totalVoidAmount'] += $transaction->voidTransactionJoin->void_total_amount;
                    $dailySummaries[$date]['totalVoidVatAmount'] += $transaction->voidTransactionJoin->void_vat_amount;

                    break;
            }

        }

        // Calculate daily net values and accumulate monthly totals
        foreach ($dailySummaries as $date => $summary) {
            $dailyGross = $summary['totalGross'] - ($summary['totalReturnAmount'] + $summary['totalVoidAmount']);
            $dailyTax = $summary['totalTax'] - ($summary['totalReturnVatAmount'] + $summary['totalVoidVatAmount']);
            $dailyNet = $dailyGross - $dailyTax;

            $dailySummaries[$date]['totalGross'] = $dailyGross;
            $dailySummaries[$date]['totalTax'] = $dailyTax;
            $dailySummaries[$date]['totalNet'] = $dailyNet;

            // Accumulate monthly totals
            $totalGross += $dailyGross;
            $totalTax += $dailyTax;
            $totalNet += $dailyNet;
            $totalReturnAmount += $summary['totalReturnAmount'];
            $totalReturnVatAmount += $summary['totalReturnVatAmount'];
            $totalVoidAmount += $summary['totalVoidAmount'] + $summary['totalVoidItemAmount'];
            $totalVoidVatAmount += $summary['totalVoidVatAmount'];
            $totalVoidItemAmount += $summary['totalVoidItemAmount'];
            $totalVoidTaxAmount += $summary['totalVoidTaxAmount'];

            $this->monthlyTotal[] = [
                'date' => $date,
                'totalAmount' => $dailyNet
            ];


        }



        $this->totalAmount = $totalNet;



        $this->dispatch('monthlyTotalUpdated', $this->monthlyTotal);
    }
}
