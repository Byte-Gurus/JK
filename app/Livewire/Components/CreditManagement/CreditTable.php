<?php

namespace App\Livewire\Components\CreditManagement;

use App\Livewire\Pages\CreditManagementPage;
use App\Models\Credit;
use Livewire\Component;

class CreditTable extends Component
{
    public function render()
    {
        $credits = Credit::with('transactionJoin')->get();
        return view('livewire.components.CreditManagement.credit-table', [
            'credits' => $credits
        ]);
    }

    public function displayCreditPaymentForm()
    {
        $this->dispatch('display-credit-payment-form', showCreditPaymentForm: true)->to(CreditManagementPage::class);
    }
}
