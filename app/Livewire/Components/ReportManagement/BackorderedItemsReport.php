<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\BackOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BackorderedItemsReport extends Component
{
    public $isTransactionEmpty = false;
    public $createdBy, $dateCreated;
    public function render()
    {
        $backorderLists = BackOrder::where('status', 'Missing')->get();
        $this->reportInfo();

        if ($backorderLists->isEmpty()) {
            $this->isTransactionEmpty = true;

        }

        return view('livewire.components.ReportManagement.backordered-items-report', [
            'backorderLists' => $backorderLists
        ]);
    }
    public function reportInfo()
    {
        $this->createdBy = Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname;

        $this->dateCreated = Carbon::now()->format('M d Y h:i A');
    }
}
