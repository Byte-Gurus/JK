<?php

namespace App\Livewire\Components\Sales;

use App\Livewire\Pages\CashierPage;
use App\Models\Address;
use App\Models\Credit;

use App\Models\CreditHistory;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\Item;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use function PHPUnit\Framework\isNull;

class SalesTransaction extends Component
{
    use LivewireAlert;
    public $transaction_number;

    public $isSales = true;
    public $search = '';
    public $selectedItems = [];
    public $payment = [];

    public $selectedIndex, $isSelected, $subtotal, $grandTotal, $discount, $totalVat, $discount_percent, $PWD_Senior_discount_amount, $discount_type, $customer_name, $customer_discount_no, $tendered_amount, $change, $original_total, $netAmount, $discounts, $wholesale_discount_amount, $credit_no, $searchCustomer, $creditor_name, $transaction_info, $credit_limit;
    public $tax_details = [];
    public $credit_details = [];
    public $customerDetails = [];
    public $barcode;

    // livewires
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
    }
    public function render()
    {



        $this->discounts = Discount::whereIn('id', [1, 2, 3])->get()->keyBy('id');



        $searchTerm = trim($this->search);
        $searchCustomerTerm = trim($this->searchCustomer);

        $credit_customers = Customer::where(function ($query) use ($searchCustomerTerm) {
            $query->where('firstname', 'like', "%{$searchCustomerTerm}%")
                ->orWhere('middlename', 'like', "%{$searchCustomerTerm}%")
                ->orWhere('lastname', 'like', "%{$searchCustomerTerm}%");
        })->whereHas('creditJoin', function ($query) {
            $query->where('status', '!=', 'Paid')
                ->doesntHave('transactionJoin');
        })->get();

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

        $this->computeTransaction();

        return view('livewire.components.Sales.sales-transaction', [
            'items' => $items,
            'selectedItems' => $this->selectedItems,
            'credit_customers' => $credit_customers
        ]);
    }


    public function changeTransactionType()
    {
        $this->isSales = !$this->isSales;
    }

    public function selectCustomer($creditor_id)
    {




        $credit = Credit::where('customer_id', $creditor_id)->first();

        if ($credit->credit_limit <= $this->grandTotal) {

            $this->alert('error', 'Creditor reached the credit limit');
            $this->searchCustomer = '';
            return;
        }

        $this->creditor_name =  $credit->customerJoin->firstname . '' . $credit->customerJoin->middlename . '' . $credit->customerJoin->lastname;
        $this->credit_no = $credit->credit_number;
        $this->credit_limit =  $credit->credit_limit;

        $this->credit_details = [
            'customer_id' => $creditor_id,
            'credit_no' =>  $this->credit_no,
            'credit_id' => $credit->id,
            'credit_limit' => $this->credit_limit
        ];

        $this->searchCustomer = '';
    }




    protected $listeners = [
        'removeRowConfirmed',
        'removeRowCancelled',
        'cancelConfirmed',
        'display-change-quantity-form' => 'displayChangeQuantityForm',
        'display-discount-form' => 'displayDiscountForm',
        'display-payment-form' => 'displayPaymentForm',
        'get-quantity' => 'getQuantity',
        'get-customer-details' => 'getCustomerDetails',
        'get-customer-payments' => 'getCustomerPayments',
        'unselect-item' => 'unselectItem',
        'display-sales-receipt' => 'displaySalesReceipt'
    ];

    public function unselectItem()
    {
        $this->isSelected = false;
    }

    public function selectItem($item_id = null)
    {


        if ($this->payment) {
            $this->alert('error', 'transaction is paid');
            return;
        }

        // if (!$this->isSales && !$this->credit_no) {
        //     $this->alert('error', 'Please select creditor');
        //     return;
        // }



        $itemExists = false;
        // Retrieve the item to check its shelf_life_type
        if ($item_id) {
            $itemData = Item::find($item_id);
        } else {
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
                $itemQuery->orderBy('expiration_date', 'asc');
            }

            // Get the first item from the query
            $item = $itemQuery->first();



            foreach ($this->selectedItems as $index => $selectedItem) {
                if ($selectedItem['item_name'] === $item->itemJoin->item_name) {


                    if ($selectedItem['selling_price'] + $this->grandTotal > $this->credit_limit && $this->credit_details) {
                        $this->alert('error', 'Credit limit reached');
                        return;
                    }

                    if ($selectedItem['quantity'] >= $selectedItem['current_stock_quantity']) {
                        $this->alert('error', 'current stock is depleted');
                        return;
                    }

                    $itemExists = true;
                    // Update the quantity if the item already exists
                    $this->selectedItems[$index]['quantity'] += 1;
                    $this->selectedItems[$index]['total_amount'] = $this->selectedItems[$index]['selling_price'] * $this->selectedItems[$index]['quantity'];


                    if ($this->selectedItems[$index]['quantity'] >= $this->selectedItems[$index]['bulk_quantity']) {
                        $this->selectedItems[$index]['discount'] =    $this->discounts[3]->percentage;
                        $this->selectedItems[$index]['discount_id'] =  $this->discounts[3]->id;


                        $this->selectedItems[$index]['original_total'] = $this->selectedItems[$index]['total_amount'];


                        $this->selectedItems[$index]['wholesale_discount_amount'] = $this->selectedItems[$index]['total_amount'] * ($this->selectedItems[$index]['discount'] / 100);

                        $this->selectedItems[$index]['total_amount'] = $this->selectedItems[$index]['total_amount'] -   $this->selectedItems[$index]['wholesale_discount_amount'];
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
                    'vat' => $item->vat_amount,
                    'quantity' => 1,
                    'barcode' => $item->itemJoin->barcode,
                    'sku_code' => $item->sku_code,
                    'selling_price' => $item->selling_price,
                    'total_amount' => $item->selling_price * 1,
                    'current_stock_quantity' => $item->current_stock_quantity,
                    'bulk_quantity' => $item->itemJoin->bulk_quantity,
                    'wholesale_discount_amount' => 0,
                    'discount' =>  0,
                    'discount_id' =>  null,
                    'original_total' => 0,
                ];
            }
        } else {
            $this->alert('warning', 'Please Wait');
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

    public function ss($index)
    {
        array_push($this->si, $index);

        if (count($this->si) == 2)
        {
            dd($this->si);
        }
    }


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
                'grandTotal' => $this->grandTotal,
            ];

            if (!$this->isSales) {
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
            $this->selectedItems[$this->selectedIndex]['discount'] =    $this->discounts[3]->percentage;
            $this->selectedItems[$this->selectedIndex]['discount_id'] =  $this->discounts[3]->id;




            $this->selectedItems[$this->selectedIndex]['original_total'] = $this->selectedItems[$this->selectedIndex]['total_amount'];

            $this->selectedItems[$this->selectedIndex]['wholesale_discount_amount'] = $this->selectedItems[$this->selectedIndex]['total_amount'] * ($this->selectedItems[$this->selectedIndex]['discount'] / 100);


            $this->selectedItems[$this->selectedIndex]['total_amount'] = $this->selectedItems[$this->selectedIndex]['total_amount'] -  $this->selectedItems[$this->selectedIndex]['wholesale_discount_amount'];
        }

        $this->reset('selectedIndex', 'isSelected');
    }


    public function computeTransaction()
    {


        $this->subtotal = 0;

        $vatable_amount = 0;
        $non_vatable_amount = 0;

        $vatable_subtotal = 0;
        $non_vatable_subtotal = 0;

        $this->netAmount = 0;
        $this->discount_percent =  0;
        $this->PWD_Senior_discount_amount = 0;



        foreach ($this->selectedItems as $index) {

            $this->subtotal += $index['total_amount'];

            if ($index['vat_type'] === 'Vat') {
                $vatable_subtotal += $index['total_amount'];
                $vatable_amount  = $vatable_subtotal - ($index['total_amount'] / (100 + 12) * 100);
            } elseif ($index['vat_type'] === 'Non Vatable') {
                $non_vatable_subtotal += $index['total_amount'];
                $non_vatable_amount  =  $non_vatable_subtotal - ($index['total_amount'] / (100 + 3) * 100);
            }

            $this->totalVat = $vatable_amount + $non_vatable_amount;

            if ($this->customerDetails) {

                $this->discount_percent = $this->customerDetails['discount_percentage'];

                $this->netAmount = $this->subtotal * ($this->discount_percent / 100);
                $this->PWD_Senior_discount_amount =  $this->netAmount;
            }

            $this->grandTotal = $this->subtotal - $this->PWD_Senior_discount_amount;
        }


        $this->tax_details = [
            'non_vatable_amount' => $non_vatable_amount,
            'vatable_amount' => $vatable_amount,
            'total_vat' =>  $this->totalVat,
            'PWD_Senior_discount_amount' =>  $this->PWD_Senior_discount_amount,
        ];

        if (isset($this->credit_details['credit_no'])) {
            $this->credit_details['credit_amount'] =  $this->grandTotal;
        }
    }

    public function getCustomerDetails($customerDetails)
    {
        if (!is_null($customerDetails)) {
            $this->customerDetails = $customerDetails;

            $this->discount_type =   $this->customerDetails['customer_type'];

            if (isset($this->customerDetails['firstname'])) {
                $this->customer_name = $this->customerDetails['firstname'] . ' ' . $this->customerDetails['middlename'] . ' ' . $this->customerDetails['lastname'];
            } else {
                $customer = Customer::find($this->customerDetails['customer_id']);
                $this->customer_name = $customer->firstname . ' ' . $customer->middlename . ' ' . $customer->lastname;
            }

            $this->alert('success', 'Discount was applied successfully');
            $this->customer_discount_no = $this->customerDetails['customer_discount_no'];
        } else {
            $this->customerDetails = null;

            $this->reset('customer_name', 'customer_discount_no', 'discount_type');
            $this->alert('success', 'Discount was removed successfully');
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












    public function removeRowConfirmed()
    {
        $this->totalVat -=  $this->tax_details['vatable_amount'];
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


    public function getCustomerPayments($Payment)
    {
        $this->payment = $Payment;

        $this->tendered_amount = $this->payment['tendered_amount'];
        $this->change = $this->tendered_amount - $this->grandTotal;

        $this->payment['change'] = $this->change;
    }




    public function save()
    {

        if (empty($this->payment) && $this->isSales) {
            $this->alert('warning', 'No payment yet');
            return;
        }

        $receiptData = [];
        $this->transaction_info = [
            'subtotal' => $this->subtotal,
            'grandTotal' => $this->grandTotal,
            'transaction_number' => $this->transaction_number,
            'transaction_time' => now()->format('H:i:s'),
            'transaction_date' => now()->format('d-m-Y'),
        ];

        // dd($this->payment, $this->selectedItems, $this->customerDetails ?? null, $this->tax_details ?? null, $this->credit_details ?? null, $this->transaction_info ?? null);

        if (isset($this->customerDetails['customer_id'])) {
            $customer = Customer::find($this->customerDetails['customer_id']);

            $this->customerDetails['customer'] = $customer;
        }




        if (!isset($this->customerDetails['customer_id']) && isset($this->customerDetails['firstname'])) {

            $address = Address::create([
                'province_code' => $this->customerDetails['province_code'],
                'city_municipality_code' => $this->customerDetails['city_municipality_code'],
                'barangay_code' => $this->customerDetails['barangay_code'],
                'street' => $this->customerDetails['street'],

            ]);
            $customer = Customer::create([
                'firstname' => $this->customerDetails['firstname'],
                'middlename' => $this->customerDetails['middlename'],
                'lastname' => $this->customerDetails['lastname'],
                'contact_number' => $this->customerDetails['contact_number'],
                'birthdate' => $this->customerDetails['birthdate'],
                'address_id' => $address->id,
                'customer_type' => $this->customerDetails['customer_type'],
                'customer_discount_no' => $this->customerDetails['customer_discount_no'],
                'id_picture' => 'N/A',

            ]);
        }


        $customer_id = $this->customerDetails['customer_id'] ?? $customer->id ?? null;

        $transactionType = $this->isSales ? 'Sales' : 'Credit';

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


        foreach ($this->selectedItems as $index => $selectedItem) {


            $inventory = Inventory::where('sku_code', $selectedItem['sku_code'])->first();

            $transactionDetails = TransactionDetails::create([
                'item_quantity' => $selectedItem['quantity'],
                'vat_type' => $selectedItem['vat_type'],
                'item_subtotal' => $selectedItem['total_amount'],
                'item_discount_amount' => $selectedItem['wholesale_discount_amount'],
                'discount' => $selectedItem['discount'],
                'discount_id' => $selectedItem['discount_id'],
                'transaction_id' => $transaction->id,
                'item_id' => $selectedItem['item_id'],
                'inventory_id' => $inventory->id
            ]);


            $inventory->current_stock_quantity -= $selectedItem['quantity'];
            if ($inventory->current_stock_quantity == 0) {
                $inventory->status = 'Not available';
            }
            $inventory->save();



            $inventory_movements = InventoryMovement::create([
                'transaction_detail_id' => $transactionDetails->id,
                'movement_type' => 'Sales',
                'operation' => 'Stock out',
            ]);
        }


        if ($this->isSales) {
            $payment = Payment::create([
                'transaction_id' => $transaction->id,
                'amount' => $this->payment['tendered_amount'],
                'tendered_amount' => $this->payment['tendered_amount'],
                'reference_number' => $this->payment['reference_no'] ?? 'N/A',
                'payment_type' => $this->payment['payment_type'],
            ]);
        } else {
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
        }





        $this->alert('success', 'New Transaction Saved Successfully');

        $this->dispatch('print-sales-receipt', array_merge(
            $receiptData,
            [
                'payment' => $this->payment,
                'selectedItems' => $this->selectedItems,
                'customerDetails' => $this->customerDetails ?? null,
                'tax_details' => $this->tax_details,
                'transaction_info' => $this->transaction_info,
                'credit_details' => $this->credit_details ?? null,
            ]
        ))->to(SalesReceipt::class);

        $this->dispatch('display-sales-receipt', showSalesReceipt: true)->to(CashierPage::class);
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
}
