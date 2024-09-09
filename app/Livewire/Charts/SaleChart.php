<?php

namespace App\Livewire\Charts;

use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;

class SaleChart extends Component
{
    public $day, $week, $month, $year;
    public $selectPicker;
    public $dailyTotal = 0;
    public $weeklyTotal = 0;
    public $monthlyTotal = 0;
    public $yearlyTotal = 0;

    public function render()
    {
        if ($this->selectPicker == 1 && $this->day) {
            $this->dailyTotal = Transaction::whereDate('created_at', $this->day)
                ->sum('total_amount');
        }

        if ($this->selectPicker == 2 && $this->week) {
            $weekStart = Carbon::parse($this->week)->startOfWeek()->toDateString();
            $weekEnd = Carbon::parse($this->week)->endOfWeek()->toDateString();
            $this->weeklyTotal = Transaction::whereBetween('created_at', [$weekStart, $weekEnd])
                ->sum('total_amount');
        }

        if ($this->selectPicker == 3 && $this->month) {
            $this->monthlyTotal = Transaction::whereMonth('created_at', Carbon::parse($this->month)->month)
                ->whereYear('created_at', Carbon::parse($this->month)->year)
                ->sum('total_amount');
        }

        if ($this->selectPicker == 4 && $this->year) {
            $this->yearlyTotal = Transaction::whereYear('created_at', $this->year)
                ->sum('total_amount');
        }

        return view('livewire.charts.sale-chart');
    }

    public function updatedSelectPicker($picker)
    {
        $this->selectPicker = $picker;
    }
}
