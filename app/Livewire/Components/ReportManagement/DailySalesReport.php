<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use App\Models\Returns;
use App\Models\Transaction;
use App\Models\TransactionMovement;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $date = Carbon::parse($date);
        $startOfDay = $date->startOfDay();
        $endOfDay = $date->endOfDay();

        $this->transactions = TransactionMovement::all();

        // $returns = Returns::where('created_at', $date);
        dd($this->transactions);

        $totalGross = 0;
        $totalTax = 0;
        $totalNet = 0;

        foreach ($this->transactions as $transaction) {
            $totalGross += $transaction->transactionJoin->total_amount;
            $totalTax += $transaction->transactionJoin->total_vat_amount;
        }


        $totalNet = $totalGross - $totalTax;

        $this->transaction_info = [

            'totalGross' => $totalGross,
            'totalTax' => $totalTax,
            'date' => $date->format('M d Y '),
            'totalNet' => $totalNet,
            'dateCreated' => Carbon::now()->format('M d Y h:i A'),
            'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname
        ];

    }
}
