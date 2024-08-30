<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;

class PaymentForm extends Component
{
    public $payWithCash = true;

    public function render()
    {
        return view('livewire.components.sales.payment-form');
    }

    public function changePaymentMethod()
    {
        $this->payWithCash = !$this->payWithCash;
    }

    private function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        // $this->reset(['firstname', 'middlename', 'lastname', 'contact_number', 'role', 'status', 'username', 'password', 'retype_password', 'user_id']);
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }


}
