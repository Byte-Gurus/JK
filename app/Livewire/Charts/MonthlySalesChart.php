<?php

namespace App\Livewire\Charts;

use App\Models\Transaction;
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
        $this->totalAmount = 0;
        $this->transactionCount = 0;
        $this->monthlyTotal = [];

        // Parse the current month (assumed format 'YYYY-MM')
        $year = substr($currentMonth, 0, 4);
        $month = substr($currentMonth, 5, 2);

        // Get the start and end dates of the month
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // Loop through each day of the month
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $totalAmount = Transaction::whereDate('created_at', $date->toDateString())->sum('total_amount');
            $dailyTransactionCount = Transaction::whereDate('created_at', $date->toDateString())
                ->count();
            $formattedDate = $date->format('M d Y');
            $this->monthlyTotal[] = [
                'date' => $formattedDate,
                'totalAmount' => $totalAmount
            ];
            $this->totalAmount += $totalAmount;
            $this->transactionCount += $dailyTransactionCount;
        }

        $this->dispatch('monthlyTotalUpdated', $this->monthlyTotal);
    }
}
