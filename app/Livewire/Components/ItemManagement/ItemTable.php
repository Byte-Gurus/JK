<?php

namespace App\Livewire\Components\ItemManagement;

use App\Livewire\Pages\ItemManagementPage;
use App\Models\Item;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ItemTable extends Component
{
    use WithPagination,  WithoutUrlPagination;
    public $sortDirection = 'desc'; //var default sort direction is ascending
    public $sortColumn = 'id'; //var defualt sort is ID
    public $perPage = 10; //var for pagination
    public $search = '';  //var search component

    public $statusFilter = 0; //var filtering value = all
    public $vatFilter = 0; //var filtering value = all
    public function render()
    {
        $query = Item::query();

        if ($this->statusFilter != 0) {
            $query->where('status_id', $this->statusFilter); //?hanapin ang status na may same value sa statusFilter
        }
        if ($this->vatFilter != 0) {
            $query->where('vat_type', $this->vatFilter); //?hanapin ang status na may same value sa statusFilter
        }
        $items = $query->search($this->search) //?search the user
            ->orderBy($this->sortColumn, $this->sortDirection) //? i sort ang column based sa $sortColumn na var
            ->paginate($this->perPage);  //?  and paginate it
        return view('livewire.components.ItemManagement.item-table', compact('items'));
    }

    protected $listeners = [
        'refresh-table' => 'refreshTable', //*  galing sa UserTable class
        "echo:refresh-item,ItemEvent" => 'refreshFromPusher',
    ];


    public function getItemID($itemId)
    {
        //*call the listesner 'edit-item-from-table' galing sa ItemForm class
        //@params itemID name ng parameter na ipapasa, $supplierId parameter value na ipapasa
        $this->dispatch('edit-item-from-table', itemID: $itemId)->to(ItemForm::class);

        //*call the listesner 'change-method' galing sa ItemForm class\
        //@params isCerate name ng parameter na ipapasa, false parameter value na ipapasa, false kasi d ka naman mag create item
        $this->dispatch('change-method', isCreate: false)->to(ItemForm::class);
    }

    public function getBarcode($barcode)
    {
        //*call the listesner 'edit-item-from-table' galing sa ItemForm class
        //@params itemID name ng parameter na ipapasa, $supplierId parameter value na ipapasa
        $this->dispatch('get-barcode-from-table', ['Barcode' => $barcode])->to(PrintBarcodeForm::class);
    }
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
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function refreshTable()
    {
        $this->resetPage();
    }
    public function refreshFromPusher()
    {
        $this->resetPage();
    }
}
