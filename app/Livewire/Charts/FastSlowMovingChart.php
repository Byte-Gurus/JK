<?php

namespace App\Livewire\Charts;

use App\Models\Inventory;
use App\Models\TransactionDetails;
use Carbon\Carbon;
use Livewire\Component;

class FastSlowMovingChart extends Component
{
    public $month;
    public $fastmoving_info = [];
    public function render()
    {
        if (!$this->month) {
            $currentMonth = Carbon::now()->format('Y-m');
            $this->updatedMonth($currentMonth);
        }
        return view('livewire.charts.fast-slow-moving-chart');
    }

    public function updatedMonth($currentMonth)
    {

        if (!$currentMonth) {
            $currentMonth = Carbon::now()->format('Y-m');
        }
        $date = Carbon::createFromFormat('Y-m', $currentMonth);
        // Calculate the start and end date of the month
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();
        $this->fastmoving_info = [];

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

            $this->fastmoving_info[] = [
                'item_name' => $item->itemJoin->item_name,
                'item_description' =>  $item->itemJoin->item_description,
                'tsi' => $totalQuantity,
                'totalStockInQuantity' => $totalStockInQuantity,
                'weeksWithStockIn' => $weeksWithStockIn,
                'aii' => $averageStockInPerWeek,
                'fast_slow' => $fastSlowValue
            ];
        }
        usort($this->fastmoving_info, function ($a, $b) {
            return $b['fast_slow'] <=> $a['fast_slow'];
        });

        $this->fastmoving_info = array_slice($this->fastmoving_info, 0, 10);
        $this->dispatch('fastSlowUpdated', $this->fastmoving_info);
        // dd($this->fastmoving_info);
    }
}
