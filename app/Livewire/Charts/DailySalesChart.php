<?php

namespace App\Livewire\Charts;

use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;

class DailySalesChart extends Component
{
    public $day;
    public $dailyTotal = [];
    public $currentDate;
    public function render()
    {
        if (!$this->day) {
            $currentDate = Carbon::now();
            $this->updatedDay($currentDate);
        }


        return view('livewire.charts.daily-sales-chart');
    }


    public function updatedDay($currentDate)
    {
        $this->dailyTotal = [];


        $currentDate = Carbon::parse($currentDate);

        $this->currentDate = $currentDate->toDateString(); // Get today's date in 'YYYY-MM-DD' format
        $formattedDate = $currentDate->format('M d Y');

        $totalAmount = Transaction::whereDate('created_at', $this->currentDate)->sum('total_amount');


        $this->dailyTotal[] = [
            'date' => $formattedDate,
            'totalAmount' => $totalAmount
        ];

        $this->dispatch('DailyTotalUpdated', $this->dailyTotal);
    }
}
