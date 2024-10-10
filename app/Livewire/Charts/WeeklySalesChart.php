<?php

namespace App\Livewire\Charts;

use App\Models\Transaction;
use App\Models\TransactionMovement;
use Carbon\Carbon;
use Livewire\Component;

class WeeklySalesChart extends Component
{
    public $week, $totalAmount, $transactionCount;
    public $weeklyTotal = [];
    public function render()
    {
        if (!$this->week) {
            $currentWeek = Carbon::now()->format('o-\WW');
            $this->updatedWeek($currentWeek);
        }
        return view('livewire.charts.weekly-sales-chart');
    }
    protected $listeners = [
        'get-picker' => 'getPicker',

    ];
    public function updatedWeek($currentWeek)
    {

        if (!$this->week) {
            $currentWeek = Carbon::now()->format('o-\WW');
        }

        $this->weeklyTotal = [];

        $startOfWeek = Carbon::parse($currentWeek)->startOfWeek();
        $endOfWeek = Carbon::parse($currentWeek)->endOfWeek();

        $transactions = TransactionMovement::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
        $this->transactionCount = TransactionMovement::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        // Initialize totals and daily summaries
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

        // Iterate through transactions to group and sum by day
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

            // $dailySummaries[$date]['totalVoidItemAmount'] += $transaction->totalVoidItemAmount;
            // $dailySummaries[$date]['totalVoidTaxAmount'] += $transaction->vatable_amount + $transaction->vat_exempt_amount;
        }
        foreach ($dailySummaries as $date => $summary) {
            $dailyGross = $summary['totalGross'] - ($summary['totalReturnAmount'] + $summary['totalVoidAmount']);
            $dailyTax = $summary['totalTax'] - ($summary['totalReturnVatAmount'] + $summary['totalVoidVatAmount']);
            $dailyNet = $dailyGross - $dailyTax;

            $dailySummaries[$date]['totalGross'] = $dailyGross;
            $dailySummaries[$date]['totalTax'] = $dailyTax;
            $dailySummaries[$date]['totalNet'] = $dailyNet;

            // Accumulate weekly totals
            $totalGross += $dailyGross;
            $totalTax += $dailyTax;
            $totalNet += $dailyNet;
            $totalReturnAmount += $summary['totalReturnAmount'];
            $totalReturnVatAmount += $summary['totalReturnVatAmount'];
            $totalVoidAmount += $summary['totalVoidAmount'] + $summary['totalVoidItemAmount'];
            $totalVoidVatAmount += $summary['totalVoidVatAmount'];
            $totalVoidItemAmount += $summary['totalVoidItemAmount'];
            $totalVoidTaxAmount += $summary['totalVoidTaxAmount'];

            $this->weeklyTotal[] = [
                'date' => $date,
                'totalAmount' => $dailyNet
            ];

        }


        $this->totalAmount = $totalNet;

        $this->dispatch('weeklyTotalUpdated', $this->weeklyTotal);
    }
}
