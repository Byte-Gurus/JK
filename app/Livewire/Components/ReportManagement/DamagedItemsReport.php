<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\ReturnDetails;
use Illuminate\Support\Carbon;
use Livewire\Component;

class DamagedItemsReport extends Component
{
    public function render()
    {
        return view('livewire.components.ReportManagement.damaged-items-report');
    }

    public function generateReport($toDate, $fromDate)
    {
        $startDate = Carbon::parse($fromDate)->startOfDay();
        $endDate = Carbon::parse($toDate)->endOfDay();

        $this->returnDetails = ReturnDetails::where('operation', 'Damaged')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();



      

    }
}
