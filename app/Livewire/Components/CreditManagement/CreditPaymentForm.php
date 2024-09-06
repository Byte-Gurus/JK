<?php

namespace App\Livewire\Components\CreditManagement;

use App\Models\Credit;
use Livewire\Component;

class CreditPaymentForm extends Component
{
    public $credit_amount;
    public $payWithCash = true;
    public function render()
    {
        return view('livewire.components.credit-management.credit-payment-form');
    }
    protected $listeners = [
        'credit-payment' => 'creditPayment', //*  galing sa UserTable class

    ];

    public function creditPayment($credit_ID)
    {
        $credit = Credit::find($credit_ID);
        $this->credit_amount = $credit->credit_amount;
    }
    public function changePaymentMethod()
    {
        $this->payWithCash = !$this->payWithCash;
    }

    private function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        // $this->reset(['tendered_amount', 'reference_no']);
    }

    public function resetFormWhenClosed()
    {
        // $this->resetForm();
        // $this->resetValidation();
    }
}
