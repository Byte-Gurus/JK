<?php

namespace App\Livewire\Charts;

use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;

class SaleChart extends Component
{
    public $dailyTotal;
    public $weeklyTotal;
    public $monthlyTotal;
    public $yearlyTotal;

    public function render()
    {
        $this->dailyTotal = Transaction::whereDate('created_at', Carbon::today())->sum('total_amount');

        // Sum of this week's transactions
        $this->weeklyTotal = Transaction::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('total_amount');

        // Sum of this month's transactions
        $this->monthlyTotal = Transaction::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_amount');

        // Sum of this year's transactions
        $this->yearlyTotal = Transaction::whereYear('created_at', Carbon::now()->year)
            ->sum('total_amount');

            
        return view(
            'livewire.charts.sale-chart',

        );
    }
}
