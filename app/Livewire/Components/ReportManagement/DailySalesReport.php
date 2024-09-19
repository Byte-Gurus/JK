<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use App\Models\Transaction;
use Livewire\Component;

class DailySalesReport extends Component
{
    public $showDailySalesReport = false;
    public $transactions = [], $transaction_info = [];
    public function render()
    {
        return view('livewire.components.ReportManagement.daily-sales-report', [
            'transactions' => $this->transactions
        ]);
    }

    protected $listeners = [
        'generate-report' => 'generateReport'
    ];

    public function generateReport($date)
    {

        $this->transactions = Transaction::whereDate('created_at', $date)->get();

        $totalGross = 0;
        foreach($this->transactions as $transaction){
            $totalGross += $transaction['total_amount'];
        }

        $this->transaction_info = [

            'totalGross' => $totalGross,
        ];

    }
}
