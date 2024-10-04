<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Transaction;
use App\Models\TransactionMovement;
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
        $this->transactions = TransactionMovement::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();

        // Initialize totals and daily summaries
        $dailySummaries = [];
        $totalGross = 0;
        $totalTax = 0;
        $totalNet = 0;
        $totalReturnAmount = 0;
        $totalReturnVatAmount = 0;
        $totalVoidAmount = 0;
        $totalVoidVatAmount = 0;
        $totalVoidItemAmount = 0;
        $totalVoidTaxAmount = 0;

        // Iterate through transactions to group and sum by day
        foreach ($this->transactions as $transaction) {
            $date = $transaction->created_at->format('Y-m-d');

            if (!isset($dailySummaries[$date])) {
                $dailySummaries[$date] = [
                    'totalGross' => 0,
                    'totalTax' => 0,
                    'totalNet' => 0,
                    'totalReturnAmount' => 0,
                    'totalReturnVatAmount' => 0,
                    'totalVoidAmount' => 0,
                    'totalVoidVatAmount' => 0,
                    'totalVoidItemAmount' => 0,
                    'totalVoidTaxAmount' => 0,
                ];
            }

            // Summing daily transactions
            switch ($transaction->transaction_type) {
                case 'Sales':
                    $dailySummaries[$date]['totalGross'] += $transaction->transactionJoin->total_amount;
                    $dailySummaries[$date]['totalTax'] += $transaction->transactionJoin->total_vat_amount;

                    foreach ($transaction->transactionJoin->transactionDetailsJoin as $detail) {
                        $transaction->VoidTaxAmount = $this->calculateVoidAmounts($detail, $transaction);
                    }
                    break;
                case 'Return':
                    $dailySummaries[$date]['totalReturnAmount'] += $transaction->returnsJoin->return_total_amount;
                    $dailySummaries[$date]['totalReturnVatAmount'] += $transaction->returnsJoin->return_vat_amount;

                    foreach ($transaction->returnsJoin->transactionJoin->transactionDetailsJoin as $detail) {
                        $transaction->VoidTaxAmount = $this->calculateVoidAmounts($detail, $transaction);
                    }
                    break;
                case 'Credit':
                    $dailySummaries[$date]['totalGross'] += $transaction->creditJoin->transactionJoin->total_amount;
                    $dailySummaries[$date]['totalTax'] += $transaction->creditJoin->transactionJoin->total_vat_amount;

                    foreach ($transaction->creditJoin->transactionJoin->transactionDetailsJoin as $detail) {
                        $transaction->VoidTaxAmount = $this->calculateVoidAmounts($detail, $transaction);
                    }
                    break;
                case 'Void':
                    $dailySummaries[$date]['totalVoidAmount'] += $transaction->transactionJoin->total_amount;
                    $dailySummaries[$date]['totalVoidVatAmount'] += $transaction->transactionJoin->total_vat_amount;

                    foreach ($transaction->transactionJoin->transactionDetailsJoin as $detail) {
                        $transaction->VoidTaxAmount = $this->calculateVoidAmounts($detail, $transaction);
                    }
                    break;
            }

            $dailySummaries[$date]['totalVoidItemAmount'] += $transaction->totalVoidItemAmount;
            $dailySummaries[$date]['totalVoidTaxAmount'] += $transaction->vatable_amount + $transaction->vat_exempt_amount;
        }

        // Calculate daily net values and accumulate monthly totals
        foreach ($dailySummaries as $date => $summary) {
            $dailyGross = $summary['totalGross'] - $summary['totalReturnAmount'] - $summary['totalVoidAmount'];
            $dailyTax = $summary['totalTax'] - $summary['totalReturnVatAmount'] - $summary['totalVoidVatAmount'];
            $dailyNet = $dailyGross - $dailyTax;

            $dailySummaries[$date]['totalGross'] = $dailyGross;
            $dailySummaries[$date]['totalTax'] = $dailyTax;
            $dailySummaries[$date]['totalNet'] = $dailyNet;

            // Accumulate monthly totals
            $totalGross += $dailyGross;
            $totalTax += $dailyTax;
            $totalNet += $dailyNet;
            $totalReturnAmount += $summary['totalReturnAmount'];
            $totalReturnVatAmount += $summary['totalReturnVatAmount'];
            $totalVoidAmount += $summary['totalVoidAmount'];
            $totalVoidVatAmount += $summary['totalVoidVatAmount'];
            $totalVoidItemAmount += $summary['totalVoidItemAmount'];
            $totalVoidTaxAmount += $summary['totalVoidTaxAmount'];
        }

        // Prepare report information
        $this->transaction_info = [
            'totalGross' => $totalGross,
            'totalTax' => $totalTax,
            'totalNet' => $totalNet,
            'totalReturnAmount' => $totalReturnAmount,
            'totalReturnVatAmount' => $totalReturnVatAmount,
            'totalVoidAmount' => $totalVoidAmount ,
            'totalVoidVatAmount' => $totalVoidVatAmount,
            'totalVoidItemAmount' => $totalVoidItemAmount,
            'totalVoidTaxAmount' => $totalVoidTaxAmount,
            'date' => $startOfMonth->format('M d Y') . ' - ' . $endOfMonth->format('M d Y'),
            'dateCreated' => Carbon::now()->format('M d Y h:i A'),
            'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname,
            'dailySummaries' => $dailySummaries,
        ];
    }

    function calculateVoidAmounts($detail, &$transaction)
    {
        if ($detail->status == 'Void') {
            $transaction->totalVoidItemAmount += $detail->item_subtotal;
            if ($detail->vat_type === 'Vat') {
                $vatable_subtotal = $detail->item_subtotal;
                $vatable_amount = $vatable_subtotal - ($vatable_subtotal / (100 + $detail->item_vat_percent) * 100);
                $transaction->vatable_amount += $vatable_amount;
            } elseif ($detail->vat_type === 'Vat Exempt') {
                $vat_exempt_subtotal = $detail->item_subtotal;
                $vat_exempt_amount = $vat_exempt_subtotal - ($vat_exempt_subtotal / (100 + $detail->item_vat_percent) * 100);
                $transaction->vat_exempt_amount += $vat_exempt_amount;
            }
            return $transaction->vatable_amount + $transaction->vat_exempt_amount;
        }
    }



}
