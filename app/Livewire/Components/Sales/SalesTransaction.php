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
    public $transaction_number;
    public $search = '';
    public $selectedItems = [];

    public $selectedIndex, $isSelected, $subtotal, $grandTotal;




    // livewires
    public $showSalesTransactionHistory = false;
    public $showAdminLoginForm = false;
    public $showChangeQuantityForm = false;
    public $showPaymentForm = false;
    public $showDiscountForm = false;
    public $showWholesaleForm = false;





    public function mount()
    {
        $this->generateTransactionNumber();
    }
    public function render()
    {
        $searchTerm = trim($this->search);



        $items = Item::where('status_id', 1)
            ->whereHas('inventoryJoin', function ($query) {
                $query->where('status', 'Available')
                    ->whereNotNull('expiration_date')
                    ->orderBy('expiration_date', 'asc'); // Order by nearest expiration date
            })
            ->with(['inventoryJoin' => function ($query) {
                $query->where('status', 'Available')
                    ->whereNotNull('expiration_date')
                    ->orderBy('expiration_date', 'asc'); // Order by nearest expiration date
            }])
            ->when($searchTerm, function ($query, $searchTerm) {
                $query->where(function ($subQuery) use ($searchTerm) {
                    $subQuery->where('item_name', 'like', "%{$searchTerm}%")
                        ->orWhere('barcode', 'like', "%{$searchTerm}%");
                });
            })
            ->get();

        $this->computeSubTotal();

        return view('livewire.components.Sales.sales-transaction', [
            'items' => $items,
            'selectedItems' => $this->selectedItems,
        ]);
    }


    protected $listeners = [
        'removeRowConfirmed',
        'removeRowCancelled',
        'display-change-quantity-form' => 'displayChangeQuantityForm',
        'get-quantity' => 'getQuantity'

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
                'item_description' => $item->itemJoin->item_description,
                'vat' => $item->itemJoin->vat_amount,
                'quantity' => 1,
                'barcode' => $item->itemJoin->barcode,
                'sku_code' => $item->sku_code,
                'selling_price' => $item->selling_price,
                'total_amount' => $item->selling_price * 1,
                'current_stock_quantity' => $item->current_stock_quantity,
            ];
        }

        $this->search = '';
    }

    public function getIndex($index, $flag)
    {
        $this->reset('selectedIndex', 'isSelected');
        $this->selectedIndex = $index;
        $this->isSelected = $flag;
    }


    public function setQuantity()
    {
        if ($this->isSelected) {
            $selectedItem = $this->selectedItems[$this->selectedIndex];

            // Now you can access the attributes of the selected item
            // Example: you can pass the quantity to the ChangeQuantityForm component
            $this->showChangeQuantityForm = true;
            $this->dispatch('get-quantity', [
                'itemQuantity' => $selectedItem['quantity'],
                'current_stock_quantity' => $selectedItem['current_stock_quantity'],
                'barcode' => $selectedItem['barcode'],
                'item_name' => $selectedItem['item_name'],
                'item_description' => $selectedItem['item_description'],
            ])->to(ChangeQuantityForm::class);

            // $this->reset('selectedIndex', 'isSelected');
            // For debugging purposes, you can use dd to see all the attributes
        }
    }

    public function generateTransactionNumber()
    {
        $randomNumber = random_int(0, 9999);
        $formattedNumber = str_pad($randomNumber, 4, '0', STR_PAD_LEFT);
        $this->transaction_number = 'TN-' . $formattedNumber . '-' . now()->format('dmY');
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
    public function getQuantity($newQuantity)
    {

        $this->selectedItems[$this->selectedIndex]['quantity'] = $newQuantity;
        $this->selectedItems[$this->selectedIndex]['total_amount'] = $this->selectedItems[$this->selectedIndex]['selling_price'] * $newQuantity;
        $this->reset('selectedIndex', 'isSelected');
    }


    public function computeSubTotal()
    {

        $this->subtotal = 0;
        foreach ($this->selectedItems as $index) {
            $this->subtotal += $index['total_amount'];
            $this->grandTotal = $this->subtotal;
        }
    }












    public function removeRowConfirmed()
    {
        unset($this->selectedItems[$this->selectedIndex]);
        $this->selectedItems = array_values($this->selectedItems);
        $this->reset('selectedIndex', 'isSelected');

        $this->alert('success', 'quantity was removed successfully');
    }

    public function removeRowCancelled()
    {
        $this->reset('selectedIndex', 'isSelected');
    }

    public function resetFormWhenClosed()
    {
        $this->reset('selectedIndex', 'isSelected');
    }
















    public function displayChangeQuantityForm($showChangeQuantityForm)
    {
        $this->showChangeQuantityForm = $showChangeQuantityForm;
    }


    public function displaySalesTransactionHistory()
    {
        $this->dispatch('display-sales-transaction-history', showSalesTransactionHistory: true)->to(CashierPage::class);
    }

    public function displayDiscountForm()
    {
        $this->showDiscountForm = true;
    }

    public function displayWholesaleForm()
    {
        $this->showWholesaleForm = true;
    }

    public function displayPaymentForm()
    {
        $this->showPaymentForm = true;
    }
}
