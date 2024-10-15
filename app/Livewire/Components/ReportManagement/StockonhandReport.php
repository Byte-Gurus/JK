<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StockonhandReport extends Component
{
    public $createdBy, $dateCreated;
    public $isTransactionEmpty = false;
    public function render()
    {
        $inventories = Inventory::query()
            ->where('status', 'Available')
            ->get();

        $this->reportInfo();
        return view('livewire.components.ReportManagement.stockonhand-report', [
            'inventories' => $inventories
        ]);

        if ($this->inventories->isEmpty()) {
            $this->isTransactionEmpty = true;

        }
    }

    public function reportInfo()
    {
        $this->createdBy = Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname;

        $this->dateCreated = Carbon::now()->format('M d Y h:i A');



    }
}
