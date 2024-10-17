<?php

namespace App\Livewire\Components\Sales;

use App\Events\VoidEvent;
use App\Livewire\Pages\ReportManagement;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use App\Models\TransactionMovement;
use App\Models\VoidTransaction;
use App\Models\VoidTransactionDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class VoidTransactionFormModal extends Component
{
    use LivewireAlert;
    public $reason, $fromPage = 'VoidAll', $transaction_id, $void_number;

    public $isAdmin ,$adminAcc;

    public function render()
    {
        return view('livewire.components.Sales.void-transaction-form-modal');
    }
    protected $listeners = [
        'admin-confirmed' => 'adminConfirmed',
        'get-transaction' => 'getTransaction'
    ];

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-void-transaction-form-modal')->to(VoidTransactionForm::class);
        $this->resetValidation();
    }
    public function voidAllConfirmed()
    {
        $transaction = Transaction::find($this->transaction_id);

        $voidTransaction = VoidTransaction::create([
            'transaction_id' => $transaction->id,
            'void_number' => $this->void_number,
            'void_total_amount' => $transaction->total_amount,
            'original_amount' => $transaction->total_amount,
            'void_vat_amount' => $transaction->total_vat_amount,
            'hasTransaction' => false,
            'voidedBy' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname,
            'approvedBy' => $this->adminAcc,
        ]);

        $transaction_movement = TransactionMovement::create([
            'transaction_type' => 'Void',
            'void_transaction_id' => $voidTransaction->id
        ]);

        $transactionDetails = TransactionDetails::where('transaction_id', $transaction->id)->get();

        foreach ($transactionDetails as $index => $transactionDetail) {


            $voidTransactionDetail = VoidTransactionDetails::create([
                'void_quantity' => $transactionDetail->item_quantity,
                'item_void_amount' => $transactionDetail->item_subtotal,
                'reason' => $this->reason,
                'void_transaction_id' => $voidTransaction->id,
                'transaction_details_id' => $transactionDetail->id,
            ]);


            $inventory = Inventory::find($transactionDetail->inventory_id);

            $inventory->current_stock_quantity += $transactionDetail->item_quantity;
            $inventory->save();

            InventoryMovement::create([
                'movement_type' => 'Sales',
                'operation' => 'Void',
                'void_transaction_details_id' => $voidTransactionDetail->id,
            ]);

            $transactionDetail->status = 'Void';
            $transactionDetail->save();
        }

        $this->dispatch('refresh-table')->to(VoidTransactionTable::class);
        VoidEvent::dispatch('refresh-void');

        $this->alert('success', 'Item/s was voided successfully');
        $this->dispatch('return-void-transaction-page')->to(VoidTransactionPage::class);
    }
    public function resetForm()
    {
        $this->reset('reason');
    }
    public function adminConfirmed($data)
    {
        $this->isAdmin = $data['isAdmin'];
        $this->adminAcc = $data['adminAcc'];

        if ($this->isAdmin) {
            $this->voidAllConfirmed();
        }
    }

    public function getTransaction($data)
    {
        $this->transaction_id = $data['transaction_id'];
        $this->void_number = $data['void_number'];
    }
    public function voidAll()
    {
        $this->dispatch('get-from-page', $this->fromPage)->to(SalesAdminLoginForm::class);
        $this->dispatch('close-void-transaction-form-modal')->to(VoidTransactionForm::class);
        $this->dispatch('display-sales-admin-login-form')->to(VoidTransactionForm::class);
    }
}
