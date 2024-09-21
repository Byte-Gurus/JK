<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Credit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerCreditListReport extends Component
{
    public $dateCreated, $createdBy;
    public function render()
    {
        $credits = Credit::whereHas('transactionJoin')->get();

        $this->reportInfo();

        return view('livewire.components.ReportManagement.customer-credit-list-report',[
            'credits' => $credits
        ]);
    }

    public function reportInfo()
    {
        $this->createdBy = Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname;

        $this->dateCreated = Carbon::now()->format('M d Y h:i A');
    }
}
