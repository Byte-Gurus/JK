<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MonthlySalesReport extends Component
{
    public $transactions = [], $transaction_info = [];
    public function render()
    {
        return view('livewire.components.ReportManagement.monthly-sales-report', [
            'transactions' => $this->transactions
        ]);
    }
    protected $listeners = [
        'generate-report' => 'generateReport'
    ];

    public function generateReport($month)
    {
        $startOfMonth = Carbon::parse($month)->startOfMonth();
        $endOfMonth = Carbon::parse($month)->endOfMonth();

        $this->transactions = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();

        $totalGross = 0;
        $totalTax = 0;

        $dailySummaries = [];

        foreach ($this->transactions as $transaction) {
            $totalGross += $transaction->total_amount;
            $totalTax += $transaction->total_vat_amount;

            $date = $transaction->created_at->format('Y-m-d');
            if (!isset($dailySummaries[$date])) {
                $dailySummaries[$date] = [
                    'totalGross' => 0,
                    'totalTax' => 0,
                ];
            }

            $dailySummaries[$date]['totalGross'] += $transaction->total_amount;
            $dailySummaries[$date]['totalTax'] += $transaction->total_vat_amount;

        }

        $this->transaction_info = [
            'totalGross' => $totalGross,
            'totalTax' => $totalTax,

            'date' => $startOfMonth->format('M d Y') . ' - ' . $endOfMonth->format('M d Y'),
            'dateCreated' => Carbon::now()->format('M d Y h:i A'),
            'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname,
            'dailySummaries' => $dailySummaries,
        ];
    }


}
