<?php

namespace App\Livewire\Components\CreditManagement;

use Livewire\Component;

class PaymentReceipt extends Component
{

    public $showPaymentReceipt = false;
    public $credit_payment_info = [];
    public function render()
    {
        return view('livewire.components.credit-management.payment-receipt',[
            'credit_payment_info' => $this->credit_payment_info
        ]);
    }

    protected $listeners = [
        'display-payment-receipt' => 'displayPaymentReceipt', //*  galing sa UserTable class
        'get-payment-info' => 'getPaymentInfo'
    ];

    public function displayPaymentReceipt($showPaymentReceipt)
    {
        $this->showPaymentReceipt = $showPaymentReceipt;
    }

    public function getPaymentInfo($data)
    {
        $this->credit_payment_info = $data;
    }
}
