<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use App\Models\Transaction;
use Livewire\Component;

class DailySalesReport extends Component
{
    public $showDailySalesReport = false;
    public $Transactions;
    public function render()
    {
        return view('livewire.components.ReportManagement.daily-sales-report', [
            'Transactions' => $this->Transactions
        ]);
    }

    protected $listeners = [
        'generate-report' => 'generateReport'
    ];

    public function generateReport($date)
    {


        $$this->Transactions = Transaction::whereDate('created_at', $date)->get();
    }
}
