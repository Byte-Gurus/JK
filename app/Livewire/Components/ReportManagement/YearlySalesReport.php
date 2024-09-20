<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class YearlySalesReport extends Component
{
    public $transactions = [], $transaction_info = [];
    public function render()
    {
        return view('livewire.components.ReportManagement.yearly-sales-report', [
            'transactions' => $this->transactions
        ]);
    }

    protected $listeners = [
        'generate-report' => 'generateReport'
    ];

    public function generateReport($year)
    {
        // Parse the year into start and end dates
        $startOfYear = Carbon::parse($year . '-01-01')->startOfYear();
        $endOfYear = Carbon::parse($year . '-12-31')->endOfYear();

        // Fetch transactions within the year range
        $transactions = Transaction::whereBetween('created_at', [$startOfYear, $endOfYear])->get();

        // Initialize totals and monthly summaries
        $totalGross = 0;
        $totalTax = 0;
        $totalNet = 0;
        $monthlySummaries = [];

        // Iterate through transactions to group and sum by month
        foreach ($transactions as $transaction) {
            $month = $transaction->created_at->format('Y-m');

            if (!isset($monthlySummaries[$month])) {
                $monthlySummaries[$month] = [
                    'totalGross' => 0,
                    'totalTax' => 0,
                    'monthName' => Carbon::parse($month . '-01')->format('F'), // Get month name
                ];
            }

            $monthlySummaries[$month]['totalGross'] += $transaction->total_amount;
            $monthlySummaries[$month]['totalTax'] += $transaction->total_vat_amount;


            // Accumulate yearly totals
            $totalGross += $transaction->total_amount;
            $totalTax += $transaction->total_vat_amount;
            $totalNet = $totalGross - $totalTax;
        }

        // Prepare report information
        $this->transaction_info = [
            'totalGross' => $totalGross,
            'totalTax' => $totalTax,
            'totalNet' => $totalNet,
            'date' => $startOfYear->format('Y'),
            'dateCreated' => Carbon::now()->format('M d Y h:i:s A'),
            'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname,
            'monthlySummaries' => $monthlySummaries
        ];
    }
}
