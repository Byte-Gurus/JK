<?php

namespace App\Livewire\Components\Sales;

use App\Events\InventoryEvent;
use App\Events\TransactionEvent;
use App\Livewire\Pages\CashierPage;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use App\Models\TransactionMovement;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class SalesTransactionHistory extends Component
{
    use WithPagination, WithoutUrlPagination, LivewireAlert;
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
    public function getTransactionID($transaction_id)
    {


        $this->transactionDetails = TransactionDetails::where('transaction_id', $transaction_id)
            ->whereHas('transactionJoin')
            ->get();

        $transaction = Transaction::find($transaction_id);

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

    public function returnSalesTransactionHistory()
    {
        $this->showSalesAdminLoginForm = false;
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
            $transaction = Transaction::find($this->salesID);
            $transaction->transaction_type = 'Void';
            $transaction->save();

            $transactionDetails = TransactionDetails::where('transaction_id', $this->salesID)->get();

            foreach ($transactionDetails as $transactionDetail) {
                $transactionDetail->status = 'Void';
                $transactionDetail->save();

                $inventory = Inventory::where('sku_code', $transactionDetail->inventoryJoin->sku_code)->first();
                $inventory->current_stock_quantity += $transactionDetail->item_quantity;
                $inventory->save();

                $inventoryMovement = InventoryMovement::create([
                    'movement_type' => 'Sales',
                    'operation' => 'Void',
                    'transaction_detail_id' => $transactionDetail->id
                ]);
            }

            $transactionMovement = TransactionMovement::where('transaction_id', $transaction->id)->first();
            $transactionMovement->transaction_type = 'Void';
            $transactionMovement->save();





            $this->alert('success', 'Transaction was voided successfully');

        } elseif ($this->isAdmin && $this->whatVoid === 'TransactionDetails') {
            $transactionDetail = TransactionDetails::find($this->tranasactionDetails_ID)->first();
            $transactionDetail->status = 'Void';
            $transactionDetail->save();

            $inventory = Inventory::where('sku_code', $transactionDetail->inventoryJoin->sku_code)->first();
            $inventory->current_stock_quantity += $transactionDetail->item_quantity;
            $inventory->save();

            $inventoryMovement = InventoryMovement::create([
                'movement_type' => 'Sales',
                'operation' => 'Void',
                'transaction_detail_id' => $transactionDetail->id
            ]);

            $this->alert('success', 'Item was voided successfully');

        }

        $this->displaySalesAdminLoginForm();
        TransactionEvent::dispatch('refresh-transaction');

        $this->resetPage();
    }
}
