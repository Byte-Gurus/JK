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
        // Parse the month into start and end dates
        $startOfMonth = Carbon::parse($month)->startOfMonth();
        $endOfMonth = Carbon::parse($month)->endOfMonth();

        // Fetch transactions within the month range
        $this->transactions = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();

        $totalGross = 0;
        $totalTax = 0;
        foreach ($this->transactions as $transaction) {
            $totalGross += $transaction->total_amount;
            $totalTax += $transaction->total_vat_amount;
        }

        // Prepare report information
        $this->transaction_info = [
            'totalGross' => $totalGross,
            'totalTax' => $totalTax,
            'date' => $startOfMonth->format('M d Y') . ' - ' . $endOfMonth->format('M d Y'),
            'dateCreated' => Carbon::now()->format('M d Y H:i:s A'),
            'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname
        ];
    }

}
