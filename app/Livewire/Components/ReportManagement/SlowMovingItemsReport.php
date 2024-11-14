<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Inventory;
use App\Models\TransactionDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SlowMovingItemsReport extends Component
{
    public $slowmoving_info = [];
    public $date, $dateCreated, $createdBy;
    public $isTransactionEmpty = false;
    public function render()
    {
        return view('livewire.components.ReportManagement.slow-moving-items-report');
    }
    protected $listeners = [
        'generate-report' => 'generateReport'
    ];

    public function generateReport($month)
    {


        $date = Carbon::createFromFormat('Y-m', $month);
        // Calculate the start and end date of the month
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();
        $this->slowmoving_info = [];

        $items = Inventory::select('item_id')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->distinct()
            ->get();

        if ($items->isEmpty()) {
            $this->isTransactionEmpty = true;

        }
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

            if ($fastSlowValue <= 3) {
                $this->slowmoving_info[] = [
                    'barcode' => $item->itemJoin->barcode,
                    'item_description' => $item->itemJoin->item_description,
                    'item_name' => $item->itemJoin->item_name,
                    'tsi' => $totalQuantity,
                    'totalStockInQuantity' => $totalStockInQuantity,
                    'weeksWithStockIn' => $weeksWithStockIn,
                    'aii' => $averageStockInPerWeek,
                    'fast_slow' => $fastSlowValue,


                ];

                usort($this->slowmoving_info, function ($a, $b) {
                    return $a['fast_slow'] <=> $b['fast_slow'];
                });

            }
        }

        $this->date = $startOfMonth->format('M d Y') . ' - ' . $endOfMonth->format('M d Y');
        $this->dateCreated = Carbon::now()->format('M d Y h:i A');
        $this->createdBy = Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname;


    }
}
