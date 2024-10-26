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
    public $hasTransactions = false;

    public $transactions = [], $transaction_info = [];

    public function render()
    {
        return view('livewire.components.ReportManagement.daily-sales-report', [
            'transactions' => $this->transactions
        ]);
    }

    protected $listeners = [
        'generate-report' => 'generateReport',
    ];

    public function generateReport($date)
    {
        $date = Carbon::parse($date);
        // Define the start and end of the day
        $startOfDay = $date->copy()->startOfDay();
        $endOfDay = $date->copy()->endOfDay();

        // Retrieve transactions within the date range
        $this->transactions = TransactionMovement::whereBetween('created_at', [$startOfDay, $endOfDay])->get();

        // Check if transactions are empty and set the hasTransactions flag
        $this->hasTransactions = !$this->transactions->isEmpty();

        $totalGross = 0;
        $totalDiscount = 0;
        $totalTax = 0;
        $totalNet = 0;

        $totalReturnAmount = 0;
        $totalReturnVatAmount = 0;
        $totalVoidAmount = 0;
        $totalVoidVatAmount = 0;

        foreach ($this->transactions as $transaction) {


            switch ($transaction->transaction_type) {
                case 'Sales':
                    $totalGross += $transaction->transactionJoin->subtotal;
                    $totalTax += $transaction->transactionJoin->total_vat_amount;
                    $totalDiscount +=  $transaction->transactionJoin->total_discount_amount;
                    break;
                case 'Return':
                    $totalReturnAmount += $transaction->returnsJoin->return_total_amount;
                    $totalReturnVatAmount += $transaction->returnsJoin->return_vat_amount;
                    break;
                case 'Credit':
                    $totalGross += $transaction->creditJoin->transactionJoin->subtotal;
                    $totalTax += $transaction->creditJoin->transactionJoin->total_vat_amount;
                    $totalDiscount +=  $transaction->creditJoin->transactionJoin->total_discount_amount;

                    break;
                case 'Void':
                    $totalVoidAmount += $transaction->voidTransactionJoin->void_total_amount;
                    $totalVoidVatAmount += $transaction->voidTransactionJoin->void_vat_amount;
                    break;
            }
        }

        $totalGross -= $totalReturnAmount + $totalVoidAmount;
        $totalNet = $totalGross - ($totalTax + $totalReturnVatAmount + $totalVoidVatAmount + $totalDiscount);

        $this->transaction_info = [
            'totalGross' => $totalGross,
            'totalTax' => $totalTax - $totalReturnVatAmount - $totalVoidVatAmount ,
            'totalDiscount' => $totalDiscount,
            'date' => $date->format('M d Y '),
            'totalNet' => $totalNet,
            'dateCreated' => Carbon::now()->format('M d Y h:i A'),
            'createdBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname
        ];
    }

    public function download()
    {
        // Sample download method
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

    // Uncomment and implement this method if needed
    // function calculateVoidAmounts($detail, &$transaction) {
    //     ...
    // }
}
