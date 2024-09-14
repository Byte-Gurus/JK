<?php

namespace App\Livewire\Charts;

use App\Models\Transaction;
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

        if (!$currentWeek) {
            $currentWeek = Carbon::now()->format('o-\WW');
        }
        $this->totalAmount = 0;
        $this->transactionCount = 0;
        $this->weeklyTotal = [];
        $year = substr($currentWeek, 0, 4);
        $weekNumber = substr($currentWeek, -2);

        // Get the start and end dates of the week
        $startDate = Carbon::now()->setISODate($year, $weekNumber)->startOfWeek();
        $endDate = Carbon::now()->setISODate($year, $weekNumber)->endOfWeek();

        // Initialize an array to hold the daily totals

        // Loop through each day of the week
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $totalAmount = Transaction::whereDate('created_at', $date->toDateString())
                ->sum('total_amount');
            $dailyTransactionCount = Transaction::whereDate('created_at', $date->toDateString())
                ->count();
            $formattedDate = $date->format('M d Y');
            $this->weeklyTotal[] = [
                'date' => $formattedDate,
                'totalAmount' => $totalAmount
            ];
            $this->totalAmount += $totalAmount;
            $this->transactionCount += $dailyTransactionCount;
        }


        $this->dispatch('weeklyTotalUpdated', $this->weeklyTotal);
    }
}
