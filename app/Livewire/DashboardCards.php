<?php

namespace App\Livewire;

use App\Models\Delivery;
use App\Models\Inventory;
use App\Models\ReturnDetails;
use App\Models\Transaction;
use App\Models\TransactionMovement;
use Livewire\Component;

class DashboardCards extends Component
{
    public $overallSales, $overallStocks, $overallReturn, $deliveryInProgress;
    public function render()
    {
        $transactions = TransactionMovement::all();
        $totalGross = 0;
        $totalTax = 0;
        $totalNet = 0;

        $totalReturnAmount = 0;
        $totalReturnVatAmount = 0;
        $totalVoidAmount = 0;
        $totalVoidVatAmount = 0;

        foreach ($transactions as $transaction) {
            // Initialize properties
            $transaction->totalVoidItemAmount = 0;
            $transaction->vatable_amount = 0;
            $transaction->vat_exempt_amount = 0;
            $transaction->VoidTaxAmount = 0;
            $transaction->totalVoidTaxAmount = 0;

            switch ($transaction->transaction_type) {
                case 'Sales':
                    $totalGross += $transaction->transactionJoin->total_amount;
                    $totalTax += $transaction->transactionJoin->total_vat_amount;
                    break;
                case 'Return':
                    $totalReturnAmount += $transaction->returnsJoin->return_total_amount;
                    $totalReturnVatAmount += $transaction->returnsJoin->return_vat_amount;
                    break;
                case 'Credit':
                    $totalGross += $transaction->creditJoin->transactionJoin->total_amount;
                    $totalTax += $transaction->creditJoin->transactionJoin->total_vat_amount;
                    break;
                case 'Void':
                    $totalVoidAmount += $transaction->voidTransactionJoin->void_total_amount;
                    $totalVoidVatAmount += $transaction->voidTransactionJoin->void_vat_amount;
                    break;
            }
        }

        $totalGross -= $totalReturnAmount + $totalVoidAmount;
        $totalNet = $totalGross - ($totalTax - ($totalReturnVatAmount + $totalVoidVatAmount));

        $this->overallSales = $totalNet;
        $this->overallStocks = Inventory::where('status', 'Available')->sum('current_stock_quantity');
        $this->overallReturn = ReturnDetails::sum('return_quantity');
        $this->deliveryInProgress = Delivery::where('status', 'In Progress')->count();


        return view('livewire.dashboard-cards');
    }
}
