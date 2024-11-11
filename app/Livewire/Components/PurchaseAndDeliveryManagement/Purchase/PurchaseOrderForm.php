<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase;

use App\Events\PurchaseOrderEvent;
use App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery\DeliveryTable;
use App\Livewire\Pages\PurchasePage;
use App\Models\Delivery;
use App\Models\Item;
use App\Models\Log;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class PurchaseOrderForm extends Component
{

    use LivewireAlert, WithPagination, WithoutUrlPagination;

    public $isCreate = true;

    public $po_number, $items, $selectAll, $select_supplier;

    public $reorderLists = [], $toOrderItems = [], $selectedItems = [], $purchaseQuantities = [];
    public $search = '';

    public function render()
    {
        $suppliers = Supplier::select('id', 'company_name')->where('status_id', '1')->get();

        if (empty($this->search)) {
            $items = Item::withSum('inventoryJoin as total_stock_quantity', 'current_stock_quantity')->get();

            $this->reorderLists = [];

            foreach ($items as $item) {


                if ($item->inventoryJoin->isNotEmpty() && $item->total_stock_quantity <= $item->reorder_point) {
                    $this->reorderLists[] = $item;
                }
            }
        }


        return view('livewire.components.PurchaseAndDeliveryManagement.Purchase.purchase-order-form', [
            'suppliers' => $suppliers,
            'reorderLists' => $this->reorderLists
        ]);
    }

    protected $listeners = [
        'edit-po-from-table' => 'edit',
        'create-po' => 'po',
        'change-method' => 'changeMethod',
        'updateConfirmed',
        'createConfirmed',
    ];

    public function create() //* create process
    {
        $validated = $this->validateForm();

        $this->confirm('Do you want to create this purchase order?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' => $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }

    public function createConfirmed($data) //* confirmation process ng create
    {

        $validated = $data['inputAttributes'];

        DB::beginTransaction();

        try {

            $existingPurchaseOrder = Purchase::where('po_number', $validated['po_number'])->first();

            if ($existingPurchaseOrder) {
                $this->alert('error', 'Purchase order number already exists.');
                return; // Exit if it exists
            }

            $purchase_order = Purchase::create([
                'po_number' => $validated['po_number'],
                'supplier_id' => $validated['select_supplier'],
                'user_id' => Auth::id(),
            ]);


            foreach ($this->selectedItems as $index => $selectedItem) {
                if (isset($this->purchaseQuantities) && $this->purchaseQuantities[$index]) {
                    PurchaseDetails::create([
                        'purchase_id' => $purchase_order->id,
                        'item_id' => $selectedItem['id'], // Use item_id from reorder_list
                        'po_number' => $validated['po_number'],
                        'purchase_quantity' => $this->purchaseQuantities[$index],
                    ]);
                }

            }

            $delivery = Delivery::create([
                'status' => "In Progress",
                'date_delivered' => "N/A",
                'purchase_id' => $purchase_order->id
            ]);

            $userName = Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname;

            $log = Log::create([
                'user_id' => Auth::user()->id,
                'message' => $userName . ' (' . Auth::user()->username . ') ' . 'Created a purchase order',
                'action' => 'PO Create'
            ]);

            DB::commit();

            $this->alert('success', 'Purchase order was created successfully');
            $this->refreshTable();
            PurchaseOrderEvent::dispatch('refresh-purchase-order');

            $this->resetForm();
            $this->closeModal();
        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            dump($e);
            DB::rollback();
            $this->alert('error', 'An error occurred while creating the purchase order, please refresh the page ');
        }
    }

    public function updatedSelectAll()
    {
        if ($this->selectAll === true) {
            $this->toOrderItems = array_fill(0, count($this->reorderLists), true);
            foreach ($this->reorderLists as $index => $reorderList) {
                $this->selectedItems[] = $reorderList;
            }


        } else {
            $this->toOrderItems = array_fill(0, count($this->reorderLists), false);
            foreach ($this->reorderLists as $index => $reorderList) {
                $this->selectedItems = null;
            }
        }
    }

    public function updatedSearch()
    {
        $items = Item::withSum('inventoryJoin as total_stock_quantity', 'current_stock_quantity')
            ->where('item_name', 'like', '%' . $this->search . '%')
            ->get();

        $this->reorderLists = [];

        foreach ($items as $item) {
            if ($item->inventoryJoin->isNotEmpty() && $item->total_stock_quantity <= $item->reorder_point) {
                $this->reorderLists[] = $item;
            }
        }

        $this->toOrderItems = array_fill(0, count($this->reorderLists), false);


    }



    public function UpdatedPurchaseQuantities($index, $value)
    {

    }

    public function updatedToOrderItems($state, $index)
    {
        // Get the item from the reorderLists using the index
        $reorderList = $this->reorderLists[$index];

        if ($state === true) {
            // Add the item to the selectedItems array if it is checked
            $this->selectedItems[] = $reorderList;
        } else {
            // Remove the item from the selectedItems array if it is unchecked
            $this->selectedItems = collect($this->selectedItems)
                ->reject(function ($item) use ($reorderList) {
                    return $item['id'] === $reorderList['id']; // Remove based on the 'id'
                })
                ->values()
                ->toArray();
        }

    }

    public function test()
    {
        dump($this->selectedItems);
    }




    protected function validateForm()
    {

        $rules = [
            'po_number' => 'required|string|max:255|min:1',
            'select_supplier' => 'required|numeric',
        ];

        // Add validation rules for each purchase quantity
        foreach ($this->selectedItems as $index => $selectedItem) {

            if (isset($this->purchaseQuantities) && $this->purchaseQuantities[$index]) {

                $maxStockLevel = $selectedItem['maximum_stock_level'];

                if ($maxStockLevel > 0) {
                    $rules["purchaseQuantities.$index"] = [
                        'required',
                        'numeric',
                        'min:1',
                        'lte:' . $maxStockLevel
                    ];


                } else {
                    $rules["purchaseQuantities.$index"] = ['required', 'numeric', 'min:1'];

                }
            }


        }



        return $this->validate($rules);
    }

    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(PurchasePage::class);
        $this->dispatch('refresh-table')->to(PurchaseOrderTable::class);
        $this->resetValidation();
    }

    public function generatePurchaseOrderNumber()
    {
        do {
            $randomNumber = random_int(0, 9999);
            $formattedNumber = str_pad($randomNumber, 4, '0', STR_PAD_LEFT);
            $purchaseOrderNumber = 'PO-' . $formattedNumber . '-' . now()->format('mdY');

            // Check if the purchase order number already exists
            $exists = Purchase::where('po_number', $purchaseOrderNumber)->exists();
        } while ($exists);

        // Assign the unique purchase order number
        $this->po_number = $purchaseOrderNumber;
    }

    public function refreshTable() //* refresh ang table after confirmation
    {
        $this->dispatch('refresh-table')->to(PurchaseOrderTable::class);
        $this->dispatch('refresh-table')->to(DeliveryTable::class);
    }

    public function po()
    {
        $this->generatePurchaseOrderNumber();


    }

}
