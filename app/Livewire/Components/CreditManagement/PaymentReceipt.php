<?php

namespace App\Livewire\Components\CreditManagement;

use Livewire\Component;

class PaymentReceipt extends Component
{

    public $showPaymentReceipt = false;
    public function render()
    {
        return view('livewire.components.credit-management.payment-receipt');
    }

    protected $listeners = [
        'display-payment-receipt' => 'displayPaymentReceipt', //*  galing sa UserTable class
    ];

    public function displayPaymentReceipt($showPaymentReceipt)
    {
        $this->showPaymentReceipt = $showPaymentReceipt;
    }
}
