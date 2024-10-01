<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Inventory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ExpiredItemsReport extends Component
{
    public $createdBy, $dateCreated, $expiredItems;

    public function render()
    {


        $this->reportInfo();
        return view('livewire.components.ReportManagement.expired-items-report', [
            'expiredItems' => $this->expiredItems
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

        $this->expiredItems = Inventory::where('status', 'Expired')
            ->whereBetween('created_at', [$startDate, $endDate])->get();
    }
}
