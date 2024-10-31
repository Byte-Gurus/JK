<?php

namespace App\Livewire\Components\Sales;

use App\Models\Returns;
use App\Models\Transaction;
use App\Models\VoidTransaction;
use Illuminate\Support\Carbon;
use Livewire\Component;

class VoidTransactionModal extends Component
{

    public $transaction_number;

    public function render()
    {
        return view('livewire.components.Sales.void-transaction-modal');
    }

    public function enterTransaction()
    {
        $validated = $this->validateForm();
        $transaction = Transaction::where('transaction_number', $validated['transaction_number'])->first();
        $return = Returns::where('transaction_id',$transaction->id)->first();

        if ($return) {
            $this->addError('transaction_number', 'The transaction number is already returned');
            return;
        }
        if (!$transaction) {
            $this->addError('transaction_number', 'The transaction number does not exist.');
            return;
        }

        if ($transaction->transaction_type != "Sales") {
            $this->addError('transaction_number', 'The transaction number is not a sales.');
            return;
        }
        if ($transaction->created_at->diffInHours(Carbon::now()) > 24) {
            $this->addError('transaction_number', 'The transaction is older than 24 hours and cannot be voided.');
            return;
        }

        if (isset($transaction->voidTransactionJoin)) {
            $this->addError('transaction_number', 'The transaction number already have void.');
            return;
        }

        $this->dispatch('display-void-transaction-form')->to(VoidTransactionPage::class);
        $this->dispatch('get-transaction', Transaction: $transaction)->to(VoidTransactionForm::class);
        $this->reset(['transaction_number']);
    }

    protected function validateForm()
    {

        $rules = [
            'transaction_number' => 'required|string|max:255',
        ];


        return $this->validate($rules);
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }

    private function resetForm() //*tanggalin ang laman ng input pati $item_id value
    {
        $this->reset('transaction_number');
    }
}
