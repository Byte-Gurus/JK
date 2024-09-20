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

    public $showDailySalesReportDatePickerModal,$showWeeklySalesReportDatePickerModal,$showMonthlySalesReportDatePickerModal,$showYearlySalesReportDatePickerModal,$showSlowMovingItemsReportDatePickerModal,$showFastMovingItemsReportDatePickerModal = false;

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
        'display-daily-sales-report' => 'displayDailySalesReport',
        'close-daily-sales-report-date-picker-modal' => 'closeDailySalesReportDatePickerModal',
        'close-weekly-sales-report-date-picker-modal' => 'closeWeeklySalesReportDatePickerModal',
        'close-yearly-sales-report-date-picker-modal' => 'closeYearlySalesReportDatePickerModal',
        'close-monthly-sales-report-date-picker-modal' => 'closeMonthlySalesReportDatePickerModal',
        'display-weekly-sales-report' => 'displayWeeklySalesReport',
        'display-monthly-sales-report' => 'displayMonthlySalesReport',
        'display-yearly-sales-report' => 'displayYearlySalesReport',
        'display-customer-credit-list-report' => 'displayYearlySalesReport',
        'display-slow-moving-items-report' => 'displaySlowMovingItemsReport',
        'close-slow-moving-items-report-date-picker-modal' => 'closeSlowMovingItemsReportDatePickerModal',
        'close-fast-moving-items-report-date-picker-modal' => 'closeFastMovingItemsReportDatePickerModal',
        'display-fast-moving-items-report' => 'displayFastMovingItemsReport',
    ];


    public function calculateFastMoving($month = '2024-09')
    {
        // $date = Carbon::createFromFormat('Y-m', $month);
        // // Calculate the start and end date of the month
        // $startOfMonth = $date->copy()->startOfMonth();
        // $endOfMonth = $date->copy()->endOfMonth();
        // $fastmoving_info = [];

        // $items = Inventory::select('item_id')->distinct()->get();

        // foreach ($items as $item) {
        //     $weeklyStockInQuantities = [];
        //     $weeklyQuantities = [];
        //     $totalQuantity = 0;
        //     $totalStockInQuantity = 0;
        //     $weekCount = 0;
        //     $weeksWithStockIn = 0;

        //     // Loop through each week of the month
        //     $currentDate = $startOfMonth->copy();

        //     while ($currentDate->lessThanOrEqualTo($endOfMonth)) {
        //         $startOfWeek = $currentDate->copy()->startOfWeek();
        //         $endOfWeek = $currentDate->copy()->endOfWeek();

        //         // Adjust the week boundaries if they fall outside the current month
        //         if ($startOfWeek->lessThan($startOfMonth)) {
        //             $startOfWeek = $startOfMonth->copy();
        //         }
        //         if ($endOfWeek->greaterThan($endOfMonth)) {
        //             $endOfWeek = $endOfMonth->copy();
        //         }

        //         // Query the database to get the sum of item_quantity within the date range for the specific item
        //         $weeklyQuantity = TransactionDetails::where('item_id', $item->item_id)
        //             ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
        //             ->sum('item_quantity');

        //         $weeklyQuantities[] = [
        //             'week' => $weekCount + 1,
        //             'start_of_week' => $startOfWeek->toDateString(),
        //             'end_of_week' => $endOfWeek->toDateString(),
        //             'total_quantity' => $weeklyQuantity,
        //         ];

        //         // Query the database to get the sum of stock_in_quantity within the date range for the specific item
        //         $weeklyStockIn = Inventory::where('item_id', $item->item_id)
        //             ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
        //             ->sum('stock_in_quantity');

        //         if ($weeklyStockIn > 0) {
        //             $weeklyStockInQuantities[] = [
        //                 'week' => $weeksWithStockIn + 1,
        //                 'start_of_week' => $startOfWeek->toDateString(),
        //                 'end_of_week' => $endOfWeek->toDateString(),
        //                 'total_stock_in' => $weeklyStockIn,
        //             ];

        //             $totalStockInQuantity += $weeklyStockIn;
        //             $weeksWithStockIn++;
        //         }



        //         $totalQuantity += $weeklyQuantity;
        //         $weekCount++;
        //         $currentDate = $endOfWeek->addDay();
        //     }
        //     $averageStockInPerWeek = $weeksWithStockIn > 0 ? $totalStockInQuantity / $weeksWithStockIn : 0;

        //     $fastSlowValue = $averageStockInPerWeek > 0 ? $totalQuantity / $averageStockInPerWeek : 0;
        //     $fastmoving_info[] = [
        //         'item_name' => $item->itemJoin->item_name,
        //         'tsi' => $totalQuantity,
        //         'totalStockInQuantity' => $totalStockInQuantity,
        //         'weeksWithStockIn' => $weeksWithStockIn,
        //         'aii' => $averageStockInPerWeek,
        //         'fast_slow' => $fastSlowValue
        //     ];
        // }

        // dd($fastmoving_info);
        // dd($item->item_id, $weeksWithStockIn, $totalStockInQuantity, $averageStockInPerWeek, $totalQuantity, $weekCount);
    }


    public function changeSidebarStatus($sidebarOpen)
    {
        $this->sidebarStatus = $sidebarOpen;
    }





    public function hideExtras()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showDailySalesReportDatePickerModal = false;
        $this->showWeeklySalesReportDatePickerModal = false;
        $this->showMonthlySalesReportDatePickerModal = false;
        $this->showYearlySalesReportDatePickerModal = false;
        $this->showSlowMovingItemsReportDatePickerModal = false;
        $this->showFastMovingItemsReportDatePickerModal = false;
    }

    // Daily Sales Report

    public function displayDailySalesReportDatePickerModal()
    {
        $this->showDailySalesReportDatePickerModal = true;
    }

    public function displayDailySalesReport()
    {
        $this->showDailySalesReport = !$this->showDailySalesReport;
        $this->hideExtras();
    }

    public function closeDailySalesReportDatePickerModal()
    {
        $this->showDailySalesReportDatePickerModal = false;
    }

    // Weekly Sales Report

    public function displayWeeklySalesReportDatePickerModal()
    {
        $this->showWeeklySalesReportDatePickerModal = true;
    }

    public function displayWeeklySalesReport()
    {
        $this->showWeeklySalesReport = !$this->showWeeklySalesReport;
        $this->hideExtras();
    }

    public function closeWeeklySalesReportDatePickerModal()
    {
        $this->showWeeklySalesReportDatePickerModal = false;
    }

    // Monthly Sales Report

    public function displayMonthlySalesReportDatePickerModal()
    {
        $this->showMonthlySalesReportDatePickerModal = true;
    }

    public function displayMonthlySalesReport()
    {
        $this->showMonthlySalesReport = !$this->showMonthlySalesReport;
        $this->hideExtras();
    }

    public function closeMonthlySalesReportDatePickerModal()
    {
        $this->showMonthlySalesReportDatePickerModal = false;
    }

    // Yearly Sales Report

    public function displayYearlySalesReportDatePickerModal()
    {
        $this->showYearlySalesReportDatePickerModal = true;
    }

    public function displayYearlySalesReport()
    {
        $this->showYearlySalesReport = !$this->showYearlySalesReport;
        $this->hideExtras();
    }

    public function closeYearlySalesReportDatePickerModal()
    {
        $this->showYearlySalesReportDatePickerModal = false;
    }

    // Sales Return Report

    public function displaySalesReturnReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showSalesReturnReport = true;
    }

    // Customer Credit List Report

    public function displayCustomerCreditListReport()
    {
        $this->showCustomerCreditListReport = true;
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
    }

    public function displayStockonhandReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showStockonhandReport = true;
    }

    // Slow moving Items Report

    public function displaySlowMovingItemsReportDatePickerModal()
    {
        $this->showSlowMovingItemsReportDatePickerModal = true;
    }

    public function displaySlowMovingItemsReport()
    {
        $this->showSlowMovingItemsReport = !$this->showSlowMovingItemsReport;
        $this->hideExtras();
    }

    public function closeSlowMovingItemsReportDatePickerModal()
    {
        $this->showSlowMovingItemsReportDatePickerModal = false;
    }

    // Fast moving Items Report

    public function displayFastMovingItemsReportDatePickerModal()
    {
        $this->showFastMovingItemsReportDatePickerModal = true;
    }

    public function displayFastMovingItemsReport()
    {
        $this->showFastMovingItemsReport = !$this->showFastMovingItemsReport;
        $this->hideExtras();
    }

    public function closeFastMovingItemsReportDatePickerModal()
    {
        $this->showFastMovingItemsReportDatePickerModal = false;
    }

    // Reorder list Report

    public function displayReorderListReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showReorderListReport = true;
    }

    // Backordered Items Report

    public function displayBackorderedItemsReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showBackorderedItemsReport = true;
    }

    // Expired Items Report

    public function displayExpiredItemsReport()
    {
        $this->reportSelected = true;
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showExpiredItemsReport = true;
    }
}
