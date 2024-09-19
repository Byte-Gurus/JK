<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReorderListReport extends Component
{
    public $createdBy, $dateCreated;
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

        $this->reportInfo();

        return view('livewire.components.ReportManagement.reorder-list-report', [
            'reorder_lists' => $reorder_lists
        ]);
    }

    public function reportInfo()
    {
        $this->createdBy = Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname;

        $this->dateCreated = Carbon::now()->format('m d Y h:i:s a');
    }
}
