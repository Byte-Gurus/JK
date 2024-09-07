<?php

namespace App\Livewire\Components\Sales;

use App\Models\Transaction;
use Livewire\Component;

class SalesReturnModal extends Component
{
    public $transaction_number;
    public function render()
    {
        return view('livewire.components.sales.sales-return-modal');
    }

    public function enterTransaction()
    {
        $validated = $this->validateForm();
        $transaction = Transaction::where('transaction_number', $validated['transaction_number'])->first();

        if (!$transaction) {
            $this->addError('transaction_number', 'The transaction number does not exist.');
            return;
        }

        $this->dispatch('display-sales-return-details')->to(SalesReturn::class);

    }

    protected function validateForm()
    {
        $this->transaction_number = trim($this->transaction_number);

        $rules = [
            'transaction_number' => 'required|string|max:255',
        ];


        return $this->validate($rules);
    }
}
