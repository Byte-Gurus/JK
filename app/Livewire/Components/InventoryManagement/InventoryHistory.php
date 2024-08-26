<?php

namespace App\Livewire\Components\InventoryManagement;

use App\Models\Inventory;
use App\Models\InventoryAdjustment;
use App\Models\InventoryMovement;
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

        $InventoryHistory = InventoryMovement::all();

        return view('livewire.components.InventoryManagement.inventory-history',[
            'InventoryHistories' => $InventoryHistory
        ]);
    }
}
