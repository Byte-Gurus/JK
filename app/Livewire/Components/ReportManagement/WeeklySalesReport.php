<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WeeklySalesReport extends Component
{
    public $showWeeklySalesReport = false;
    public $transactions = [], $transaction_info = [];

    public function render()
    {
        return view('livewire.components.ReportManagement.weekly-sales-report', [
            'transactions' => $this->transactions
        ]);
    }

    protected $listeners = [
        'generate-report' => 'generateReport'
    ];

    public function generateReport($week)
    {
        // Parse the week into start and end dates
        $startOfWeek = Carbon::parse($week)->startOfWeek();
        $endOfWeek = Carbon::parse($week)->endOfWeek();

        // Fetch transactions within the week range
        $transactions = Transaction::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();

        // Initialize totals and daily summaries
        $totalGross = 0;
        $totalTax = 0;
        $dailySummaries = [];

        // Iterate through transactions to group and sum by day
        foreach ($transactions as $transaction) {
            $date = $transaction->created_at->format('Y-m-d');

            if (!isset($dailySummaries[$date])) {
                $dailySummaries[$date] = [
                    'totalGross' => 0,
                    'totalTax' => 0,
                ];
            }

            $dailySummaries[$date]['totalGross'] += $transaction->total_amount;
            $dailySummaries[$date]['totalTax'] += $transaction->total_vat_amount;

            // Accumulate weekly totals
            $totalGross += $transaction->total_amount;
            $totalTax += $transaction->total_vat_amount;
        }

        // Prepare report information
        $this->transaction_info = [
            'totalGross' => $totalGross,
            'totalTax' => $totalTax,
            'date' => $startOfWeek->format('M d Y') . ' - ' . $endOfWeek->format('M d Y'),
            'dateCreated' => Carbon::now()->format('M d Y H:i:s A'),
            'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname,
            'dailySummaries' => $dailySummaries
        ];
    }
}
