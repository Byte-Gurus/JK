<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Inventory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ExpiredItemsReport extends Component
{
    public $createdBy, $dateCreated;

    public function render()
    {
       
        $expiredItems = Inventory::where('status', 'Expired')->get();

        $this->reportInfo();
        return view('livewire.components.ReportManagement.expired-items-report',[
            'expiredItems' => $expiredItems
        ]);
    }

    public function reportInfo()
    {
        $this->createdBy = Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname;

        $this->dateCreated = Carbon::now()->format('m d Y h:i:s a');
    }
}
