<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Credit;
use Livewire\Component;

class CustomerCreditListReport extends Component
{
    public function render()
    {
        $credits = Credit::whereHas('transactionJoin')->get();
        
        return view('livewire.components.ReportManagement.customer-credit-list-report',[
            'credits' => $credits
        ]);
    }
}
