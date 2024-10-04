<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Inventory;
use App\Models\ReturnDetails;
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
        $returnDetails = ReturnDetails::where('operation', 'expired')->get();

        // Fetch records from Inventory where status is 'expired'
        $inventory = Inventory::where('status', 'expired')->get();

        // Combine the two collections
        $combined = $returnDetails->map(function ($item) {
            // Add a type to distinguish between the models if necessary
            $item->type = 'return';
            $item->date = $item->created_at; // or any date field you want to use for sorting
            return $item;
        })->merge($inventory->map(function ($item) {
            // Add a type to distinguish between the models if necessary
            $item->type = 'inventory';
            $item->date = $item->expiration_date; // or any date field you want to use for sorting
            return $item;
        }));

        // Sort the combined collection by date
        $this->expiredItems = $combined->sortBy('date');
        dd($this->expiredItems);
    }
}
