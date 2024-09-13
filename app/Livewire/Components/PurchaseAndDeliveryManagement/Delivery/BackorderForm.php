<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery;

use App\Events\BackorderEvent;
use App\Livewire\Pages\DeliveryPage;
use App\Models\BackOrder;
use App\Models\Delivery;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class BackorderForm extends Component
{
    use LivewireAlert, WithPagination,  WithoutUrlPagination;
    public $backorderList = [];
    public $po_number,  $new_po_number, $purchase_id, $supplier, $delivery_id, $purchase, $select_supplier;
    public $selectedToReorder = [];
    public $selectedToCancel = [];
    public $new_po_items = [];
    public $selectAllToReorder = false;
    public $selectAllToCancel = false;

    public $isReorderListsCleared = false;
    public function render()
    {
        $suppliers = Supplier::select('id', 'company_name')->where('status_id', '1')->get();
        // Fetch the purchase with related backorders and items
        $this->purchase = Purchase::with('backorderJoin.itemJoin')
            ->find($this->purchase_id);


        if ($this->purchase && empty($this->backorderList) && !$this->isReorderListsCleared) {
            $this->backorderList = $this->purchase->backorderJoin->map(function ($backOrder) {
                return [
                    'backorder_quantity' => $backOrder->backorder_quantity,
                    'status' => $backOrder->status,
                    'new_po_number' => optional($backOrder->deliveryJoin)->purchaseJoin->po_number ?? 'N/A',
                    'barcode' => $backOrder->itemJoin->barcode,
                    'item_id' => $backOrder->itemJoin->id,
                    'item_name' => $backOrder->itemJoin->item_name,
                    'item_description' => $backOrder->itemJoin->item_description,
                    // Provide an empty array if no item details
                ];
            })->toArray();
        }

        return view('livewire.components.PurchaseAndDeliveryManagement.Delivery.backorder-form', [
            'backorder_lists' => $this->backorderList,
            'suppliers' => $suppliers,
        ]);
    }


    protected $listeners = [
        'refresh-table' => 'refreshTable', //*  galing sa UserTable class
        'backorder-form' => 'backorderForm',
        "echo:refresh-stock,RestockEvent" => 'refreshFromPusher',
        'updateConfirmed',
        'createConfirmed',
        'cancelConfirmed',
    ];

    public function create() //* create process
    {


        $validated = $this->validateForm();

        $this->confirm('Do you want to create this purchase order?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' =>  $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }

    public function createConfirmed($data) //* confirmation process ng create
    {

        $validated = $data['inputAttributes'];

        $purchase_order = Purchase::create([
            'po_number' => $validated['new_po_number'],
            'supplier_id' => $validated['select_supplier'],
            'user_id' => Auth::id(),
        ]);

        $old_po_id = Purchase::where('po_number', $this->po_number)->first();

        $delivery = Delivery::create([
            'status' => "In Progress",
            'date_delivered' => "N/A",
            'purchase_id' => $purchase_order->id,
            'old_po_id' => $old_po_id,

        ]);


        foreach ($this->new_po_items as $index => $new_po_item) {

            PurchaseDetails::create([
                'purchase_id' => $purchase_order->id,
                'item_id' => $new_po_item['item_id'], // Use item_id from reorder_list
                'po_number' => $validated['new_po_number'],
                'purchase_quantity' => $new_po_item['backorder_quantity'],
            ]);

            BackOrder::where('item_id', $new_po_item['item_id'])
                ->where('purchase_id', $this->purchase_id)
                ->update([
                    'status' => 'Repurchased',
                    'delivery_id' => $delivery->id,
                ]);
        }




        $this->alert('success', 'Purchase order was created successfully');
        $this->render();
        $this->refreshTable();
        BackorderEvent::dispatch('refresh-backorder');

        $this->resetForm();
        $this->closeBackorderForm();
    }
    private function populateForm() //*lagyan ng laman ang mga input
    {

        $purchase_details = Purchase::find($this->purchase_id);

        $this->fill([
            'po_number' => $purchase_details->po_number,
            'supplier' => $purchase_details->supplierJoin->company_name,
        ]);
    }

    public function purchaseRow()
    {

        foreach ($this->selectedToReorder as $index) {
            if (isset($this->backorderList[$index])) {
                $this->new_po_items[] = [
                    'item_id' => $this->backorderList[$index]['item_id'],
                    'barcode' => $this->backorderList[$index]['barcode'],
                    'item_name' => $this->backorderList[$index]['item_name'],
                    'backorder_quantity' => $this->backorderList[$index]['backorder_quantity'],
                    'item_description' => $this->backorderList[$index]['item_description'],
                    'status' => $this->backorderList[$index]['status'],
                    'new_po_number' => $this->backorderList['new_po_number'] ?? 'N/A'
                ];
            }
        }
        // dd($this->new_po_items);

        // Remove the selected items from reorder_lists
        foreach ($this->selectedToReorder as $index) {

            unset($this->backorderList[$index]);
        }

        $this->backorderList = array_values($this->backorderList);


        $this->selectedToReorder = [];


        if (empty($this->backorderList)) {
            $this->isReorderListsCleared = true;
        }
    }
    public function reorderAll()
    {

        if ($this->selectAllToReorder) {
            $this->selectedToReorder = array_keys(array_filter($this->backorderList, function ($item) {
                return $item['status'] !== 'Repurchased';
            }));
        } else {
            $this->selectAllToReorder = [];
        }
    }
    public function cancelAll()
    {

        if ($this->selectAllToCancel) {
            $this->selectedToCancel = array_keys($this->new_po_items);
        } else {
            $this->selectAllToCancel = [];
        }
    }

    public function cancelRow()
    {

        foreach ($this->selectedToCancel as $index) {

            // Add the item back to reorder_lists
            $this->backorderList[] = $this->new_po_items[$index];

            unset($this->new_po_items[$index]);
        }

        $this->backorderList = array_values($this->backorderList);


        $this->selectedToCancel = [];
        $this->selectAllToCancel = false;
    }

    protected function validateForm()
    {

        $rules = [
            'new_po_number' => 'required|string|max:255|min:1',
            'select_supplier' => 'required|numeric',
        ];


        return $this->validate($rules);
    }

    public function closeBackorderForm() //* close ang modal after confirmation
    {
        $this->dispatch('close-backorder-form')->to(DeliveryPage::class);
        $this->resetValidation();
    }

    public function refreshTable() //* refresh ang table after confirmation
    {
        $this->dispatch('refresh-table')->to(DeliveryTable::class);
    }

    private function resetForm() //*tanggalin ang laman ng input pati $item_id value
    {

        $this->reset(['backorderList', 'po_number', 'new_po_number', 'purchase_id', 'supplier', 'delivery_id', 'purchase', 'select_supplier', 'selectedToReorder', 'selectedToCancel', 'new_po_items']);
    }
    public function backorderForm($deliveryID)
    {

        $this->delivery_id = $deliveryID;
        $delivery = Delivery::find($this->delivery_id);
        $this->purchase_id = $delivery->purchase_id;



        $this->generatePurchaseOrderNumber();
        $this->populateForm();
    }

    public function generatePurchaseOrderNumber()  //* generate a random barcode and contatinate the ITM
    {

        $randomNumber = random_int(0, 9999);
        $formattedNumber = str_pad($randomNumber, 4, '0', STR_PAD_LEFT);
        $this->new_po_number = 'PO-' . $formattedNumber . '-' . now()->format('dmY');
    }

     public function refreshFromPusher()
    {
        $this->resetPage();
    }
}
