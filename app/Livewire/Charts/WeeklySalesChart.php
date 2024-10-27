<?php

namespace App\Livewire\Charts;

use App\Models\TransactionMovement;
use Carbon\Carbon;
use Livewire\Component;

class WeeklySalesChart extends Component
{
    public $week, $totalAmount = 0, $transactionCount = 0;
    public $weeklyTotal = [];

    public function render()
    {
        if (!$this->week) {
            $currentWeek = Carbon::now()->format('Y-\WW'); // Get current week in 'YYYY-WW' format            // Get current month in 'YYYY-MM' format
            $this->updatedWeek($currentWeek);
        }
        return view('livewire.charts.weekly-sales-chart');
    }

    protected $listeners = [
        'get-picker' => 'getPicker',
    ];

    public function updatedWeek($currentWeek)
    {
        // Reset totals for recalculation
        $this->weeklyTotal = [];
        $this->totalAmount = 0;
        $this->transactionCount = 0;

        if (!$this->week) {
            $currentWeek = Carbon::now()->format('Y-\WW'); // Get current week in 'YYYY-WW' format
        }

        // Get the start and end of the week
        $startOfWeek = Carbon::parse($currentWeek)->startOfWeek();
        $endOfWeek = Carbon::parse($currentWeek)->endOfWeek();


        // Get transactions within the current week
        for ($date = $startOfWeek->copy(); $date->lte($endOfWeek); $date->addDay()) {
            // Daily totals
            $dailyGross = 0;
            $dailyTax = 0;

            // Fetch transactions for the current day
            $dailyTransactions = TransactionMovement::whereDate('created_at', $date)->get();
            $dailyTransactionCount = $dailyTransactions->count();
            $this->transactionCount += $dailyTransactionCount;

            foreach ($dailyTransactions as $transaction) {
                switch ($transaction->transaction_type) {
                    case 'Sales':
                        $dailyGross += $transaction->transactionJoin->total_amount;
                        $dailyTax += $transaction->transactionJoin->total_vat_amount;
                        break;
                    case 'Return':
                        $dailyGross -= $transaction->returnsJoin->return_total_amount;
                        $dailyTax -= $transaction->returnsJoin->return_vat_amount;
                        break;
                    case 'Credit':
                        $dailyGross += $transaction->creditJoin->transactionJoin->total_amount;
                        $dailyTax += $transaction->creditJoin->transactionJoin->total_vat_amount;
                        break;
                    case 'Void':
                        $dailyGross -= $transaction->voidTransactionJoin->void_total_amount;
                        $dailyTax -= $transaction->voidTransactionJoin->void_vat_amount;
                        break;
                }
            }

            // Calculate net for the day
            $dailyNet = $dailyGross - $dailyTax;

            // Add daily totals to weeklyTotal array
            $this->weeklyTotal[] = [
                'date' => $date->format('M d, Y'),
                'totalAmount' => $dailyGross,
            ];


            // Set the total amount for the week
            $this->totalAmount += $dailyGross;

            // Dispatch event with updated weekly totals
            $this->dispatch('weeklyTotalUpdated', $this->weeklyTotal);
        }
    }

}
