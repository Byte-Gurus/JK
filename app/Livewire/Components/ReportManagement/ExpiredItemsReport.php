<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Inventory;
use App\Models\ReturnDetails;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ExpiredItemsReport extends Component
{
    public $createdBy, $dateCreated, $expiredItems, $fromDate, $toDate;

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

        $this->fromDate = $startDate->format('M d Y');
        $this->toDate = $endDate->format('M d Y');


        // Fetch records from ReturnDetails where operation is 'Expired'
        $returnDetails = ReturnDetails::where('operation', 'Expired')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Fetch records from Inventory where status is 'Expired'
        $inventory = Inventory::where('status', 'Expired')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Combine the two collections and add type and date for sorting
        $combined = $returnDetails->map(function ($item) {
            $item->type = 'return';
            $item->date = $item->created_at; // Assuming created_at is the date field to use
            return $item;
        })->merge($inventory->map(function ($item) {
            $item->type = 'inventory';
            $item->date = $item->expiration_date; // Assuming expiration_date is the date field to use
            return $item;
        }));

        // Sort the combined collection by date
        $this->expiredItems = $combined->sortBy('date')->values();

    }
}
