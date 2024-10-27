<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Transaction;
use App\Models\TransactionMovement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WeeklySalesReport extends Component
{
    public $showWeeklySalesReport = false;
    public $hasTransactions = false;

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
        $startOfWeek = Carbon::parse($week)->startOfWeek();
        $endOfWeek = Carbon::parse($week)->endOfWeek();

        $dailySummaries = [];
        $weeklyGross = 0;
        $weeklyTax = 0;
        $weeklyDiscount = 0;
        $weeklyNet = 0;

        $this->hasTransactions = false;

        // Loop through each day of the week
        for ($date = $startOfWeek->copy(); $date->lte($endOfWeek); $date->addDay()) {
            $dailyGross = $dailyDiscount = $dailyTax = $dailyNet = 0;
            $dailyReturnAmount = $dailyReturnVatAmount = $dailyVoidAmount = $dailyVoidVatAmount = 0;

            // Fetch transactions for the specific day
            $dayTransactions = TransactionMovement::whereDate('created_at', $date)->get();

            // Check if there are any transactions for the day
            if ($dayTransactions->isNotEmpty()) {
                $this->hasTransactions = true;

                foreach ($dayTransactions as $transaction) {
                    switch ($transaction->transaction_type) {
                        case 'Sales':
                            $dailyGross += $transaction->transactionJoin->subtotal;
                            $dailyTax += $transaction->transactionJoin->total_vat_amount;
                            $dailyDiscount += $transaction->transactionJoin->total_discount_amount;
                            break;
                        case 'Return':
                            $dailyReturnAmount += $transaction->returnsJoin->return_total_amount;
                            $dailyReturnVatAmount += $transaction->returnsJoin->return_vat_amount;
                            break;
                        case 'Credit':
                            $dailyGross += $transaction->creditJoin->transactionJoin->subtotal;
                            $dailyTax += $transaction->creditJoin->transactionJoin->total_vat_amount;
                            $dailyDiscount += $transaction->creditJoin->transactionJoin->total_discount_amount;
                            break;
                        case 'Void':
                            $dailyVoidAmount += $transaction->voidTransactionJoin->void_total_amount;
                            $dailyVoidVatAmount += $transaction->voidTransactionJoin->void_vat_amount;
                            break;
                    }
                }

                // Calculate daily net amount
                $dailyGross -= $dailyReturnAmount + $dailyVoidAmount;
                $dailyNet = $dailyGross - ($dailyTax + $dailyReturnVatAmount + $dailyVoidVatAmount + $dailyDiscount);


                // Add daily summary to array
                $dailySummaries[] = [
                    'date' => $date->format('M d, Y'),
                    'totalGross' => $dailyGross,
                    'totalTax' => $dailyTax - $dailyReturnVatAmount - $dailyVoidVatAmount,
                    'totalNet' => $dailyNet,
                    'totalDiscount' => $dailyDiscount,

                ];

                $weeklyGross += $dailyGross;
                $weeklyTax += $dailyTax;
                $weeklyDiscount += $dailyDiscount;
                $weeklyNet += $dailyNet;
            }
        }


        // Prepare the final report information
        $this->transaction_info = [
            'date' => $startOfWeek->format('M d, Y') . ' - ' . $endOfWeek->format('M d, Y'),
            'totalTax' => $weeklyTax,
            'totalGross' => $weeklyGross,
            'totalNet' => $weeklyNet,
            'totalDiscount' => $weeklyDiscount,
            'dailySummaries' => $dailySummaries,
            'dateCreated' => Carbon::now()->format('M d, Y h:i A'),
            'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname
        ];
    }





}
