<?php

namespace App\Livewire\Components\CreditManagement;

use Livewire\Component;

class CreditPaymentForm extends Component
{
    public $payWithCash = true;
    public function render()
    {
        return view('livewire.components.credit-management.credit-payment-form');
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
