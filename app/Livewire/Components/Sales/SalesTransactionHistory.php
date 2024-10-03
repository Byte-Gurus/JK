<?php

namespace App\Livewire\Components\Sales;

use App\Livewire\Pages\CashierPage;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use App\Models\TransactionMovement;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class SalesTransactionHistory extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $transaction_number, $subtotal, $discount_percent, $total_discount_amount, $grandTotal, $tendered_amount, $change, $transaction_type, $original_amount, $return_amount, $payment_type, $salesID, $isAdmin, $tranasactionDetails_ID;
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
    public $fromPage = "SalesHistory";
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
            ->orderBy($this->sortColumn, $this->sortDirection);
            // ->paginate($this->perPage);


        return view(
            'livewire.components.Sales.sales-transaction-history',
            ['transactions' => $transactions,]
        );
    }

    protected $listeners = [
        "echo:refresh-transaction,TransactionEvent" => 'refreshFromPusher',
        "echo:refresh-return,ReturnEvent" => 'refreshFromPusher',
        'admin-confirmed' => 'adminConfirmed',
    ];
    public function getTransactionID($transaction_id)
    {


        $this->transactionDetails = TransactionDetails::where('transaction_id', $transaction_id)
            ->whereHas('transactionJoin')
            ->get();

        $transaction = Transaction::with('discountJoin')
            ->find($transaction_id);

        $this->transaction_type = $transaction->transaction_type;
        $this->payment_type = $transaction->paymentJoin->payment_type ?? null;
        $this->transaction_number = $transaction->transaction_number;
        $this->subtotal = $transaction->subtotal;
        $this->grandTotal = $transaction->total_amount;


        $this->discount_percent = $transaction->discountJoin->percentage ?? 0;
        $this->tendered_amount = $transaction->paymentJoin->tendered_amount ?? 0;
        $this->original_amount = $transaction->returnJoin->original_amount ?? 0;
        $this->return_amount = $transaction->returnJoin->return_total_amount ?? 0;

        if ($this->transaction_type == 'Return') {
            $this->change = $this->tendered_amount - $this->original_amount;

        } else {
            $this->change = $this->tendered_amount - $this->grandTotal;
        }
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
    public function adminConfirmed($isAdmin)
    {
        $this->isAdmin = $isAdmin;


        if ($this->isAdmin && $this->whatVoid === 'Transaction') {
            $transaction = transaction::find($this->salesID)->first();
            $transaction->transaction_type = 'Void';
            $transaction->save();

            $transactionMovement = TransactionMovement::where('transaction_id', $transaction->id)->first();
            $transactionMovement->transaction_type = 'Void';
            $transactionMovement->save();
        } elseif ($this->isAdmin && $this->whatVoid === 'TransactionDetails') {
            $transactionDetail = TransactionDetails::find($this->tranasactionDetails_ID)->first();
            $transactionDetail->status = 'Void';
            $transactionDetail->save();
        }
    }
}
