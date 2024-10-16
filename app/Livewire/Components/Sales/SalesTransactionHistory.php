<?php

namespace App\Livewire\Components\Sales;

use App\Events\InventoryEvent;
use App\Events\TransactionEvent;
use App\Livewire\Pages\CashierPage;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\ReturnDetails;
use App\Models\Returns;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use App\Models\TransactionMovement;
use App\Models\VoidTransaction;
use App\Models\VoidTransactionDetails;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SalesTransactionHistory extends Component
{
    use WithPagination, WithoutUrlPagination, LivewireAlert;
    public $transaction_number, $subtotal, $discount_percent, $total_discount_amount, $grandTotal, $tendered_amount, $change, $transaction_type, $return_original_amount, $return_amount, $payment_type, $salesID, $isAdmin, $tranasactionDetails_ID, $void_amount, $void_original_amount, $excess_amount;
    public $transactionDetails = [];
    public $whatVoid;
    public $sortDirection = 'desc'; //var default sort direction is ascending
    public $sortColumn = 'id'; //var defualt sort is ID
    public $perPage = 10; //var for pagination
    public $search = '';  //var search component
    public $transactionFilter = 0; //var filtering value = all
    public $paymentFilter = 0;
    public $vatFilter = 0; //var filtering value = all
    public $supplierFilter = 0;
    public $showSalesAdminLoginForm = false;

    public $startDate, $endDate;
    public function render()
    {
        $query = TransactionMovement::query();

        if ($this->transactionFilter != 0) {
            $query->where('transaction_type', $this->transactionFilter);
        }
        if ($this->paymentFilter != 0) {
            $query->whereHas('transactionJoin.paymentJoin', function ($query) {
                $query->where('payment_type', $this->paymentFilter);
            });
        }
        if ($this->startDate && $this->endDate) {
            $startDate = Carbon::parse($this->startDate)->startOfDay();
            $endDate = Carbon::parse($this->endDate)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $transactions = $query->search($this->search) //?search the user
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);


        return view(
            'livewire.components.Sales.sales-transaction-history',
            ['transactions' => $transactions,]
        );
    }

    protected $listeners = [
        "echo:refresh-transaction,TransactionEvent" => 'refreshFromPusher',
        'return-sales-transaction-history' => 'returnSalesTransactionHistory',
        "echo:refresh-return,ReturnEvent" => 'refreshFromPusher',
        'admin-confirmed' => 'adminConfirmed',
    ];
    public function getTransactionID($transaction_id, $type)
    {

        $this->transaction_type = $type;

        switch ($this->transaction_type) {
            case 'Sales':
            case 'Credit':
                $this->transactionDetails = TransactionDetails::where('transaction_id', $transaction_id)
                    ->whereHas('transactionJoin')
                    ->get();

                $transaction = Transaction::with('discountJoin')
                    ->find($transaction_id);

                $this->payment_type = $transaction->paymentJoin->payment_type ?? null;
                $this->transaction_number = $transaction->transaction_number;
                $this->subtotal = $transaction->subtotal;
                $this->grandTotal = $transaction->total_amount;

                $this->discount_percent = $transaction->discountJoin->percentage ?? 0;
                $this->tendered_amount = $transaction->paymentJoin->tendered_amount ?? 0;
                $this->excess_amount = $transaction->excess_amount ?? 0;

                if ($this->excess_amount > 0) {
                    $this->change = $this->tendered_amount - $this->excess_amount;

                } else {
                    $this->change = $this->tendered_amount - $this->grandTotal;
                }
                break;
            case 'Return':
                $this->transactionDetails = ReturnDetails::where('return_id', $transaction_id)
                    ->get();

                $transaction = Returns::find($transaction_id);

                $this->transaction_number = $transaction->return_number;
                $this->return_original_amount = $transaction->original_amount ?? 0;
                $this->return_amount = $transaction->return_total_amount ?? 0;
                break;

            case 'Void':
                $this->transactionDetails = VoidTransactionDetails::where('void_transaction_id', $transaction_id)
                    ->get();

                $transaction = VoidTransaction::find($transaction_id);

                $this->transaction_number = $transaction->void_number;
                $this->void_original_amount = $transaction->original_amount ?? 0;
                $this->void_amount = $transaction->void_total_amount ?? 0;
                break;
        }



        // if ($type == 'Return') {
        //     $this->return_original_amount = $transaction->returnJoin->original_amount ?? 0;
        //     $this->return_amount = $transaction->returnJoin->return_total_amount ?? 0;
        // } elseif ($type == 'Void') {

        // }

        // if ($this->transaction_type == 'Return') {
        //     $this->change = $this->tendered_amount - $this->return_original_amount;
        // } elseif ($this->transaction_type == 'Void') {
        //     $this->change = $this->tendered_amount - $this->void_original_amount;
        // } else {
        //     $this->change = $this->tendered_amount - $this->grandTotal;
        // }
    }

    public function sortByColumn($column)
    { //* sort the column

        //* if ang $column is same sa global variable na sortColumn then if ang sortDirection is desc then it will be asc
        if ($this->sortColumn = $column) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            //* if hindi same ang $column sa global variable na sortColumn, then gawing asc ang column
            $this->sortDirection = 'asc';
        }

        $this->sortColumn = $column; //* gawing global variable ang $column
    }

    public function returnSalesTransactionHistory()
    {
        $this->showSalesAdminLoginForm = false;
    }

    public function displayVoidTransaction()
    {
        $this->dispatch('display-void-transaction', showVoidTransactionPage: true)->to(CashierPage::class);
    }

    public function returnToSalesTransaction()
    {
        $this->dispatch('display-sales-transaction', showSalesTransaction: true)->to(CashierPage::class);
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->resetForm();
    }

    public function refreshTable()
    {
        $this->resetPage();
    }

    private function resetForm() //*tanggalin ang laman ng input pati $item_id value
    {
        $this->reset(
            'transactionDetails',
            'transaction_number',
            'subtotal',
            'grandTotal',
            'discount_percent',
            'tendered_amount',
            'change'
        );
    }
    public function refreshFromPusher()
    {
        $this->resetPage();
    }

    public function displaySalesAdminLoginForm()
    {
        $this->showSalesAdminLoginForm = !$this->showSalesAdminLoginForm;
    }

    public function voidTransaction($salesID)
    {
        $this->salesID = $salesID;
        $this->dispatch('get-from-page', $this->fromPage)->to(SalesAdminLoginForm::class);
        $this->displaySalesAdminLoginForm();
        $this->whatVoid = 'Transaction';
    }
    public function voidTransactionDetails($tranasactionDetails_ID)
    {
        $this->tranasactionDetails_ID = $tranasactionDetails_ID;
        $this->dispatch('get-from-page', $this->fromPage)->to(SalesAdminLoginForm::class);
        $this->displaySalesAdminLoginForm();
        $this->whatVoid = 'TransactionDetails';
    }

}
