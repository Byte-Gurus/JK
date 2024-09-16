<?php

namespace App\Livewire\Pages;

use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\TransactionDetails;
use Carbon\Carbon;
use Livewire\Component;

class ReportManagement extends Component
{
    public $showNavbar = true;
    public $sidebarStatus;

    public $reportSelected = false;

    public $showDailySalesReport, $showWeeklySalesReport, $showMonthlySalesReport, $showYearlySalesReport, $showSalesReturnReport, $showCustomerCreditListReport, $showStockonhandReport, $showSlowMovingItemsReport, $showFastMovingItemsReport, $showReorderListReport, $showBackorderedItemsReport, $showExpiredItemsReport = false;

    public function render()
    {
        return view('livewire.pages.report-management');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'change-sidebar-status' => 'changeSidebarStatus',
        'display-inventoyry-table' => 'displayInventoryTable',
        'display-stock-card' => 'displayStockCard',
    ];


    public function calculateFastMoving($month = '2024-09')
    {
        $date = Carbon::createFromFormat('Y-m', $month);
        // Calculate the start and end date of the month
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();
        $fastmoving_info = [];

        $items = Inventory::select('item_id')->distinct()->get();

        foreach ($items as $item) {
            $weeklyStockInQuantities = [];
            $weeklyQuantities = [];
            $totalQuantity = 0;
            $totalStockInQuantity = 0;
            $weekCount = 0;
            $weeksWithStockIn = 0;

            // Loop through each week of the month
            $currentDate = $startOfMonth->copy();

            while ($currentDate->lessThanOrEqualTo($endOfMonth)) {
                $startOfWeek = $currentDate->copy()->startOfWeek();
                $endOfWeek = $currentDate->copy()->endOfWeek();

                // Adjust the week boundaries if they fall outside the current month
                if ($startOfWeek->lessThan($startOfMonth)) {
                    $startOfWeek = $startOfMonth->copy();
                }
                if ($endOfWeek->greaterThan($endOfMonth)) {
                    $endOfWeek = $endOfMonth->copy();
                }

                // Query the database to get the sum of item_quantity within the date range for the specific item
                $weeklyQuantity = TransactionDetails::where('item_id', $item->item_id)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->sum('item_quantity');

                $weeklyQuantities[] = [
                    'week' => $weekCount + 1,
                    'start_of_week' => $startOfWeek->toDateString(),
                    'end_of_week' => $endOfWeek->toDateString(),
                    'total_quantity' => $weeklyQuantity,
                ];

                // Query the database to get the sum of stock_in_quantity within the date range for the specific item
                $weeklyStockIn = Inventory::where('item_id', $item->item_id)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->sum('stock_in_quantity');

                if ($weeklyStockIn > 0) {
                    $weeklyStockInQuantities[] = [
                        'week' => $weeksWithStockIn + 1,
                        'start_of_week' => $startOfWeek->toDateString(),
                        'end_of_week' => $endOfWeek->toDateString(),
                        'total_stock_in' => $weeklyStockIn,
                    ];

                    $totalStockInQuantity += $weeklyStockIn;
                    $weeksWithStockIn++;
                }



                $totalQuantity += $weeklyQuantity;
                $weekCount++;
                $currentDate = $endOfWeek->addDay();
            }
            $averageStockInPerWeek = $weeksWithStockIn > 0 ? $totalStockInQuantity / $weeksWithStockIn : 0;

            $fastSlowValue = $averageStockInPerWeek > 0 ? $totalQuantity / $averageStockInPerWeek : 0;
            $fastmoving_info[] = [
                'item_name' => $item->itemJoin->item_name,
                'tsi' => $totalQuantity,
                'totalStockInQuantity' => $totalStockInQuantity,
                'weeksWithStockIn' => $weeksWithStockIn,
                'aii' => $averageStockInPerWeek,
                'fast_slow' => $fastSlowValue
            ];
        }

        dd($fastmoving_info);
        dd($item->item_id, $weeksWithStockIn, $totalStockInQuantity, $averageStockInPerWeek, $totalQuantity, $weekCount);
    }


    public function changeSidebarStatus($sidebarOpen)
    {
        $this->sidebarStatus = $sidebarOpen;
    }















    public function displayDailySalesReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showDailySalesReport = true;
    }

    public function displayWeeklySalesReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showWeeklySalesReport = true;
    }

    public function displayMonthlySalesReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showMonthlySalesReport = true;
    }

    public function displayYearlySalesReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showYearlySalesReport = true;
    }

    public function displaySalesReturnReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showSalesReturnReport = true;
    }

    public function displayCustomerCreditListReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showCustomerCreditListReport = true;
    }

    public function displayStockonhandReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showStockonhandReport = true;
    }

    public function displaySlowMovingItemsReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showSlowMovingItemsReport = true;
    }

    public function displayFastMovingItemsReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showFastMovingItemsReport = true;
    }

    public function displayReorderListReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showReorderListReport = true;
    }

    public function displayBackorderedItemsReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showBackorderedItemsReport = true;
    }

    public function displayExpiredItemsReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showExpiredItemsReport = true;
    }
}
