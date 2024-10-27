<?php

namespace App\Livewire\Charts;

use App\Models\Transaction;
use App\Models\TransactionMovement;
use Carbon\Carbon;
use Livewire\Component;

class YearlySalesChart extends Component
{

    public $year, $totalAmount, $transactionCount;
    public $yearlyTotal = [];

    public function render()
    {
        if (!$this->year) {
            $currentYear = Carbon::now()->format('Y');
            $this->updatedYear();
        }
        return view('livewire.charts.yearly-sales-chart');
    }

    public function updatedYear()
    {
        if (!$this->year) {
            $this->year = Carbon::now()->year;
        }

        $this->yearlyTotal = [];
        $this->totalAmount = 0;
        $this->transactionCount = 0;

        // Loop through each month of the selected year
        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = Carbon::create($this->year, $month, 1)->startOfMonth();
            $endOfMonth = Carbon::create($this->year, $month, 1)->endOfMonth();

            // Fetch transactions for the month
            $transactions = TransactionMovement::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
            $monthlyTransactionCount = TransactionMovement::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

            // Initialize monthly totals
            $totalGross = 0;
            $totalTax = 0;
            $totalReturnAmount = 0;
            $totalReturnVatAmount = 0;
            $totalVoidAmount = 0;
            $totalVoidVatAmount = 0;

            // Process transactions for the month
            foreach ($transactions as $transaction) {
                if ($transaction->transaction_type == 'Sales') {
                    $totalGross += $transaction->transactionJoin->total_amount;
                    $totalTax += $transaction->transactionJoin->total_vat_amount;
                } elseif ($transaction->transaction_type == 'Return') {
                    $totalReturnAmount += $transaction->returnsJoin->return_total_amount;
                    $totalReturnVatAmount += $transaction->returnsJoin->return_vat_amount;
                } elseif ($transaction->transaction_type == 'Credit') {
                    $totalGross += $transaction->creditJoin->transactionJoin->total_amount;
                    $totalTax += $transaction->creditJoin->transactionJoin->total_vat_amount;
                } elseif ($transaction->transaction_type == 'Void') {
                    $totalVoidAmount += $transaction->voidTransactionJoin->void_total_amount;
                    $totalVoidVatAmount += $transaction->voidTransactionJoin->void_vat_amount;
                }
            }

            // Calculate monthly net values
            $monthlyGross = $totalGross - ($totalReturnAmount + $totalVoidAmount);
            $monthlyTax = $totalTax - ($totalReturnVatAmount + $totalVoidVatAmount);
            $monthlyNet = $monthlyGross - $monthlyTax;

            // Add monthly summary to the array
            $this->yearlyTotal[] = [
                'date' => $startOfMonth->format('F'),
                'totalAmount' => $monthlyGross,
            ];

            // Add to the global transaction count and total amount
            $this->transactionCount += $monthlyTransactionCount;
            $this->totalAmount += $monthlyGross;
        }

        // Dispatch event for front-end updates
        $this->dispatch('yearlyTotalUpdated', $this->yearlyTotal);

    }
}
