<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\ReturnDetails;
use App\Models\Returns;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SalesReturnReport extends Component
{
    public $createdBy, $dateCreated, $fromDate, $toDate;

    public function render()
    {
        $startDate = $this->fromDate;
        $endDate = $this->toDate;

        $returnItems = ReturnDetails::whereBetween('created_at', [$startDate, $endDate])->get();

        $this->reportInfo();
        return view('livewire.components.ReportManagement.sales-return-report', [
            'returnItems' => $returnItems
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
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        dd('sasas');
    }
}
