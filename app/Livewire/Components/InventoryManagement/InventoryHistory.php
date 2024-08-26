<?php

namespace App\Livewire\Components\InventoryManagement;

use App\Models\Inventory;
use App\Models\InventoryAdjustment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;


class InventoryHistory extends Component
{

    use WithPagination,  WithoutUrlPagination;
    public $sortDirection = 'asc'; //var default sort direction is ascending
    public $sortColumn = 'id'; //var defualt sort is ID
    public $perPage = 10; //var for pagination
    public $search = '';  //var search component

    public $statusFilter = 0; //var filtering value = all
    public $vatFilter = 0; //var filtering value = all
    public function render()
    {
        // $merges = DB::table('inventories')
        //     ->select('inventories.id', 'inventories.current_stock_quantity', 'inventories.item_id', 'inventories.user_id', 'inventories.created_at')
        //     ->join('items', 'inventories.item_id', '=', 'items.id')
        //     ->groupBy('inventories.id', 'inventories.current_stock_quantity', 'inventories.item_id', 'inventories.user_id', 'inventories.created_at',)
        //     ->unionAll(
        //         DB::table('inventory_adjustments')
        //             ->select('inventory_adjustments.id', 'inventory_adjustments.operation', 'inventory_adjustments.adjusted_quantity', 'inventory_adjustments.user_id', 'inventory_adjustments.created_at', 'inventory_adjustments.inventory_id')
        //             ->groupBy('inventory_adjustments.id', 'inventory_adjustments.operation', 'inventory_adjustments.adjusted_quantity', 'inventory_adjustments.user_id', 'inventory_adjustments.created_at')
        //     )
        //     ->get();

        // foreach ($merges as $merge) {
        //     $merge->created_at = Carbon::parse($merge->created_at);
        // }
        // if ($this->statusFilter != 0) {
        //     $query->where('status_id', $this->statusFilter); //?hanapin ang status na may same value sa statusFilter
        // }
        // if ($this->vatFilter != 0) {
        //     $query->where('vat_type', $this->vatFilter); //?hanapin ang status na may same value sa statusFilter
        // }

        // , compact('merges')

        return view('livewire.components.InventoryManagement.inventory-history');
    }
}
