<?php

namespace App\Livewire\Components\Sales;

use App\Livewire\Pages\CashierPage;
use App\Models\Inventory;
use App\Models\Item;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SalesTransaction extends Component
{
    use LivewireAlert;
    public $search = '';
    public $selectedItems = [];
    public $selectedIndex, $isSelected;
    public $showSalesTransactionHistory = false;

    public $showChangeQuantityForm = false;

    public function render()
    {
        $searchTerm = trim($this->search);

        $items = Item::where('status_id', 1) // Ensure the item itself has status_id 1
            ->whereHas('inventoryJoin', function ($query) {
                $query->where('status', 'Available') // Ensure the related inventory status is 'Available'
                    ->whereNotNull('expiration_date'); // Optionally ensure expiration_date is not null
            })
            ->when($searchTerm, function ($query, $searchTerm) {
                $query->where(function ($subQuery) use ($searchTerm) {
                    $subQuery->where('item_name', 'like', "%{$searchTerm}%")
                        ->orWhere('barcode', 'like', "%{$searchTerm}%");
                });
            })
            ->get();
        return view('livewire.components.Sales.sales-transaction', [
            'items' => $items,
            'selectedItems' => $this->selectedItems,

        ]);
    }

    protected $listeners = [
        'removeRowConfirmed',
        'removeRowCancelled'

    ];

    public function selectItem($item_id)
    {

        $item = Inventory::with('itemJoin')
            ->where('item_id', $item_id)
            ->where('status', 'Available')

            ->whereHas('itemJoin', function ($query) {
                $query->where('status_id', 1);
            })
            ->orderBy('expiration_date', 'asc')
            ->first();

        $itemExists = false;
        foreach ($this->selectedItems as $index => $selectedItem) {
            if ($selectedItem['item_name'] === $item->itemJoin->item_name) {
                // Update the quantity if the item already exists
                $this->selectedItems[$index]['quantity'] += 1;
                $this->selectedItems[$index]['total_amount'] = $this->selectedItems[$index]['selling_price'] * $this->selectedItems[$index]['quantity'];
                $itemExists = true;
                break;
            }
        }

        // If the item does not exist, add it to the array
        if (!$itemExists) {
            $this->selectedItems[] = [
                'item_name' => $item->itemJoin->item_name,
                'vat' => $item->itemJoin->vat_amount,
                'quantity' => 1,
                'selling_price' => $item->selling_price,
                'total_amount' => $item->selling_price * 1,
            ];
        }

        $this->search = '';
    }

    public function getIndex($index, $flag)
    {
        $this->selectedIndex = $index;
        $this->isSelected = $flag;
    }

    public function displayChangeQuantityForm()
    {
        $this->showChangeQuantityForm = true;
    }

    public function setQuantity()
    {
        if ($this->selectedIndex !== null) {
            dd($this->selectedIndex);
            $this->selectedIndex = null;
        }
    }

    public function removeItem()
    {
        if ($this->isSelected) {
            $this->confirm('Do you want to remove this item?', [
                'onConfirmed' => 'removeRowConfirmed', //* call the confmired method
                'onDismissed' => 'removeRowCancelled',
            ]);
        }
    }

    public function removeRowConfirmed()
    {
        unset($this->selectedItems[$this->selectedIndex]);
        $this->selectedItems = array_values($this->selectedItems);
        $this->reset('selectedIndex', 'isSelected');
    }

    public function removeRowCancelled()
    {
        $this->reset('selectedIndex', 'isSelected');
    }


    public function displaySalesTransactionHistory()
    {
        $this->dispatch('display-sales-transaction-history', showSalesTransactionHistory: true)->to(CashierPage::class);
    }
}
