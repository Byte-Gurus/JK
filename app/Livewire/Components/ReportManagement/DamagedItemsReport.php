<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\ReturnDetails;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DamagedItemsReport extends Component
{
    public $createdBy, $dateCreated, $damagedItems, $fromDate, $toDate;
    public $isTransactionEmpty = false;

    public function render()
    {
        $this->reportInfo();
        return view('livewire.components.ReportManagement.damaged-items-report');
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

        $this->damagedItems = ReturnDetails::where('description', 'Damaged')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        if ($this->damagedItems->isEmpty()) {
            $this->isTransactionEmpty = true;
            return;
        }

    }
}
