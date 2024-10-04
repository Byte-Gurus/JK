<?php

namespace App\Livewire\Pages;

use App\Livewire\Charts\DailySalesChart;
use App\Livewire\Charts\WeeklySalesChart;
use App\Models\Item;
use Carbon\Carbon;
use DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $day, $week, $month, $year;
    public $selectPicker = 1;
    public $sidebarStatus;
    public function render()
    {
        $reorder_lists = Item::join('inventories', 'items.id', '=', 'inventories.item_id')
            ->select(
                'items.id as item_id',
                'items.barcode',
                'items.item_name',
                'items.item_description',
                'items.reorder_point',
                'items.maximum_stock_level',
                'items.status_id',
                DB::raw('
                        COALESCE(SUM(CASE WHEN inventories.status != \'Expired\' THEN inventories.current_stock_quantity ELSE 0 END), 0) as total_quantity
                    ')
            )
            ->groupBy(
                'items.id',
                'items.barcode',
                'items.item_name',
                'items.item_description',
                'items.reorder_point',
                'items.maximum_stock_level',
                'items.status_id'
            )
            ->havingRaw('
                    COALESCE(SUM(CASE WHEN inventories.status != \'Expired\' THEN inventories.current_stock_quantity ELSE 0 END), 0) <= items.reorder_point
                ') // Use the same expression as in the SELECT clause
            ->get()
            ->toArray();

        return view('livewire.pages.dashboard', [
            'reorder_lists' => $reorder_lists
        ]);
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'change-sidebar-status' => 'changeSidebarStatus',
        "echo:refresh-transaction,TransactionEvent" => 'refreshFromPusher',
        "echo:refresh-stock,RestockEvent" => 'refreshFromPusher',
        "echo:refresh-adjustment,AdjustmentEvent" => 'refreshFromPusher',
    ];

    public function changeSidebarStatus($sidebarOpen)
    {
        $this->sidebarStatus = $sidebarOpen;
    }

    public function updatedSelectPicker($picker)
    {
        $this->selectPicker = $picker;
    }
    public function refreshFromPusher()
    {
        $this->resetPage();
    }


}
