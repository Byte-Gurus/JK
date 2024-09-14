<?php

namespace App\Livewire\Charts;

use App\Models\Transaction;
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


        if (!$this->Year) {
            $currentYear = Carbon::now()->format('Y');
        }

        $this->totalAmount = 0;
        $this->transactionCount = 0;
        $this->yearlyTotal = [];

        // Parse the current year
        $year = (int) $currentYear;

        // Get the start and end dates of the year
        $startDate = Carbon::createFromDate($year, 1, 1)->startOfYear();
        $endDate = Carbon::createFromDate($year, 12, 31)->endOfYear();

        // Loop through each month of the year
        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

            $totalAmount = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('total_amount');
            $dailyTransactionCount = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $formattedMonth = $startOfMonth->format('M Y');
            $this->yearlyTotal[] = [
                'date' => $formattedMonth,
                'totalAmount' => $totalAmount
            ];
            $this->totalAmount += $totalAmount;
            $this->transactionCount += $dailyTransactionCount;
        }

        $this->dispatch('yearlyTotalUpdated', $this->yearlyTotal);
        // Uncomment the line below to debug the yearly total
        // dd($this->yearlyTotal);
    }
}
