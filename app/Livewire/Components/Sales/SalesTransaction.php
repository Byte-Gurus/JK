<?php

namespace App\Livewire\Components\Sales;

use App\Events\CreditEvent;

use App\Events\CustomerEvent;
use App\Events\InventoryEvent;
use App\Events\ItemEvent;
use App\Events\PurchaseOrderEvent;
use App\Events\TransactionEvent;
use App\Livewire\Components\Navbar;
use App\Livewire\Pages\CashierPage;
use App\Models\Address;
use App\Models\Credit;
use App\Models\CreditHistory;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\Item;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\PurchaseDetails;
use App\Models\ReturnDetails;
use App\Models\Returns;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use App\Models\TransactionMovement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use function PHPUnit\Framework\isNull;

class SalesTransaction extends Component
{
    use LivewireAlert;
    public $transaction_number;

    public $search = '';
    public $selectedItems = [];
    public $payment = [];

    public $selectedIndex,
    $isSelected,
    $subtotal,
    $grandTotal,
    $discount,
    $totalVat,
    $discount_percent,
    $PWD_Senior_discount_amount,
    $discount_type,
    $customer_name,
    $senior_pwd_id,
    $tendered_amount,
    $change,
    $original_total,
    $netAmount,
    $discounts,
    $wholesale_discount_amount,
    $credit_no,
    $searchCustomer,
    $creditor_name,
    $transaction_info,
    $credit_limit,
    $changeTransactionType = 1,
    $receiptData = [],
    $unableShortcut = false,
    $search_return_number,
    $exchange_amount,
    $returnInfo,
    $return_number,
    $excess_amount;
    public $tax_details = [];
    public $credit_details = [];
    public $customerDetails = [];
    public $barcode;

    // livewires
    public $showSalesTransaction = true;
    public $showSalesTransactionHistory = false;
    public $showAdminLoginForm = false;
    public $showChangeQuantityForm = false;
    public $showPaymentForm = false;
    public $showDiscountForm = false;
    public $showWholesaleForm = false;
    public $showSalesReceipt = false;

    public $si = [];

    public function mount()
    {
        $this->generateTransactionNumber();
        $this->selectedItems = [];
    }
    public function render()
    {


        $this->discounts = Discount::whereIn('id', [1, 2, 3])
            ->get()
            ->keyBy('id');

        $searchTerm = trim($this->search);
        $searchCustomerTerm = trim($this->searchCustomer);

        $credit_customers = Customer::where(function ($query) use ($searchCustomerTerm) {
            $searchCustomerTermLower = strtolower($searchCustomerTerm); // Convert search term to lowercase

            $query
                ->whereRaw('LOWER(firstname) LIKE ?', ['%' . $searchCustomerTermLower . '%'])
                ->orWhereRaw('LOWER(middlename) LIKE ?', ['%' . $searchCustomerTermLower . '%'])
                ->orWhereRaw('LOWER(lastname) LIKE ?', ['%' . $searchCustomerTermLower . '%']);
        })
            ->whereHas('creditJoin', function ($query) {
                $query->where('status', '!=', 'Fully paid')->doesntHave('transactionJoin');
            })
            ->get();

        // Fetch items with their inventoryJoin
        $items = Item::where('status_id', 1)
            ->whereHas('inventoryJoin', function ($query) {
                $query->where('status', 'Available')
                    ->where('current_stock_quantity', '>', 0);
            })
            ->when($searchTerm, function ($query, $searchTerm) {
                $searchTermLower = strtolower($searchTerm); // Convert search term to lowercase

                $query->where(function ($subQuery) use ($searchTermLower) {
                    $subQuery->whereRaw('LOWER(item_name) LIKE ?', ['%' . $searchTermLower . '%'])->orWhereRaw('LOWER(barcode) LIKE ?', ['%' . $searchTermLower . '%']);
                });
            })
            ->with([
                'inventoryJoin' => function ($query) {
                    $query->where('status', 'Available')
                        ->where('current_stock_quantity', '>', 0); // Ensure only 'Available' inventory is eager-loaded
                },
            ])
            ->get();

        // Process each item
        $items = $items->map(function ($item) {
            // Filter and sort inventoryJoin based on shelf_life_type
            $availableInventory = $item->inventoryJoin->filter(function ($inventory) {
                return $inventory->status === 'Available'; // Ensure only available items are considered
            });

            if ($item->shelf_life_type === 'Perishable') {
                // Sort by expiration_date to find the nearest expiration date
                $sortedInventory = $availableInventory
                    ->filter(function ($inventory) {
                        return !is_null($inventory->expiration_date);
                    })
                    ->sortBy(function ($inventory) {
                        return [$inventory->expiration_date, $inventory->current_stock_quantity];
                    });
                $item->inventoryJoin = $sortedInventory->first();
            } else {
                // For non-perishable items, get the latest inventory entry
                $sortedInventory = $availableInventory->sortBy('created_at');
                $item->inventoryJoin = $sortedInventory->first();
            }
            return $item;
        });

        $this->computeTransaction();

        return view('livewire.components.Sales.sales-transaction', [
            'items' => $items,
            'selectedItems' => $this->selectedItems,
            'credit_customers' => $credit_customers,
        ]);
    }

    public function selectCustomer($creditor_id)
    {
        $credit = Credit::where('customer_id', $creditor_id)->first();

        if ($credit->credit_limit <= $this->grandTotal) {
            $this->alert('error', 'Creditor reached the credit limit');
            $this->searchCustomer = '';
            return;
        }

        $this->creditor_name = $credit->customerJoin->firstname . ' ' . ($credit->customerJoin->middlename ? $credit->customerJoin->middlename . ' ' : '') . $credit->customerJoin->lastname;

        $this->credit_no = $credit->credit_number;
        $this->credit_limit = $credit->credit_limit;
        $this->discount_type = $credit->customerJoin->customer_type;
        $this->senior_pwd_id = $credit->customerJoin->senior_pwd_id ?? 'N/A';

        $this->credit_details = [
            'customer_id' => $creditor_id,
            'credit_no' => $this->credit_no,
            'credit_id' => $credit->id,
            'creditor_name' => $this->creditor_name,
            'credit_limit' => $this->credit_limit,
            'senior_pwd_id' => $credit->customerJoin->senior_pwd_id ?? 'N/A',
            'discount_type' => $credit->customerJoin->customer_type,
        ];

        $this->dispatch('get-credit-detail', creditDetail: $this->credit_details)->to(DiscountForm::class);
        $this->searchCustomer = '';
    }

    protected $listeners = ['removeRowConfirmed', 'removeRowCancelled', 'cancelConfirmed', 'display-change-quantity-form' => 'displayChangeQuantityForm', 'display-sales-transaction' => 'displaySalesTransaction', 'display-discount-form' => 'displayDiscountForm', 'display-payment-form' => 'displayPaymentForm', 'get-quantity' => 'getQuantity', 'get-customer-details' => 'getCustomerDetails', 'get-customer-payments' => 'getCustomerPayments', 'unselect-item' => 'unselectItem', 'display-sales-receipt' => 'displaySalesReceipt'];

    public function unselectItem()
    {
        $this->isSelected = false;
    }

    public function selectItem($item_id = null)
    {
        if ($this->payment) {
            $this->alert('error', 'Transaction is paid');
            return;
        }

        if ($this->changeTransactionType == 3 && !$this->returnInfo) {
            $this->alert('error', 'Enter return number first');
            return;
        }

        $itemExists = false;
        // Retrieve the item to check its shelf_life_type
        if ($item_id) {
            $itemData = Item::find($item_id);
        } else {
            $this->barcode = substr($this->barcode, 0, -1);
            $itemData = Item::where('barcode', $this->barcode)->first();

        }

        if ($itemData) {
            // Build the query for inventory
            $itemQuery = Inventory::with('itemJoin')
                ->where('item_id', $item_id ?? $itemData->id)
                ->where('status', 'Available')
                ->whereHas('itemJoin', function ($query) {
                    $query->where('status_id', 1);
                });

            // Apply ordering if the item is perishable
            if ($itemData && $itemData->shelf_life_type === 'Perishable') {
                $itemQuery->orderBy('expiration_date', 'asc')
                    ->orderBy('current_stock_quantity', 'asc');
            }

            // Get the first item from the query
            $item = $itemQuery->first();
            // dd($item);

            foreach ($this->selectedItems as $index => $selectedItem) {
                if ($selectedItem['sku_code'] === $item->sku_code) {
                    if ($selectedItem['selling_price'] + $this->grandTotal > $this->credit_limit && $this->credit_details) {
                        $this->alert('error', 'Credit limit reached');
                        return;
                    }

                    if ($selectedItem['quantity'] >= $selectedItem['current_stock_quantity']) {
                        $this->alert('error', 'Current stock is depleted');
                        return;
                    }

                    $itemExists = true;
                    // Update the quantity if the item already exists
                    $this->selectedItems[$index]['quantity'] += 1;
                    $this->selectedItems[$index]['total_amount'] = $this->selectedItems[$index]['selling_price'] * $this->selectedItems[$index]['quantity'];

                    if ($this->selectedItems[$index]['quantity'] >= $this->selectedItems[$index]['bulk_quantity'] && $this->selectedItems[$index]['bulk_quantity'] >= 2) {
                        $this->selectedItems[$index]['discount'] = $this->discounts[3]->percentage;
                        $this->selectedItems[$index]['discount_id'] = $this->discounts[3]->id;

                        $this->selectedItems[$index]['original_total'] = $this->selectedItems[$index]['total_amount'];

                        $this->selectedItems[$index]['wholesale_discount_amount'] = $this->selectedItems[$index]['total_amount'] * ($this->selectedItems[$index]['discount'] / 100);

                        $this->selectedItems[$index]['total_amount'] = $this->selectedItems[$index]['total_amount'] - $this->selectedItems[$index]['wholesale_discount_amount'];
                    }

                    break;
                }
            }

            // If the item does not exist, add it to the array
            if (!$itemExists) {
                $this->selectedItems[] = [
                    'item_id' => $item->itemJoin->id,
                    'item_name' => $item->itemJoin->item_name,
                    'item_description' => $item->itemJoin->item_description,
                    'vat_type' => $item->itemJoin->vat_type,
                    'reorder_point' => $item->itemJoin->reorder_point,
                    'vat' => $item->vat_amount,
                    'vat_percent' => $item->itemJoin->vat_percent,
                    'quantity' => 1,
                    'barcode' => $item->itemJoin->barcode,
                    'sku_code' => $item->sku_code,
                    'selling_price' => $item->selling_price,
                    'total_amount' => $item->selling_price * 1,
                    'current_stock_quantity' => $item->current_stock_quantity,
                    'bulk_quantity' => $item->itemJoin->bulk_quantity,
                    'wholesale_discount_amount' => 0,
                    'status' => 'Sales',
                    'discount' => 0,
                    'discount_id' => null,
                    'original_total' => 0,
                    'delivery_date' => $item->deliveryJoin->date_delivered,
                    'po_date' => $item->deliveryJoin->purchaseJoin->created_at,
                ];
                $this->isSelected = true;
                $this->selectedIndex = count($this->selectedItems) - 1;
                $this->setQuantity();

            }
        } else {
            $this->alert('warning', 'Cant recognize the barcode');
        }
        $this->barcode = '';
        $this->search = '';
    }

    // public function getIndex($index)
    // {

    //     $this->reset('selectedIndex');
    //     $this->selectedIndex = $index;
    // }

    public function getIndex($index, $flag)
    {
        $this->reset('selectedIndex', 'isSelected');

        $this->selectedIndex = $index;
        $this->isSelected = $flag;
    }

    // public function resetSelected()
    // {
    //     $this->reset('selectedIndex', 'isSelected');

    //     $this->selectedIndex =  null;
    //     $this->isSelected = null;
    //

    public function setQuantity()
    {
        if ($this->isSelected) {
            $selectedItem = $this->selectedItems[$this->selectedIndex];

            // Now you can access the attributes of the selected item
            // Example: you can pass the quantity to the ChangeQuantityForm component
            $this->showChangeQuantityForm = true;
            $data = [
                'itemQuantity' => $selectedItem['quantity'],
                'current_stock_quantity' => $selectedItem['current_stock_quantity'],
                'barcode' => $selectedItem['barcode'],
                'item_name' => $selectedItem['item_name'],
                'item_description' => $selectedItem['item_description'],
                'selling_price' => $selectedItem['selling_price'],
                'bulk_quantity' => $selectedItem['bulk_quantity'],
                'grandTotal' => $this->grandTotal,
            ];

            if (!$this->changeTransactionType == 2) {
                $data['credit_limit'] = $this->credit_limit;
            } else {
                $data['credit_limit'] = null;
            }

            $this->dispatch('get-quantity', $data)->to(ChangeQuantityForm::class);

            // $this->reset('selectedIndex', 'isSelected');
            // For debugging purposes, you can use dd to see all the attributes
        }
    }

    public function generateTransactionNumber()
    {
        do {
            $randomNumber = random_int(0, 9999);
            $formattedNumber = str_pad($randomNumber, 4, '0', STR_PAD_LEFT);
            $transactionNumber = 'TN-' . $formattedNumber . '-' . now()->format('mdY');

            // Check if the transaction number already exists
            $exists = Transaction::where('transaction_number', $transactionNumber)->exists();
        } while ($exists);

        // Assign the unique transaction number
        $this->transaction_number = $transactionNumber;
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

        if ($this->selectedItems[$this->selectedIndex]['quantity'] >= $this->selectedItems[$this->selectedIndex]['bulk_quantity'] && $this->selectedItems[$this->selectedIndex]['bulk_quantity'] >= 2) {
            $this->selectedItems[$this->selectedIndex]['discount'] = $this->discounts[3]->percentage;
            $this->selectedItems[$this->selectedIndex]['discount_id'] = $this->discounts[3]->id;

            $this->selectedItems[$this->selectedIndex]['original_total'] = $this->selectedItems[$this->selectedIndex]['total_amount'];

            $this->selectedItems[$this->selectedIndex]['wholesale_discount_amount'] = $this->selectedItems[$this->selectedIndex]['total_amount'] * ($this->selectedItems[$this->selectedIndex]['discount'] / 100);

            $this->selectedItems[$this->selectedIndex]['total_amount'] = $this->selectedItems[$this->selectedIndex]['total_amount'] - $this->selectedItems[$this->selectedIndex]['wholesale_discount_amount'];
        }

        $this->reset('selectedIndex', 'isSelected');
    }

    public function computeTransaction()
    {
        $test = [];
        $this->subtotal = 0;

        $vatable_amount = 0;
        $vat_exempt_amount = 0;

        $vatable_subtotal = 0;
        $vat_exempt_subtotal = 0;

        $this->netAmount = 0;
        $this->discount_percent = 0;
        $this->PWD_Senior_discount_amount = 0;

        foreach ($this->selectedItems as $index) {
            $this->subtotal += $index['total_amount'];

            if ($index['vat_type'] === 'Vat') {
                $vatable_subtotal += $index['total_amount'];
                $vatable_amount = $vatable_subtotal - ($vatable_subtotal / (100 + $index['vat_percent'])) * 100;
                // dump([
                //     "vat",
                //     'vatable_subtotal' => $vatable_subtotal,
                //     'vatable_amount' => $vatable_amount,
                //     'total_amount' => $index['total_amount'],
                //     'vat_percent' => $index['vat_percent']
                // ]);
            } elseif ($index['vat_type'] === 'Vat Exempt') {
                $vat_exempt_subtotal += $index['total_amount'];
                $vat_exempt_amount = $vat_exempt_subtotal - ($vat_exempt_subtotal / (100 + $index['vat_percent'])) * 100;
                // dump([
                //     "non vat",
                //     'vat_exempt_subtotal' => $vat_exempt_subtotal,
                //     'vat_exempt_amount' => $vat_exempt_amount,
                //     'total_amount' => $index['total_amount'],
                //     'vat_percent' => $index['vat_percent']
                // ]);
            }



            $this->totalVat = $vatable_amount + $vat_exempt_amount;

            if ($this->customerDetails) {
                $this->discount_percent = $this->customerDetails['discount_percentage'];

                $this->netAmount = $this->subtotal * ($this->discount_percent / 100);
                $this->PWD_Senior_discount_amount = $this->netAmount;
            }


            if ($this->credit_details && $this->credit_details['discount_type'] !== 'Normal') {

                $this->discount_percent = $this->discounts[1]->percentage;

                $this->netAmount = $this->subtotal * ($this->discount_percent / 100);
                $this->PWD_Senior_discount_amount = $this->netAmount;
            }

            if ($this->changeTransactionType == 3 && $this->subtotal > $this->exchange_amount) {
                $this->excess_amount = $this->subtotal - $this->exchange_amount;
                $this->grandTotal = $this->excess_amount;
            } else {
                $this->grandTotal = $this->subtotal - $this->PWD_Senior_discount_amount;
            }

            // $test = [
            //     'items' => $index['item_name'],
            //     'percent' => $index['vat_percent'],
            //     'subtotal' => $this->subtotal,
            //     'vatable_subtotal' => $vatable_subtotal,
            //     'vatable_amount' => $vatable_amount,
            //     'vat_exempt_subtotal' => $vat_exempt_subtotal,
            //     'vat_exempt_amount' => $vat_exempt_amount,
            //     'netAmount' => $this->netAmount,

            // ];
        }

        $this->tax_details = [
            'vat_exempt_amount' => $vat_exempt_amount,
            'vatable_amount' => $vatable_amount,
            'total_vat' => $this->totalVat,
            'PWD_Senior_discount_amount' => $this->PWD_Senior_discount_amount,
        ];

        if (isset($this->credit_details['credit_no'])) {
            $this->credit_details['credit_amount'] = $this->grandTotal;
        }

        // dump($test);
    }

    public function getCustomerDetails($customerDetails)
    {
        if (!is_null($customerDetails)) {
            $this->customerDetails = $customerDetails;

            $this->discount_type = $this->customerDetails['customer_type'];

            if (isset($this->customerDetails['firstname'])) {
                $this->customer_name = $this->customerDetails['firstname'] . ' ' . (isset($this->customerDetails['middlename']) && $this->customerDetails['middlename'] ? $this->customerDetails['middlename'] . ' ' : '') . $this->customerDetails['lastname'];
            } else {
                $customer = Customer::find($this->customerDetails['customer_id']);
                $this->customer_name = $customer->firstname . ' ' . ($customer->middlename ? $customer->middlename . ' ' : '') . $customer->lastname;
            }

            $this->alert('success', 'Discount was applied successfully');
            $this->senior_pwd_id = $this->customerDetails['senior_pwd_id'];
        } else {
            // $this->reset('customer_name', 'senior_pwd_id', 'discount_type');

            $this->customerDetails = null;

        }
    }

    public function updatedBarcode()
    {
        $this->selectItem();
    }

    public function cancel()
    {
        $this->confirm('Do you want to cancel this transaction?', [
            'onConfirmed' => 'cancelConfirmed', //* call the confmired method
        ]);
    }

    public function cancelConfirmed()
    {
        return redirect(request()->header('Referer'));
    }

    public function updatedChangeTransactionType()
    {
        if ($this->customerDetails) {
            $this->alert('error', 'Remove discount first');
            $this->reset('changeTransactionType');
            return;
        }
        if ($this->changeTransactionType == 3) {
            $this->selectedItems = [];
            $this->reset('totalVat', 'grandTotal', 'excess_amount', 'subtotal', 'customerDetails');
        }
    }

    public function removeRowConfirmed()
    {
        $this->totalVat -= $this->tax_details['vatable_amount'] ?? 0;
        $this->grandTotal -= $this->selectedItems[$this->selectedIndex]['total_amount'] ?? 0;
        $this->excess_amount -= $this->subtotal - $this->exchange_amount ?? 0;
        unset($this->selectedItems[$this->selectedIndex]);

        $this->selectedItems = array_values($this->selectedItems);
        $this->reset('selectedIndex', 'isSelected');

        $this->alert('success', 'Item was removed successfully');
    }

    public function removeRowCancelled()
    {
        $this->reset('selectedIndex', 'isSelected');
    }

    public function resetFormWhenClosed()
    {
        $this->reset('selectedIndex', 'isSelected');
    }

    public function getCustomerPayments($Payment)
    {
        $this->payment = $Payment;

        $this->tendered_amount = $this->payment['tendered_amount'];
        $this->change = $this->tendered_amount - $this->grandTotal;

        $this->payment['change'] = $this->change;
    }

    public function save()
    {
        if (empty($this->payment) && $this->changeTransactionType != 2) {
            $this->alert('warning', 'No payment yet');
            return;
        }

        $this->receiptData = [];
        $this->transaction_info = [
            'subtotal' => $this->subtotal,
            'grandTotal' => $this->grandTotal,
            'transaction_number' => $this->transaction_number,
            'transaction_time' => now()->format('H:i A'),
            'transaction_date' => now()->format('d-m-Y'),
            'user' => Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname,
        ];

        // dd($this->payment, $this->selectedItems, $this->customerDetails ?? null, $this->tax_details ?? null, $this->credit_details ?? null, $this->transaction_info ?? null);

        if (isset($this->customerDetails['customer_id'])) {
            $customer = Customer::find($this->customerDetails['customer_id']);

            $this->customerDetails['customer'] = $customer;
        }

        DB::beginTransaction();

        try {
            if (!isset($this->customerDetails['customer_id']) && isset($this->customerDetails['firstname'])) {
                $address = Address::create([
                    'province_code' => $this->customerDetails['province_code'],
                    'city_municipality_code' => $this->customerDetails['city_municipality_code'],
                    'barangay_code' => $this->customerDetails['barangay_code'],
                    'street' => $this->customerDetails['street'],
                ]);
                $customer = Customer::create([
                    'firstname' => $this->customerDetails['firstname'],
                    'middlename' => $this->customerDetails['middlename'] ?? null,
                    'lastname' => $this->customerDetails['lastname'],
                    'contact_number' => $this->customerDetails['contact_number'],
                    'birthdate' => $this->customerDetails['birthdate'],
                    'address_id' => $address->id,
                    'customer_type' => $this->customerDetails['customer_type'],
                    'senior_pwd_id' => $this->customerDetails['senior_pwd_id'],
                    'id_picture' => 'N/A',
                ]);
            }

            $customer_id = $this->customerDetails['customer_id'] ?? ($customer->id ?? null);

            if ($this->changeTransactionType == 1 || $this->changeTransactionType == 3) {
                $transactionType = 'Sales';
            } elseif ($this->changeTransactionType == 2) {
                $transactionType = 'Credit';
            }


            if ($this->changeTransactionType == 3) {
                $exchange_and_excess_amount = $this->exchange_amount + $this->excess_amount;

                $transaction = Transaction::create([
                    'transaction_number' => $this->transaction_info['transaction_number'],
                    'transaction_type' => $transactionType,
                    'subtotal' => $this->transaction_info['subtotal'],
                    'total_amount' => $exchange_and_excess_amount,
                    'total_vat_amount' => $this->tax_details['total_vat'],
                    'total_discount_amount' => $this->tax_details['PWD_Senior_discount_amount'],
                    'excess_amount' => $this->excess_amount,
                    'discount_id' => $this->customerDetails['discount_id'] ?? null,
                    'customer_id' => $customer_id,
                    'user_id' => Auth::id(),
                ]);
            } else {
                $transaction = Transaction::create([
                    'transaction_number' => $this->transaction_info['transaction_number'],
                    'transaction_type' => $transactionType,
                    'subtotal' => $this->transaction_info['subtotal'],
                    'total_amount' => $this->transaction_info['grandTotal'],
                    'total_vat_amount' => $this->tax_details['total_vat'],
                    'total_discount_amount' => $this->tax_details['PWD_Senior_discount_amount'],
                    'discount_id' => $this->customerDetails['discount_id'] ?? null,
                    'customer_id' => $customer_id,
                    'user_id' => Auth::id(),
                ]);
            }




            if ($this->changeTransactionType == 1 || $this->changeTransactionType == 3) {
                $transaction_movement = TransactionMovement::create([
                    'transaction_type' => 'Sales',
                    'transaction_id' => $transaction->id,
                ]);
            }
            if ($this->changeTransactionType == 3) {
                $return = Returns::where('return_number', $this->return_number)->first();
                $return->hasTransaction = true;
                $return->save();
            }
            $ids = "inventory_ids:";
            foreach ($this->selectedItems as $index => $selectedItem) {
                $total_quantity_sold = $selectedItem['quantity'];

                $inventories = Inventory::where('selling_price', $selectedItem['selling_price'])
                    ->where('item_id', $selectedItem['item_id'])
                    ->where('status', 'Available')
                    ->orderBy('expiration_date', 'ASC')
                    ->get();


                foreach ($inventories as $inventory) {
                    // dd($inventory->current_stock_quantity);
                    // dd($inventory->current_stock_quantity - $total_quantity_sold >= 0 && $total_quantity_sold == $selectedItem['quantity']);
                    // dd($inventory->current_stock_quantity - $total_quantity_sold >= 0 && $total_quantity_sold != $selectedItem['quantity']);

                    if ($total_quantity_sold > 0) {
                        if (($inventory->current_stock_quantity - $total_quantity_sold) >= 0 && $total_quantity_sold == $selectedItem['quantity']) {
                            // dump('if');
                            $transactionDetails = TransactionDetails::create([
                                'item_quantity' => $selectedItem['quantity'],
                                'vat_type' => $selectedItem['vat_type'],
                                'item_subtotal' => $selectedItem['total_amount'],
                                'item_discount_amount' => $selectedItem['wholesale_discount_amount'],
                                'status' => $selectedItem['status'],
                                'discount' => $selectedItem['discount'],
                                'discount_id' => $selectedItem['discount_id'],
                                'transaction_id' => $transaction->id,
                                'item_id' => $selectedItem['item_id'],
                                'inventory_id' => $inventory->id,
                                'item_price' => $selectedItem['selling_price'],
                                'item_vat_percent' => $selectedItem['vat_percent'],
                            ]);
                            $total_quantity_sold -= $selectedItem['quantity'];
                            $inventory->current_stock_quantity -= $selectedItem['quantity'];

                            if ($inventory->current_stock_quantity == 0) {
                                $inventory->status = 'Not available';
                            }
                            $inventory->save();




                        } elseif (($inventory->current_stock_quantity - $total_quantity_sold) >= 0) {

                            // dump('elseif');
                            $transactionDetails = TransactionDetails::create([
                                'item_quantity' => $total_quantity_sold,
                                'vat_type' => $selectedItem['vat_type'],
                                'item_subtotal' => $this->calculateSubtotal($selectedItem['selling_price'], $total_quantity_sold, $selectedItem['discount']),
                                'item_discount_amount' => $this->calculateWholeSaleDiscount($selectedItem['selling_price'], $total_quantity_sold, $selectedItem['discount']),
                                'status' => $selectedItem['status'],
                                'discount' => $selectedItem['discount'],
                                'discount_id' => $selectedItem['discount_id'],
                                'transaction_id' => $transaction->id,
                                'item_id' => $selectedItem['item_id'],
                                'inventory_id' => $inventory->id,
                                'item_price' => $selectedItem['selling_price'],
                                'item_vat_percent' => $selectedItem['vat_percent'],
                            ]);

                            $inventory->current_stock_quantity -= $total_quantity_sold;
                            $total_quantity_sold -= $total_quantity_sold;

                            if ($inventory->current_stock_quantity == 0) {
                                $inventory->status = 'Not available';
                            }
                            $inventory->save();



                        } else {
                            // dump('else');
                            $transactionDetails = TransactionDetails::create([
                                'item_quantity' => $inventory->current_stock_quantity,
                                'vat_type' => $selectedItem['vat_type'],
                                'item_subtotal' => $this->calculateSubtotal($selectedItem['selling_price'], $inventory->current_stock_quantity, $selectedItem['discount']),
                                'item_discount_amount' => $this->calculateWholeSaleDiscount($selectedItem['selling_price'], $inventory->current_stock_quantity, $selectedItem['discount']),
                                'status' => $selectedItem['status'],
                                'discount' => $selectedItem['discount'],
                                'discount_id' => $selectedItem['discount_id'],
                                'transaction_id' => $transaction->id,
                                'item_id' => $selectedItem['item_id'],
                                'inventory_id' => $inventory->id,
                                'item_price' => $selectedItem['selling_price'],
                                'item_vat_percent' => $selectedItem['vat_percent'],
                            ]);
                            $total_quantity_sold -= $inventory->current_stock_quantity;
                            $inventory->current_stock_quantity -=
                                $inventory->current_stock_quantity;

                            if ($inventory->current_stock_quantity == 0) {
                                $inventory->status = 'Not available';
                            }
                            $inventory->save();

                            // dump($inventory->current_stock_quantity);
                        }
                        //append inventory id
                        $ids .= $inventory->id . ',';
                        $inventory_movements = InventoryMovement::create([
                            'transaction_detail_id' => $transactionDetails->id,
                            'movement_type' => 'Sales',
                            'operation' => 'Stock out',
                        ]);

                        $this->getReorderPoint($selectedItem['item_id'], $selectedItem['delivery_date'], $selectedItem['po_date']);

                        $this->getMaximumLevel($selectedItem['delivery_date'], $selectedItem['po_date'], $selectedItem['sku_code']);
                    }

                    if ($inventory->current_stock_quantity <= $inventory->itemJoin->reorder_point) {
                        $notificationExists = Notification::where('description', "Item with SKU {$inventory->sku_code} has reached the reorder point.")->exists();

                        if (!$notificationExists) {
                            Notification::create([
                                'description' => "Item with SKU {$inventory->sku_code} has reached the reorder point.",
                                'inventory_id' => $inventory->id,
                            ]);
                        }
                    }
                }

            }


            if ($this->changeTransactionType == 1 || $this->changeTransactionType == 3) {
                $payment = Payment::create([
                    'transaction_id' => $transaction->id,
                    'amount' => $this->payment['tendered_amount'],
                    'tendered_amount' => $this->payment['tendered_amount'],
                    'reference_number' => $this->payment['reference_no'] ?? 'N/A',
                    'payment_type' => $this->payment['payment_type'],
                ]);
            } elseif ($this->changeTransactionType == 2) {
                $credit = Credit::where('credit_number', $this->credit_no)->first();
                $credit->credit_amount = $this->grandTotal;
                $credit->remaining_balance = $this->grandTotal;
                $credit->transaction_id = $transaction->id;
                $credit->save();

                $creditHistory = CreditHistory::create([
                    'description' => 'Issuance of credit',
                    'credit_id' => $credit->id,
                    'credit_amount' => $this->grandTotal,
                    'remaining_balance' => $this->grandTotal,
                ]);

                $transaction_movement = TransactionMovement::create([
                    'transaction_type' => 'Credit',
                    'credit_id' => $credit->id,
                ]);
            }



            DB::commit();

            CreditEvent::dispatch('refresh-credit');

            $this->alert('success', 'New Transaction saved successfully');
            $this->dispatch(
                'print-sales-receipt',
                array_merge($this->receiptData, [
                    'return_details' => $this->returnInfo ?? null,
                    'transaction_type' => $this->changeTransactionType,
                    'payment' => $this->payment,
                    'selectedItems' => $this->selectedItems,
                    'customerDetails' => $this->customerDetails ?? null,
                    'tax_details' => $this->tax_details,
                    'transaction_info' => $this->transaction_info,
                    'credit_details' => $this->credit_details ?? null,
                ]),
            )->to(SalesReceipt::class);

            TransactionEvent::dispatch('refresh-transaction');

            ItemEvent::dispatch('refresh-item');
            InventoryEvent::dispatch('refresh-inventory');
            PurchaseOrderEvent::dispatch('refresh-purchase-order');
            CustomerEvent::dispatch('refresh-customer');

            $this->dispatch('display-sales-receipt', showSalesReceipt: true)->to(CashierPage::class);
            $this->unableShortcut = true;
        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            DB::rollback();
            $this->alert('error', 'An error occurred while creating transaction, please refresh the page');
        }
    }

    public function getReorderPoint($item_id, $delivery_date, $po_date)
    {
        $reorer_requirements = [];
        $deliveryDate = Carbon::parse($delivery_date);
        $poDate = Carbon::parse($po_date);

        // Define the start and end dates
        $startDate = $poDate->startOfDay();
        $endDate = $deliveryDate->endOfDay();

        $startOfDay = Carbon::today()->startOfDay();
        $endOfDay = Carbon::today()->endOfDay();

        $daysWithSales = TransactionDetails::where('item_id', $item_id)->distinct(DB::raw('DATE(created_at)'))->count(DB::raw('distinct DATE(created_at)'));

        $todayTotalItemQuantity = TransactionDetails::where('item_id', $item_id)
            ->whereHas('transactionJoin', function ($query) use ($startOfDay, $endOfDay) {
                $query->whereBetween('created_at', [$startOfDay, $endOfDay]);
            })
            ->sum('item_quantity');

        // Calculate the number of days in the date range
        $days = round($startDate->diffInDays($endDate));
        if ($days <= 0) {
            $days = 1;
        }
        // dd($totalQuantity);

        // Calculate the demand rate
        $demandRate = $todayTotalItemQuantity / $daysWithSales;

        $reorder_point = round($demandRate * $days);

        $reorder_requirements[] = [
            'reorder_point' => $reorder_point,
            'demandRate' => $demandRate,
            'daysDIff' => $days,
            'todayTotalItemQuantity' => $todayTotalItemQuantity,
            'daysWithSales' => $daysWithSales,
            'deliveryDate' => $deliveryDate,
            'poDate' => $poDate,
        ];

        $item = Item::find($item_id);
        $item->reorder_point = $reorder_point;
        $item->save();
    }
    public function getMaximumLevel($delivery_date, $po_date, $sku_code)
    {
        $maximum_level_req = [];

        $delivery_date = Carbon::parse($delivery_date);

        $po_date = Carbon::parse($po_date);

        // reorder quantity = Average sales / average lead time
        $item_info = Inventory::where('sku_code', $sku_code)->first();

        $first_stock_in_date = $item_info->stock_in_date;

        $startDate = $first_stock_in_date->startOfDay();
        $endDateToday = Carbon::today()->endOfDay();

        $average_sales = transactionDetails::whereHas('transactionJoin', function ($query) use ($startDate, $endDateToday) {
            $query->whereBetween('created_at', [$startDate, $endDateToday]);
        })->sum('item_quantity');

        $average_lead_time = (int) $po_date->diffInDays($delivery_date);

        if ($average_lead_time == 0) {
            $average_lead_time = 1;
        }

        $reorder_quantity = $average_sales / $average_lead_time;

        //minimum consumption = daily sales / days of sales
        $daily_sales = TransactionDetails::where('item_id', $item_info->item_id)
            ->whereBetween('created_at', [$delivery_date, $endDateToday])
            ->sum('item_quantity');

        $days_of_sale = (int) $delivery_date->diffInDays($endDateToday);

        if ($days_of_sale == 0) {
            $days_of_sale = 1;
        }
        $minimum_consumption = $daily_sales / $days_of_sale;

        // minimum lead time = order delivered - order placed
        $item = Item::with(['purchaseDetailsJoin.purchaseJoin.deliveryJoin'])->find($item_info->item_id);

        $purchaseDetails = $item->purchaseDetailsJoin;

        $minimum_lead_time = $purchaseDetails
            ->flatMap(function ($purchaseDetail) {
                // Ensure delivery is a single instance or null
                $delivery = $purchaseDetail->purchaseJoin->deliveryJoin;

                // Initialize minReorderPeriod as null
                $reorderPeriods = [];

                // Check if delivery and purchase dates are valid
                if ($delivery && $delivery->date_delivered && $purchaseDetail->purchaseJoin->created_at) {
                    try {
                        $deliveryDate = Carbon::parse($delivery->date_delivered);
                        $purchaseDate = Carbon::parse($purchaseDetail->purchaseJoin->created_at);
                        // Calculate the difference in days if both dates are valid
                        $reorderPeriods[] = $purchaseDate->diffInDays($deliveryDate);
                    } catch (\Exception $e) {
                        // Ignore invalid date parsing
                    }
                }

                return $reorderPeriods;
            })
            ->min();

        //maximum level = reorder quantity + reorder point - [minimum consumption * minimum lead time]

        $maximum_level = round($reorder_quantity + $item->reorder_point - $minimum_consumption * $minimum_lead_time);

        Item::where('id', $item_info->item_id)->update(['maximum_stock_level' => $maximum_level]);

        $maximum_level_req = [
            'delivery_date' => $delivery_date,
            'po_date' => $po_date,
            'reorder_quantity' => $reorder_quantity,
            'item_info' => $item_info,
            'first_stock_in_date' => $first_stock_in_date,
            'startDate' => $startDate,
            'endDateToday' => $endDateToday,
            'average_sales' => $average_sales,
            'average_lead_time' => $average_lead_time,
            'minimum_consumption' => $minimum_consumption,
            'daily_sales' => $daily_sales,
            'days_of_sale' => $days_of_sale,
            'minimum_lead_time' => $minimum_lead_time,
            'maximum_level' => $maximum_level,
            'reorder_point' => $item->reorder_point,
        ];

        // dd($maximum_level_req);
    }
    public function calculateSubtotal($selling_price, $quantity, $discount)
    {
        $subTotal = $selling_price * $quantity;
        $subTotal = $subTotal - ($subTotal * ($discount / 100));
        return $subTotal;
    }
    public function calculateWholeSaleDiscount($selling_price, $quantity, $discount)
    {
        $discount_amt = $selling_price * $quantity;
        $discount_amt = $discount_amt * ($discount / 100);
        return $discount_amt;
    }
    public function calculateVat($selling_price, $quantity, $discount, $vat_percent)
    {
        $subTotal = $selling_price * $quantity;
        $subTotal = $subTotal - ($subTotal * ($discount / 100));
        $vat = $subTotal * $vat_percent / 100;
        return $vat;
    }

    // public function getMaximumLevel($delivery_date, $po_date, $item_id, )
    // {
    //     $maximum_level_req = [];

    //     $deliveryDate = Carbon::parse($delivery_date);
    //     $poDate = Carbon::parse($po_date);

    //     // Define the start and end dates
    //     $startDate = $poDate->startOfDay();
    //     $endDate = $deliveryDate->endOfDay();

    //     $startOfDay = Carbon::today()->startOfDay();
    //     $endOfDay = Carbon::today()->endOfDay();

    //     // $daysWithSales = TransactionDetails::where('item_quantity', '>', 0)
    //     //     ->distinct()
    //     //     ->get([TransactionDetails::raw('DATE(created_at) as sale_date')])
    //     //     ->count();

    //     $todayTotalItemQuantity = TransactionDetails::whereHas('transactionJoin', function ($query) use ($startOfDay, $endOfDay) {
    //         $query->whereBetween('created_at', [$startOfDay, $endOfDay]);
    //     })->sum('item_quantity');

    //     // Calculate the number of days in the date range
    //     $days = floor($startDate->diffInDays($endDate));
    //     // dd($totalQuantity);

    //     $restockDate = Inventory::where('item_id', $item_id)
    //         ->orderBy('stock_in_date', 'desc')
    //         ->value('stock_in_date');

    //     // Calculate the date range from the same day last week to today
    //     $startRestockDate = Carbon::parse($restockDate)->startOfDay()->toDateTimeString();
    //     $endCurrentDate = Carbon::now()->endOfDay()->toDateTimeString();

    //     // Calculate minimum consumption within the period
    //     $minQuantity = TransactionDetails::where('item_id', $item_id)
    //         ->whereBetween('created_at', [$startRestockDate, $endCurrentDate])
    //         ->min('item_quantity');

    //     // $isMySQL = Schema::getConnection()->getDriverName() === 'mysql';

    //     $item = Item::with(['purchaseDetailsJoin.purchaseJoin.deliveryJoin'])
    //         ->find($item_id);

    //     $purchaseDetails = $item->purchaseDetailsJoin;

    //     $minReorderPeriod = $purchaseDetails->flatMap(function ($purchaseDetail) {
    //         // Ensure delivery is a single instance or null
    //         $delivery = $purchaseDetail->purchaseJoin->deliveryJoin;

    //         // Initialize minReorderPeriod as null
    //         $reorderPeriods = [];

    //         // Check if delivery and purchase dates are valid
    //         if ($delivery && $delivery->date_delivered && $purchaseDetail->purchaseJoin->created_at) {
    //             try {
    //                 $deliveryDate = Carbon::parse($delivery->date_delivered);
    //                 $purchaseDate = Carbon::parse($purchaseDetail->purchaseJoin->created_at);
    //                 // Calculate the difference in days if both dates are valid
    //                 $reorderPeriods[] = $purchaseDate->diffInDays($deliveryDate);
    //             } catch (\Exception $e) {
    //                 // Ignore invalid date parsing
    //             }
    //         }

    //         return $reorderPeriods;
    //     })->min();

    //     // Calculate maximum level using the formula
    //     $reorderPoint = $item['reorder_point'];
    //     $reorderQuantity = round($todayTotalItemQuantity / $days);
    //     $minConsumption = $minQuantity ?? 0;
    //     $minReorderPeriod = $minReorderPeriod = $minReorderPeriod !== null ? (int) $minReorderPeriod : 0;

    //     $maximumLevel = $reorderPoint + $reorderQuantity - ($minConsumption * $minReorderPeriod);

    //     Item::where('id', $item_id)->update(['maximum_stock_level' => $maximumLevel]);

    //     $maximum_level_req[] = [
    //         'days' => $days,
    //         'po_date' => $poDate,
    //         'delivery_date' => $deliveryDate,
    //         'item_id' => $item_id,
    //         'item_name' => $item->item_name,
    //         'min_quantity' => $minConsumption,
    //         'purchase_quantity' => $reorderQuantity,
    //         'reorder_point' => $reorderPoint,
    //         'min_reorder_period' => $minReorderPeriod,
    //         'maximum_level' => $maximumLevel,
    //         'todayTotalItemQuantity' => $todayTotalItemQuantity,
    //         'restockDate' => $restockDate
    //     ];

    //     dump($maximum_level_req);
    // }

    public function clearSelectedCustomerName()
    {
        $this->reset('creditor_name', 'credit_no', 'credit_limit', 'credit_details', 'senior_pwd_id', 'discount_type');
    }

    public function clearSelectedReturnNo()
    {
        $this->reset('return_number');
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
        $this->showDiscountForm = !$this->showDiscountForm;
    }

    public function displayWholesaleForm()
    {
        $this->showWholesaleForm = true;
    }

    public function displayPaymentForm()
    {
        $this->showPaymentForm = !$this->showPaymentForm;
        $this->dispatch('get-grand-total', GrandTotal: $this->grandTotal)->to(PaymentForm::class);
    }

    public function displaySalesReturn()
    {
        $this->dispatch('display-sales-return', showSalesReturn: true)->to(CashierPage::class);
    }

    public function displaySalesReceipt()
    {
        $this->dispatch('display-sales-receipt', showSalesReceipt: true)->to(CashierPage::class);
    }

    public function focusInput()
    {
        $this->dispatch('barcode_focus');
    }

    public function getReturnDetails()
    {
        $rules = [
            'search_return_number' => 'required',
        ];
        $this->validate($rules);

        $this->returnInfo = Returns::where('return_number', $this->search_return_number)->first();



        if (!$this->returnInfo) {
            $this->alert('error', 'The return number does not exist.');
            return;
        }

        if ($this->returnInfo->hasTransaction) {
            $this->alert('error', 'The return number has already have a transaction.');
            return;
        }
        $exchangeCount = ReturnDetails::where('return_id', $this->returnInfo->id)
            ->where('operation', 'Exchange')
            ->count();

        if ($exchangeCount <= 0) {
            $this->alert('error', 'The return number has no exchange.');
            return;
        }
        $this->return_number = $this->returnInfo->return_number;
        $this->exchange_amount = $this->returnInfo->exchange_amount;
    }
}
