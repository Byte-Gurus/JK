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
        $this->transactions = Transaction::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();

        // Initialize totals and daily summaries
        $totalGross = 0;
        $totalTax = 0;
        $totalNet = 0;
        $totalReturnAmount = 0;
        $totalReturnVatAmount = 0;
        $dailySummaries = [];

        // Iterate through transactions to group and sum by day
        foreach ($this->transactions as $transaction) {
            $date = $transaction->created_at->format('Y-m-d');

            if (!isset($dailySummaries[$date])) {
                $dailySummaries[$date] = [
                    'totalGross' => 0,
                    'totalTax' => 0,
                    'totalNet' => 0,
                    'totalReturnAmount' => 0,
                    'totalReturnVatAmount' => 0
                ];
            }

            if ($transaction->transaction_type == 'Sales') {
                $dailySummaries[$date]['totalGross'] += $transaction->transactionJoin->total_amount;
                $dailySummaries[$date]['totalTax'] += $transaction->transactionJoin->total_vat_amount;
            } elseif ($transaction->transaction_type == 'Return') {
                $dailySummaries[$date]['totalReturnAmount'] += $transaction->returnsJoin->return_total_amount;
                $dailySummaries[$date]['totalReturnVatAmount'] += $transaction->returnsJoin->return_vat_amount;
            } elseif ($transaction->transaction_type == 'Credit') {
                $dailySummaries[$date]['totalGross'] += $transaction->creditJoin->transactionJoin->total_amount;
                $dailySummaries[$date]['totalTax'] += $transaction->creditJoin->transactionJoin->total_vat_amount;
            }
        }

        // Calculate weekly totals
        foreach ($dailySummaries as $summary) {
            $totalGross += $summary['totalGross'];
            $totalTax += $summary['totalTax'];
            $totalReturnAmount += $summary['totalReturnAmount'];
            $totalReturnVatAmount += $summary['totalReturnVatAmount'];
        }

        // Adjust totals for returns
        $totalGross -= $totalReturnAmount;
        $totalTax -= $totalReturnVatAmount;
        $totalNet = $totalGross - $totalTax;

        // Prepare report information
        $this->transaction_info = [
            'totalGross' => $totalGross,
            'totalTax' => $totalTax,
            'totalNet' => $totalNet,
            'date' => $startOfWeek->format('M d Y') . ' - ' . $endOfWeek->format('M d Y'),
            'dateCreated' => Carbon::now()->format('M d Y h:i A'),
            'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname,
            'dailySummaries' => $dailySummaries
        ];
    }
}
