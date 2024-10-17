<?php

namespace App\Livewire\Charts;

use App\Models\TransactionMovement;
use Carbon\Carbon;
use Livewire\Component;

class WeeklySalesChart extends Component
{
    public $month, $totalAmount = 0, $transactionCount = 0;
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
        // Reset totals for recalculation
        $this->monthlyTotal = [];
        $this->totalAmount = 0;
        $this->transactionCount = 0;

        if (!$this->month) {
            $currentMonth = Carbon::now()->format('Y-m'); // Get current month in 'YYYY-MM' format
        }

        // Get the start and end of the month
        $startOfMonth = Carbon::parse($currentMonth . '-01')->startOfMonth();
        $endOfMonth = Carbon::parse($currentMonth . '-01')->endOfMonth();

        // Initialize totals for the entire month
        $totalGross = 0;
        $totalTax = 0;
        $totalNet = 0;

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

            // Get transactions within the current week
            $transactions = TransactionMovement::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
            $weeklyTransactionCount = $transactions->count();
            $this->transactionCount += $weeklyTransactionCount;

            // Initialize weekly totals
            $weeklyGross = 0;
            $weeklyTax = 0;
            $weeklyNet = 0;

            foreach ($transactions as $transaction) {
                switch ($transaction->transaction_type) {
                    case 'Sales':
                        $weeklyGross += $transaction->transactionJoin->total_amount;
                        $weeklyTax += $transaction->transactionJoin->total_vat_amount;
                        break;
                    case 'Return':
                        $weeklyGross -= $transaction->returnsJoin->return_total_amount;
                        $weeklyTax -= $transaction->returnsJoin->return_vat_amount;
                        break;
                    case 'Credit':
                        $weeklyGross += $transaction->creditJoin->transactionJoin->total_amount;
                        $weeklyTax += $transaction->creditJoin->transactionJoin->total_vat_amount;
                        break;
                    case 'Void':
                        $weeklyGross -= $transaction->voidTransactionJoin->void_total_amount;
                        $weeklyTax -= $transaction->voidTransactionJoin->void_vat_amount;
                        break;
                }
            }

            // Calculate net for the week
            $weeklyNet = $weeklyGross - $weeklyTax;

            // Store weekly totals in monthly summary

            $this->monthlyTotal[] = [
                'date' => $startOfWeek->format('M d Y') . ' - ' . $endOfWeek->format('M d Y'),
                'totalAmount' => $weeklyNet
            ];
            // Add to monthly totals
            $totalGross += $weeklyGross;
            $totalTax += $weeklyTax;
            $totalNet += $weeklyNet;

            // Move to the next week
            $currentWeek->addWeek();
        }

        // Set the total amount for the entire month
        $this->totalAmount = $totalNet;

        // Dispatch event with updated monthly totals
        $this->dispatch('monthlyTotalUpdated', $this->monthlyTotal);
    }
}
