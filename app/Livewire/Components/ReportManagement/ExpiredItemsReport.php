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
    public $isTransactionEmpty = false;
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
        $returnDetails = ReturnDetails::where('description', 'Expired')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Fetch records from Inventory where status is 'Expired'
        $inventory = Inventory::where('status', 'Expired')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Combine the two collections and add type and date for sorting
        $combined = $returnDetails->map(function ($item) {
            return (object) [
                'type' => 'return',
                'date' => $item->created_at, // Assuming created_at is the date field to use
                'sku_code' => $item->transactionDetailsJoin->inventoryJoin->sku_code,
                'barcode' => $item->transactionDetailsJoin->itemJoin->barcode ?? 'N/A',
                'item_name' => $item->transactionDetailsJoin->itemJoin->item_name ?? 'N/A',
                'item_description' => $item->transactionDetailsJoin->itemJoin->item_description ?? 'N/A',
                'quantity' => $item->return_quantity, // Return quantity for ReturnDetails
            ];
        })->merge($inventory->map(function ($item) {
            return (object) [
                'type' => 'inventory',
                'date' => $item->expiration_date, // Assuming expiration_date is the date field to use
                'barcode' => $item->itemJoin->barcode ?? 'N/A',
                'sku_code' => $item->sku_code,
                'item_name' => $item->itemJoin->item_name ?? 'N/A',
                'item_description' => $item->itemJoin->item_description ?? 'N/A',
                'quantity' => $item->current_stock_quantity, // Current stock quantity for Inventory
            ];
        }));

        $this->expiredItems = $combined->sortBy('date')->values();

        if ($this->expiredItems->isEmpty()) {
            $this->isTransactionEmpty = true;

        }
    }
}
