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

    public $po_number, $items;






    public function render()
    {
        $suppliers = Supplier::select('id', 'company_name')->where('status_id', '1')->get();




        return view('livewire.components.PurchaseAndDeliveryManagement.Purchase.purchase-order-form', [
            'suppliers' => $suppliers,

        ]);
    }


    protected $listeners = [
        'edit-po-from-table' => 'edit',
        'create-po' => 'po',
        'change-method' => 'changeMethod',
        'reset-modal' => 'resetModal',
        'reset-form' => 'mount',
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


            foreach ($this->reorder_lists as $index => $reorder_list) {
                PurchaseDetails::create([
                    'purchase_id' => $purchase_order->id,
                    'item_id' => $reorder_list['item_id'], // Use item_id from reorder_list
                    'po_number' => $validated['po_number'],
                    'purchase_quantity' => $this->purchase_quantities[$index],
                ]);
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
            DB::rollback();
            $this->alert('error', 'An error occurred while creating the purchase order, please refresh the page ');
        }
    }



    protected function validateForm()
    {

        $rules = [
            'po_number' => 'required|string|max:255|min:1',
            'select_supplier' => 'required|numeric',
        ];

        if ($this->isCreate) {
            // Add validation rules for each purchase quantity
            foreach ($this->reorder_lists as $index => $reorder_list) {
                $maxStockLevel = $reorder_list['maximum_stock_level'];

                if ($maxStockLevel > 0) {
                    $rules["purchase_quantities.$index"] = [
                        'required',
                        'numeric',
                        'min:1',
                        'lte:' . $maxStockLevel
                    ];
                } else {
                    $rules["purchase_quantities.$index"] = ['required', 'numeric', 'min:1'];
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
    private function resetForm() //*tanggalin ang laman ng input pati $item_id value
    {
        $this->reset(['purchase_id', 'proxy_purchase_id', 'purchase_quantities', 'select_supplier', 'removed_items', 'selectedToRemove', 'edit_reorder_lists', 'selectAllToRemove', 'selectAllToRestore']);
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

        $items = Item::withSum('inventoryJoin as total_stock_quantity', 'current_stock_quantity')->get();

        foreach ($items as $item) {

            $inventory = $item->inventoryJoin->first();

            if ($inventory && $inventory->current_stock_quantity <= $item->reorder_point) {
                // dump($item);
            }
        }
        dump($items);

    }

}
