<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\ReturnDetails;
use App\Models\Returns;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SalesReturnReport extends Component
{
    public $createdBy, $dateCreated, $returnItems, $fromDate, $toDate;
    public $isTransactionEmpty = false;

    public function render()
    {

        $this->reportInfo();
        return view('livewire.components.ReportManagement.sales-return-report', [
            'returnItems' => $this->returnItems
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

    public function generateReport($toDate, $fromDate)
    {
        $startDate = Carbon::parse($fromDate)->startOfDay();
        $endDate = Carbon::parse($toDate)->endOfDay();


        $this->fromDate = $startDate->format('M d Y');
        $this->toDate = $endDate->format('M d Y');

        $this->returnItems = ReturnDetails::whereBetween('created_at', [$startDate, $endDate])->get();

        if ($this->returnItems->isEmpty()) {
            $this->isTransactionEmpty = true;
        }
    }
}
