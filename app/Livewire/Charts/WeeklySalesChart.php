<?php

namespace App\Livewire\Charts;

use App\Models\Transaction;
use App\Models\TransactionMovement;
use Carbon\Carbon;
use Livewire\Component;

class WeeklySalesChart extends Component
{
    public $month, $totalAmount, $transactionCount;
    public $monthlyTotal = [];
    public function render()
    {
        if (!$this->month) {
            $currentMonth = Carbon::now()->format('Y-m'); // Get current month in 'YYYY-MM' format
            $this->updatedMonth($currentMonth);
        }
        return view('livewire.charts.weekly-sales-chart');
    }
    protected $listeners = [
        'get-picker' => 'getPicker',

    ];
    public function updatedMonth($currentMonth)
{
    if (!$this->month) {
        $currentMonth = Carbon::now()->format('Y-m'); // Get current month in 'YYYY-MM' format
    }

    $this->monthlyTotal = [];

    // Get the start and end of the month
    $startOfMonth = Carbon::parse($currentMonth . '-01')->startOfMonth();
    $endOfMonth = Carbon::parse($currentMonth . '-01')->endOfMonth();

    // Initialize totals
    $totalGross = 0;
    $totalTax = 0;
    $totalNet = 0;
    $totalReturnAmount = 0;
    $totalReturnVatAmount = 0;
    $totalVoidAmount = 0;
    $totalVoidVatAmount = 0;
    $totalVoidItemAmount = 0;
    $totalVoidTaxAmount = 0;

    // Iterate through the weeks of the month
    $currentWeek = $startOfMonth->copy();
    while ($currentWeek->lessThanOrEqualTo($endOfMonth)) {
        $startOfWeek = $currentWeek->copy()->startOfWeek();
        $endOfWeek = $currentWeek->copy()->endOfWeek();

        // Ensure the week stays within the bounds of the month
        if ($startOfWeek->lessThan($startOfMonth)) {
            $startOfWeek = $startOfMonth;
        }
        if ($endOfWeek->greaterThan($endOfMonth)) {
            $endOfWeek = $endOfMonth;
        }

        $transactions = TransactionMovement::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
        $this->transactionCount += $transactions->count();

        $weeklySummaries = [];
        foreach ($transactions as $transaction) {
            $date = $transaction->created_at->format('M d Y');

            if (!isset($weeklySummaries[$date])) {
                $weeklySummaries[$date] = [
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

            // Summing weekly transactions
            switch ($transaction->transaction_type) {
                case 'Sales':
                    $weeklySummaries[$date]['totalGross'] += $transaction->transactionJoin->total_amount;
                    $weeklySummaries[$date]['totalTax'] += $transaction->transactionJoin->total_vat_amount;
                    break;
                case 'Return':
                    $weeklySummaries[$date]['totalReturnAmount'] += $transaction->returnsJoin->return_total_amount;
                    $weeklySummaries[$date]['totalReturnVatAmount'] += $transaction->returnsJoin->return_vat_amount;
                    break;
                case 'Credit':
                    $weeklySummaries[$date]['totalGross'] += $transaction->creditJoin->transactionJoin->total_amount;
                    $weeklySummaries[$date]['totalTax'] += $transaction->creditJoin->transactionJoin->total_vat_amount;
                    break;
                case 'Void':
                    $weeklySummaries[$date]['totalVoidAmount'] += $transaction->voidTransactionJoin->void_total_amount;
                    $weeklySummaries[$date]['totalVoidVatAmount'] += $transaction->voidTransactionJoin->void_vat_amount;
                    break;
            }
        }

        foreach ($weeklySummaries as $date => $summary) {
            $weeklyGross = $summary['totalGross'] - ($summary['totalReturnAmount'] + $summary['totalVoidAmount']);
            $weeklyTax = $summary['totalTax'] - ($summary['totalReturnVatAmount'] + $summary['totalVoidVatAmount']);
            $weeklyNet = $weeklyGross - $weeklyTax;

            $summary['totalGross'] = $weeklyGross;
            $summary['totalTax'] = $weeklyTax;
            $summary['totalNet'] = $weeklyNet;

            // Accumulate monthly totals
            $totalGross += $weeklyGross;
            $totalTax += $weeklyTax;
            $totalNet += $weeklyNet;
            $totalReturnAmount += $summary['totalReturnAmount'];
            $totalReturnVatAmount += $summary['totalReturnVatAmount'];
            $totalVoidAmount += $summary['totalVoidAmount'];
            $totalVoidVatAmount += $summary['totalVoidVatAmount'];
            $totalVoidItemAmount += $summary['totalVoidItemAmount'];
            $totalVoidTaxAmount += $summary['totalVoidTaxAmount'];

            $this->monthlyTotal[] = [
                'week_start' => $startOfWeek->format('M d Y'),
                'week_end' => $endOfWeek->format('M d Y'),
                'totalAmount' => $weeklyNet
            ];
        }

        // Move to the next week
        $currentWeek->addWeek();
    }

    $this->totalAmount = $totalNet;

    $this->dispatch('monthlyTotalUpdated', $this->monthlyTotal);
}

}
