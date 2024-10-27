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
        // If month is not set, use the current month
        if (!$this->month) {
            $currentMonth = Carbon::now()->format('Y-m');
        }

        // Reset daily totals and transaction count
        $this->monthlyTotal = [];
        $this->transactionCount = 0;
        $this->totalAmount = 0;

        // Define the start and end of the selected month
        $startOfMonth = Carbon::parse($currentMonth)->startOfMonth();
        $endOfMonth = Carbon::parse($currentMonth)->endOfMonth();

        // Loop through each day in the month
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            // Initialize daily totals
            $dailyGross = 0;
            $dailyTax = 0;

            // Fetch transactions for the current day
            $dailyTransactions = TransactionMovement::whereDate('created_at', $date)->get();
            $dailyTransactionCount = $dailyTransactions->count();
            $this->transactionCount += $dailyTransactionCount;

            // Process each transaction for the day
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

            // Calculate daily net
            $dailyNet = $dailyGross - $dailyTax;

            // Store the daily totals in monthlyTotal array
            $this->monthlyTotal[] = [
                'date' => $date->format('M d, Y'),
                'totalAmount' => $dailyGross,

            ];



            // Accumulate the total amount for the month
            $this->totalAmount += $dailyGross;
        }
        // Dispatch a single event after processing all days in the month
        $this->dispatch('monthlyTotalUpdated', $this->monthlyTotal);
    }

}
