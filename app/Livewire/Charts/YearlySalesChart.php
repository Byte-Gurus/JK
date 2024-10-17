<?php

namespace App\Livewire\Charts;

use App\Models\Transaction;
use App\Models\TransactionMovement;
use Carbon\Carbon;
use Livewire\Component;

class YearlySalesChart extends Component
{

    public $fromYear, $toYear, $totalAmount, $transactionCount;
    public $yearlyTotal = [];

    public function render()
    {
        if (!$this->fromYear || !$this->toYear) {
            $currentYear = Carbon::now()->format('Y');
            $this->fromYear = $currentYear;
            $this->toYear = $currentYear;
            $this->updatedYearRange();
        }
        return view('livewire.charts.yearly-sales-chart');
    }

    public function updatedToYear($toYear)
    {
        // Check if both fromYear and toYear have values
        if ($this->fromYear && $this->toYear) {
            $this->updatedYearRange(); // Call the method to update the range
        }
    }

    public function updatedFromYear($fromYear)
    {
        // Check if both fromYear and toYear have values
        if ($this->fromYear && $this->toYear) {
            $this->updatedYearRange(); // Call the method to update the range
        }
    }
    public function updatedYearRange()
    {
        // Ensure that fromYear and toYear are defined
        if (!$this->fromYear || !$this->toYear) {
            $currentYear = Carbon::now()->format('Y');
            $this->fromYear = $currentYear;
            $this->toYear = $currentYear;
        }

        // Reset yearly totals
        $this->yearlyTotal = [];
        $this->totalAmount = 0;
        $this->transactionCount = 0;

        // Loop through each year in the range
        for ($year = $this->fromYear; $year <= $this->toYear; $year++) {
            $startOfYear = Carbon::createFromFormat('Y', $year)->startOfYear();
            $endOfYear = Carbon::createFromFormat('Y', $year)->endOfYear();

            // Fetch transactions for the year
            $transactions = TransactionMovement::whereBetween('created_at', [$startOfYear, $endOfYear])->get();
            $yearlyTransactionCount = TransactionMovement::whereBetween('created_at', [$startOfYear, $endOfYear])->count();

            // Initialize yearly totals
            $totalGross = 0;
            $totalTax = 0;
            $totalNet = 0;
            $totalReturnAmount = 0;
            $totalReturnVatAmount = 0;
            $totalVoidAmount = 0;
            $totalVoidVatAmount = 0;

            // Process transactions for the year
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

            // Calculate yearly net values
            $yearlyGross = $totalGross - ($totalReturnAmount + $totalVoidAmount);
            $yearlyTax = $totalTax - ($totalReturnVatAmount + $totalVoidVatAmount);
            $yearlyNet = $yearlyGross - $yearlyTax;

            // Add yearly summary to the array
            $this->yearlyTotal[] = [
                'year' => $year,
                'totalAmount' => $yearlyNet,
            ];

            // Add to the global transaction count and total amount
            $this->transactionCount += $yearlyTransactionCount;
            $this->totalAmount += $yearlyNet;
        }

        // Dispatch event for front-end updates
        $this->dispatch('yearlyTotalUpdated', $this->yearlyTotal);
    }
}
