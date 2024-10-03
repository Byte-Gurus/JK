<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use App\Models\Returns;
use App\Models\Transaction;
use App\Models\TransactionMovement;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DailySalesReport extends Component
{
    public $showDailySalesReport = false;
    public $transactions = [], $transaction_info = [];
    public function render()
    {
        return view('livewire.components.ReportManagement.daily-sales-report', [
            'transactions' => $this->transactions
        ]);
    }

    protected $listeners = [
        'generate-report' => 'generateReport'
    ];

    public function generateReport($date)
    {

        $date = Carbon::parse($date);
        // Define the start and end of the day
        $startOfDay = $date->copy()->startOfDay();
        $endOfDay = $date->copy()->endOfDay();

        // Retrieve transactions within the date range
        $this->transactions = TransactionMovement::whereBetween('created_at', [$startOfDay, $endOfDay])->get();

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

        $vatable_subtotal = 0;
        $vatable_amount = 0;

        $non_vatable_subtotal = 0;
        $non_vatable_amount = 0;

        foreach ($this->transactions as $transaction) {
            $transaction->totalVoidItemAmount = 0; // Initialize void amount for the transaction
            $transaction->vatable_amount = 0;
            $transaction->non_vatable_amount = 0;
            $transaction->totalVoidTaxAmount = 0;

            if ($transaction->transaction_type == 'Sales') {
                $totalGross += $transaction->transactionJoin->total_amount;
                $totalTax += $transaction->transactionJoin->total_vat_amount;

                foreach ($transaction->transactionJoin->transactionDetailsJoin as $detail) {
                    if ($detail->status == 'Void') {
                        $transaction->totalVoidItemAmount += $detail->item_subtotal;

                        if ($detail->vat_type === 'Vatable') {
                            $vatable_subtotal += $detail->item_subtotal;
                            $vatable_amount = $vatable_subtotal - ($vatable_subtotal / (100 + $detail->vat_percent) * 100);
                            $transaction->vatable_amount += $vatable_amount;
                        } elseif ($detail->vat_type === 'Non Vatable') {
                            $non_vatable_subtotal += $detail->item_subtotal;
                            $non_vatable_amount = $non_vatable_subtotal - ($non_vatable_subtotal / (100 + $detail->vat_percent) * 100);
                            $transaction->non_vatable_amount += $non_vatable_amount;
                        }
                    }
                }
            } elseif ($transaction->transaction_type == 'Return') {
                $totalReturnAmount += $transaction->returnsJoin->return_total_amount;
                $totalReturnVatAmount += $transaction->returnsJoin->return_vat_amount;

                foreach ($transaction->returnsJoin->transactionJoin->transactionDetailsJoin as $detail) {
                    if ($detail->status == 'Void') {
                        $transaction->totalVoidItemAmount += $detail->item_subtotal;

                        if ($detail->vat_type === 'Vatable') {
                            $vatable_subtotal += $detail->item_subtotal;
                            $vatable_amount = $vatable_subtotal - ($vatable_subtotal / (100 + $detail->vat_percent) * 100);
                            $transaction->vatable_amount += $vatable_amount;
                        } elseif ($detail->vat_type === 'Non Vatable') {
                            $non_vatable_subtotal += $detail->item_subtotal;
                            $non_vatable_amount = $non_vatable_subtotal - ($non_vatable_subtotal / (100 + $detail->vat_percent) * 100);
                            $transaction->non_vatable_amount += $non_vatable_amount;
                        }
                    }
                }
            } elseif ($transaction->transaction_type == 'Credit') {
                $totalGross += $transaction->creditJoin->transactionJoin->total_amount;
                $totalTax += $transaction->creditJoin->transactionJoin->total_vat_amount;

                foreach ($transaction->creditJoin->transactionJoin->transactionDetailsJoin as $detail) {
                    if ($detail->status == 'Void') {
                        $transaction->totalVoidItemAmount += $detail->item_subtotal;

                        if ($detail->vat_type === 'Vatable') {
                            $vatable_subtotal += $detail->item_subtotal;
                            $vatable_amount = $vatable_subtotal - ($vatable_subtotal / (100 + $detail->vat_percent) * 100);
                            $transaction->vatable_amount += $vatable_amount;
                        } elseif ($detail->vat_type === 'Non Vatable') {
                            $non_vatable_subtotal += $detail->item_subtotal;
                            $non_vatable_amount = $non_vatable_subtotal - ($non_vatable_subtotal / (100 + $detail->vat_percent) * 100);
                            $transaction->non_vatable_amount += $non_vatable_amount;
                        }
                    }
                }
            } elseif ($transaction->transaction_type == 'Void') {
                $totalVoidAmount += $transaction->transactionJoin->total_amount;
                $totalVoidVatAmount += $transaction->transactionJoin->total_vat_amount;
            }

            $totalVoidItemAmount += $transaction->totalVoidItemAmount; // Accumulate void item amount
            $totalVoidTaxAmount += $transaction->vatable_amount + $transaction->non_vatable_amount; // Accumulate void tax amount
        }

        $totalGross -= $totalReturnAmount + $totalVoidAmount;
        $totalNet = $totalGross - ($totalTax - ($totalReturnVatAmount + $totalVoidVatAmount));


        $this->transaction_info = [

            'totalGross' => $totalGross,
            'totalTax' => $totalTax - $totalReturnVatAmount - $totalVoidVatAmount,
            'date' => $date->format('M d Y '),
            'totalNet' => $totalNet,
            'dateCreated' => Carbon::now()->format('M d Y h:i A'),
            'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname
        ];

    }
}
