<?php

namespace App\Livewire\Charts;

use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;

class DailySalesChart extends Component
{
    public $day, $totalAmount, $transactionCount;
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


        if (!$this->day) {
            $currentDate = Carbon::now();
        }


        $this->dailyTotal = [];

        $currentDate = Carbon::parse($currentDate);

        $this->currentDate = $currentDate->toDateString(); // Get today's date in 'YYYY-MM-DD' format
        $formattedDate = $currentDate->format('M d Y');

        $this->totalAmount = Transaction::whereDate('created_at', $currentDate)
            ->whereNotIn('transaction_type', ['Return', 'Void'])
            ->sum('total_amount');

        $this->transactionCount = Transaction::whereDate('created_at', $currentDate)
            ->whereNotIn('transaction_type', ['Return', 'Void'])
            ->count();


        $this->dailyTotal[] = [
            'date' => $formattedDate,
            'totalAmount' => $this->totalAmount
        ];

        $this->dispatch('DailyTotalUpdated', $this->dailyTotal);
    }
}
