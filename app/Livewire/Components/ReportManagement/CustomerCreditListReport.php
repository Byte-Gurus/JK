<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Credit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerCreditListReport extends Component
{
    public $dateCreated, $createdBy, $credits, $fromDate, $toDate;
    public $isTransactionEmpty = false;

    public function render()
    {

        $this->reportInfo();

        return view('livewire.components.ReportManagement.customer-credit-list-report', [
            'credits' => $this->credits
        ]);
    }
    protected $listeners = [
        'generate-report' => 'generateReport'
    ];

    public function reportInfo()
    {
        $this->createdBy = Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname;

        $this->dateCreated = Carbon::now()->format('M d Y h:i A');
    }

    public function generateReport($fromDate, $toDate)
    {

        $startDate = Carbon::parse($fromDate)->startOfDay();
        $endDate = Carbon::parse($toDate)->endOfDay();

        $this->fromDate = $startDate->format('M d Y');
        $this->toDate = $endDate->format('M d Y');


        $this->credits = Credit::whereBetween('created_at', [$startDate, $endDate])->get();
        if ($this->credits->isEmpty()) {
            $this->isTransactionEmpty = true;

        }

    }
}
