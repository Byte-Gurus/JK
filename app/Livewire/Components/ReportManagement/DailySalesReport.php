<?php

namespace App\Livewire\Components\ReportManagement;


use App\Models\TransactionMovement;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Response;
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


        foreach ($this->transactions as $transaction) {
            $transaction->totalVoidItemAmount = 0;
            $transaction->vatable_amount = 0;
            $transaction->vat_exempt_amount = 0;
            $transaction->VoidTaxAmount = 0;
            $transaction->totalVoidTaxAmount = 0;


            switch ($transaction->transaction_type) {
                case 'Sales':
                    $totalGross += $transaction->transactionJoin->total_amount;
                    $totalTax += $transaction->transactionJoin->total_vat_amount;

                    foreach ($transaction->transactionJoin->transactionDetailsJoin as $detail) {

                        $transaction->VoidTaxAmount = $this->calculateVoidAmounts($detail, $transaction);
                    }
                    break;
                case 'Return':
                    $totalReturnAmount += $transaction->returnsJoin->return_total_amount;
                    $totalReturnVatAmount += $transaction->returnsJoin->return_vat_amount;

                    foreach ($transaction->returnsJoin->transactionJoin->transactionDetailsJoin as $detail) {


                        $transaction->VoidTaxAmount = $this->calculateVoidAmounts($detail, $transaction);
                    }
                    break;
                case 'Credit':
                    $totalGross += $transaction->creditJoin->transactionJoin->total_amount;
                    $totalTax += $transaction->creditJoin->transactionJoin->total_vat_amount;

                    foreach ($transaction->creditJoin->transactionJoin->transactionDetailsJoin as $detail) {


                        $transaction->VoidTaxAmount = $this->calculateVoidAmounts($detail, $transaction);
                    }
                    break;
                case 'Void':
                    $totalVoidAmount += $transaction->transactionJoin->total_amount;
                    $totalVoidVatAmount += $transaction->transactionJoin->total_vat_amount;

                    foreach ($transaction->transactionJoin->transactionDetailsJoin as $detail) {

                        $transaction->VoidTaxAmount = $this->calculateVoidAmounts($detail, $transaction);
                    }
                    break;
            }



            $totalVoidItemAmount += $transaction->totalVoidItemAmount;
            $totalVoidTaxAmount += $transaction->vatable_amount + $transaction->vat_exempt_amount;

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

        // $data = [
        //     'title' => 'DailySalesReport',
        //     'date'=> Carbon::now()->format('M d Y h:i A')
        // ];

        // $pdf = Pdf::loadView('livewire.components.ReportManagement.daily-sales-report', $data)->output();

        // return response()->streamDownload(function () use($pdf) {
        //     echo  $pdf->download();
        // }, 'report.pdf');
    }
    public function download()
    {
        dd('sa');
        $data = [
            'title' => 'Sample PDF',
            'date' => date('m/d/Y')
        ];

        $pdf = Pdf::loadView('livewire.components.ReportManagement.daily-sales-report', $data);

        return Response::make($pdf->stream('sample.pdf'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="sample.pdf"',
        ]);
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
                $transaction->vat_exempte_amount += $vat_exempt_amount;
            }

            return $transaction->vatable_amount + $transaction->vat_exempt_amount;


        }
    }


}
