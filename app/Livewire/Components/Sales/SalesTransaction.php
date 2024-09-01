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

    public $selectedIndex, $isSelected, $subtotal, $grandTotal, $discount, $totalVat, $discount_percent, $discount_amount;

    public $customerDetails = [];


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

        // Fetch items with their inventoryJoin
        $items = Item::where('status_id', 1)
            ->whereHas('inventoryJoin', function ($query) {
                $query->where('status', 'Available');
            })
            ->when($searchTerm, function ($query, $searchTerm) {
                $query->where(function ($subQuery) use ($searchTerm) {
                    $subQuery->where('item_name', 'like', "%{$searchTerm}%")
                        ->orWhere('barcode', 'like', "%{$searchTerm}%");
                });
            })
            ->with('inventoryJoin') // Ensure inventoryJoin is eager-loaded
            ->get();

        // Process each item
        $items = $items->map(function ($item) {
            // Filter and sort inventoryJoin based on shelf_life_type
            if ($item->shelf_life_type === 'Perishable') {
                // Sort by expiration_date to find the nearest expiration date
                $sortedInventory = $item->inventoryJoin->filter(function ($inventory) {
                    return !is_null($inventory->expiration_date);
                })->sortBy('expiration_date');

                $item->inventoryJoin = $sortedInventory->first();
            } else {
                // For non-perishable items, get the latest inventory entry
                $sortedInventory = $item->inventoryJoin->sortByDesc('created_at');
                $item->inventoryJoin = $sortedInventory->first();
            }
            return $item;
        });

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
        'get-quantity' => 'getQuantity',
        'get-customer-details' => 'getCustomerDetails'

    ];

    public function selectItem($item_id)
    {

        // Retrieve the item to check its shelf_life_type
        $itemData = Item::find($item_id);

        // Build the query for inventory
        $itemQuery = Inventory::with('itemJoin')
            ->where('item_id', $item_id)
            ->where('status', 'Available')
            ->whereHas('itemJoin', function ($query) {
                $query->where('status_id', 1);
            });

        // Apply ordering if the item is perishable
        if ($itemData && $itemData->shelf_life_type === 'Perishable') {
            $itemQuery->orderBy('expiration_date', 'asc');
        }

        // Get the first item from the query
        $item = $itemQuery->first();


        $itemExists = false;

        foreach ($this->selectedItems as $index => $selectedItem) {
            if ($selectedItem['item_name'] === $item->itemJoin->item_name) {

                $itemExists = true;
                // Update the quantity if the item already exists
                $this->selectedItems[$index]['quantity'] += 1;
                $this->selectedItems[$index]['total_amount'] = $this->selectedItems[$index]['selling_price'] * $this->selectedItems[$index]['quantity'];


                if ($this->selectedItems[$index]['quantity'] >= $this->selectedItems[$index]['bulk_quantity']) {
                    $this->selectedItems[$index]['discount'] = 10;

                    $discounted_amount = $this->selectedItems[$index]['total_amount'] * ($this->selectedItems[$index]['discount'] / 100);
                    $this->selectedItems[$index]['total_amount'] = $this->selectedItems[$index]['total_amount'] -  $discounted_amount;
                }



                break;
            }
        }


        // If the item does not exist, add it to the array
        if (!$itemExists) {
            $this->selectedItems[] = [
                'item_name' => $item->itemJoin->item_name,
                'item_description' => $item->itemJoin->item_description,
                'vat_type' => $item->itemJoin->vat_type,
                'vat' => $item->vat_amount,
                'quantity' => 1,
                'barcode' => $item->itemJoin->barcode,
                'sku_code' => $item->sku_code,
                'selling_price' => $item->selling_price,
                'total_amount' => $item->selling_price * 1,
                'current_stock_quantity' => $item->current_stock_quantity,
                'bulk_quantity' => $item->itemJoin->bulk_quantity,
                'discount' => 0,
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

        if ($this->selectedItems[$this->selectedIndex]['quantity'] >= $this->selectedItems[$this->selectedIndex]['bulk_quantity']) {
            $this->selectedItems[$this->selectedIndex]['discount'] = 10;

            $discounted_amount = $this->selectedItems[$this->selectedIndex]['total_amount'] * ($this->selectedItems[$this->selectedIndex]['discount'] / 100);
            $this->selectedItems[$this->selectedIndex]['total_amount'] = $this->selectedItems[$this->selectedIndex]['total_amount'] -  $discounted_amount;
        }

        $this->reset('selectedIndex', 'isSelected');
    }


    public function computeSubTotal()
    {

        $this->subtotal = 0;
        $vaTableAmount = 12;
        $this->discount_percent =  0;
        $this->discount_amount = 0;

        foreach ($this->selectedItems as $index) {

            $this->subtotal += $index['total_amount'];

            if ($index['vat_type'] === 'VaTable') {
                $netAmount =   $this->subtotal / (100 + $vaTableAmount) * 100;

                $this->totalVat = $this->subtotal - $netAmount;
            }

            if ($this->customerDetails) {

                $this->discount_percent = $this->customerDetails['discount_percentage'];

                $discount = $this->subtotal / (100 + $this->customerDetails['discount_percentage']) * 100;
                $this->discount_amount = $this->subtotal - $discount;
            }

            $this->grandTotal = $this->subtotal - $this->discount_amount ;
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

    public function getCustomerDetails($customerDetails)
    {
        $this->customerDetails = $customerDetails;
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
