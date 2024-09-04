<?php

namespace App\Livewire\Components\CreditManagement;

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
}
