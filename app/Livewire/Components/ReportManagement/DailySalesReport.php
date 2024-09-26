<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use App\Models\Transaction;
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
        $this->transactions = DB::table('transactions')
            ->leftJoin('returns', 'transactions.id', '=', 'returns.transaction_id')
            ->select(
                'transactions.created_at as date',
                'transactions.transaction_number',
                'returns.return_number',
                'transactions.total_amount as transaction_total_amount',
                'returns.return_total_amount as total_amount',
                'transactions.total_vat_amount' // Assuming this column exists in transactions
            )
            ->whereDate('transactions.created_at', $date) // Filter by date
            ->get();



        $totalGross = 0;
        $totalTax = 0;
        $totalNet = 0;

        foreach ($this->transactions as $transaction) {


            $totalGross += $transaction['total_amount'];
            $totalTax += $transaction['total_vat_amount'];

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
