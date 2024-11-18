<?php

namespace App\Livewire\Components\SupplierManagement;

use App\Models\Item;
use App\Models\Supplier;
use App\Models\SupplierItems;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class SupplierItemCostsTable extends Component
{
    use WithPagination, WithoutUrlPagination, LivewireAlert;
    public $supplier_id, $supplier;

    public $unitFilter = 0; //var filtering value = all
    public $categoryFilter = 0;
    public $sortDirection = 'desc'; //var default sort direction is ascending
    public $sortColumn = 'id'; //var defualt sort is ID
    public $perPage = 10; //var for pagination
    public $search = '';
    public $addItem = '';

    public $showModal = false;

    public $showSupplierItemCostsForm = false;

    public function render()
    {


        $query = SupplierItems::query()
            ->where('supplier_id', $this->supplier_id);



        if ($this->unitFilter != 0) {
            $query->whereHas('itemJoin', function ($query) {
                $query->where('item_unit', $this->unitFilter);
            });
        }
        if ($this->categoryFilter != 0) {
            $query->whereHas('itemJoin', function ($query) {
                $query->where('item_category', $this->categoryFilter);
            });
        }

        $items = Item::all();

        $supplierItems = $query->search($this->search) //?search the user
            ->orderBy($this->sortColumn, $this->sortDirection) //? i sort ang column based sa $sortColumn na var
            ->paginate($this->perPage);


        return view('livewire.components.SupplierManagement.supplier-item-costs-table', [
            'supplierItems' => $supplierItems,
            'items' => $items
        ]);
    }

    protected $listeners = [
        'get-supplier-items' => 'getSupplierItems'
    ];

    public function sortByColumn($column)
    { //* sort the column

        //* if ang $column is same sa global variable na sortColumn then if ang sortDirection is desc then it will be asc
        if ($this->sortColumn = $column) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            //* if hindi same ang $column sa global variable na sortColumn, then gawing asc ang column
            $this->sortDirection = 'asc';
        }

        $this->sortColumn = $column; //* gawing global variable ang $column
    }
    public function getSupplierItems($supplierId)
    {
        $this->supplier_id = $supplierId;
        $this->supplier = Supplier::find($supplierId);


    }

    public function selectItem($itemId)
    {
        $isItemExist = SupplierItems::where('item_id', $itemId)->exists();

        if ($isItemExist) {
            $this->alert('error', ' This item already exist');
            return;
        }
        $supplierItem = SupplierItems::create([
            'item_cost' => 0.00,
            'item_id' => $itemId,
            'supplier_id' => $this->supplier_id
        ]);

        $this->reset('addItem');

        $this->supplierItemCostsFormCreate();

    }

    public function supplierItemCostsFormCreate()
    {
        $this->showSupplierItemCostsForm = true;
        $this->dispatch('change-method', isCreateSupplierItemCosts: true)->to(SupplierItemCostsForm::class);
    }

    public function removeRow($supplierItem_id){
        $supplierItem = SupplierItems::find($supplierItem_id);
        $supplierItem->delete();
    }
}
