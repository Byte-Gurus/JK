<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\ReturnDetails;
use App\Models\Returns;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SalesReturnReport extends Component
{
    public $createdBy, $dateCreated;

    public function render()
    {
        $returnItems = ReturnDetails::all();

        $this->reportInfo();
        return view('livewire.components.ReportManagement.sales-return-report', [
            'returnItems' => $returnItems
        ]);
    }
    public function reportInfo()
    {
        $this->createdBy = Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname;

        $this->dateCreated = Carbon::now()->format('M d Y h:i A');
    }
}
