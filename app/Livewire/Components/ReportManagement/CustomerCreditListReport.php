<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Credit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerCreditListReport extends Component
{
    public $dateCreated, $createdBy, $credits;
    public function render()
    {

        $this->reportInfo();

        return view('livewire.components.ReportManagement.customer-credit-list-report', [
            'credits' => $this->credits
        ]);
    }

    public function reportInfo()
    {
        $this->createdBy = Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname;

        $this->dateCreated = Carbon::now()->format('M d Y h:i A');
    }

    public function generateReport($toDate, $fromDate)
    {

        $startDate = Carbon::parse($fromDate)->startOfDay();
        $endDate = Carbon::parse($toDate)->endOfDay();

        $this->credits = Credit::whereHas('transactionJoin')
            ->whereBetween('created_at', [$startDate, $endDate])->get();
    }
}
