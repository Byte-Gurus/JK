<?php

namespace App\Livewire\Charts;

use App\Models\Transaction;
use App\Models\TransactionMovement;
use Carbon\Carbon;
use Livewire\Component;

class DailySalesChart extends Component
{
    public $day, $totalAmount, $transactionCount;
    public $dailyTotal = [];
    public $currentDate;
    public function render()
    {
        if (!$this->day) {
            $currentDate = Carbon::now();
            $this->updatedDay($currentDate);
        }


        return view('livewire.charts.daily-sales-chart');
    }


    public function updatedDay($currentDate)
    {


        if (!$this->day) {
            $currentDate = Carbon::now();
        }


        $this->dailyTotal = [];

        $currentDate = Carbon::parse($currentDate);

        $this->currentDate = $currentDate->toDateString(); // Get today's date in 'YYYY-MM-DD' format
        $formattedDate = $currentDate->format('M d Y');

        $date = Carbon::parse($currentDate);
        // Define the start and end of the day
        $startOfDay = $date->copy()->startOfDay();
        $endOfDay = $date->copy()->endOfDay();

        // Retrieve transactions within the date range
        $transactions = TransactionMovement::whereBetween('created_at', [$startOfDay, $endOfDay])->get();

        // $returns = Returns::where('created_at', $date);

        $totalGross = 0;
        $totalTax = 0;
        $totalNet = 0;

        $totalReturnAmount = 0;
        $totalReturnVatAmount = 0;
        $totalVoidAmount = 0;
        $totalVoidVatAmount = 0;

        $totalVoidItemAmount = 0;
        $totalVoidTaxAmount = 0;


        foreach ($transactions as $transaction) {
            $transaction->totalVoidItemAmount = 0;
            $transaction->vatable_amount = 0;
            $transaction->vat_exempt_amount = 0;
            $transaction->VoidTaxAmount = 0;
            $transaction->totalVoidTaxAmount = 0;


            switch ($transaction->transaction_type) {
                case 'Sales':
                    $totalGross += $transaction->transactionJoin->subtotal;
                    $totalTax += $transaction->transactionJoin->total_vat_amount;

                    // foreach ($transaction->transactionJoin->transactionDetailsJoin as $detail) {

                    //     $transaction->VoidTaxAmount = $this->calculateVoidAmounts($detail, $transaction);
                    // }
                    break;
                case 'Return':
                    $totalReturnAmount += $transaction->returnsJoin->return_total_amount;
                    $totalReturnVatAmount += $transaction->returnsJoin->return_vat_amount;

                    // foreach ($transaction->returnsJoin->transactionJoin->transactionDetailsJoin as $detail) {


                    //     $transaction->VoidTaxAmount = $this->calculateVoidAmounts($detail, $transaction);
                    // }
                    break;
                case 'Credit':
                    $totalGross += $transaction->creditJoin->transactionJoin->subtotal;
                    $totalTax += $transaction->creditJoin->transactionJoin->total_vat_amount;

                    // foreach ($transaction->creditJoin->transactionJoin->transactionDetailsJoin as $detail) {


                    //     $transaction->VoidTaxAmount = $this->calculateVoidAmounts($detail, $transaction);
                    // }
                    break;
                case 'Void':
                    $totalVoidAmount += $transaction->voidTransactionJoin->void_total_amount;
                    $totalVoidVatAmount += $transaction->voidTransactionJoin->void_vat_amount;

                    // foreach ($transaction->transactionJoin->transactionDetailsJoin as $detail) {

                    //     $transaction->VoidTaxAmount = $this->calculateVoidAmounts($detail, $transaction);
                    // }
                    break;
            }


        }

        $totalGross -= $totalReturnAmount + $totalVoidAmount;
        $totalNet = $totalGross - ($totalTax - ($totalReturnVatAmount + $totalVoidVatAmount));

        $this->transactionCount = TransactionMovement::whereDate('created_at', $currentDate)
            ->count();


        $this->dailyTotal[] = [
            'date' => $formattedDate,
            'totalAmount' => $totalGross
        ];
        $this->totalAmount = $totalGross;

        $this->dispatch('DailyTotalUpdated', $this->dailyTotal);
    }
}
