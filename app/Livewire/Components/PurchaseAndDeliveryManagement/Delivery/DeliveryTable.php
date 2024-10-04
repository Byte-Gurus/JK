<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery;

use App\Events\DeliveryEvent;
use App\Livewire\Pages\DeliveryPage;
use App\Models\BackOrder;
use App\Models\Delivery;
use App\Models\Purchase;
use App\Models\Supplier;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DeliveryTable extends Component
{
    use WithPagination, WithoutUrlPagination, LivewireAlert;

    public $sortDirection = 'desc'; //var default sort direction is ascending
    public $sortColumn = 'id'; //var defualt sort is ID
    public $perPage = 10; //var for pagination
    public $search = '';  //var search component

    public $statusFilter = 0; //var filtering value = all
    //var filtering value = all
    public $supplierFilter = 0;

    public $dateDelivered = [], $delivery_date, $today_date;
    public function render()
    {
        $suppliers = Supplier::select('id', 'company_name')->where('status_id', '1')->get();

        $query = Delivery::query();


        $query->with(['purchaseJoin.backorderJoin']);

        if ($this->statusFilter != 0) {
            $query->where('status', $this->statusFilter); //?hanapin ang status na may same value sa statusFilter
        }
        if ($this->supplierFilter != 0) {
            // Use whereHas to filter deliveries based on the supplier_id through purchase
            $query->whereHas('purchaseJoin', function ($query) {
                $query->where('supplier_id', $this->supplierFilter);
            });
        }

        $deliveries = $query->search($this->search) //?search the user
            ->orderBy($this->sortColumn, $this->sortDirection) //? i sort ang column based sa $sortColumn na var
            ->paginate($this->perPage);  //?  and paginate it

        return view('livewire.components.PurchaseAndDeliveryManagement.Delivery.delivery-table', compact('deliveries', 'suppliers'));
    }

    protected $listeners = [
        'refresh-table' => 'refreshTable', //*  galing sa UserTable class
        "echo:refresh-delivery,DeliveryEvent" => 'refreshFromPusher',
        "echo:refresh-stock,RestockEvent" => 'refreshFromPusher',
        "echo:refresh-backorder,BackorderEvent" => 'refreshFromPusher',

        'updateConfirmed',
        'cancelConfirmed',
        'dateCancelled',
    ];

    public function setDateToday($deliverId)
    {
        $this->today_date = Carbon::today();
        $this->changeDate($deliverId, $this->today_date);
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

    public function getDeliveryID($deliveryId)
    {
        $this->dispatch('restock-form', deliveryID: $deliveryId)->to(RestockForm::class);
    }

    public function changeDate($id, $date)
    {



        $delivery = Delivery::find($id);


        $inputDate = Carbon::parse($date)->startOfDay();
        $purchaseOrderDate = Carbon::parse($delivery->purchaseJoin->created_at)->startOfDay();

        dd($inputDate, $purchaseOrderDate);
        $deliveries = [
            'date' => $date,
            'deliveryId' => $id
        ];

        if ($inputDate->lessThan($purchaseOrderDate)) {
            $this->alert('error', 'Delivery date must be after or on the creation date of the purchase order.');
            return;
        }
        if ($inputDate > Carbon::today()) {
            $this->alert('error', 'Delivery date maximum date is today.');
            return;
        }


        $this->confirm("Do you want to update this delivery?", [
            'onConfirmed' => 'updateConfirmed',
            'onDismissed' => 'dateCancelled',
            'inputAttributes' => $deliveries,
        ]);
    }

    public function updateConfirmed($data)
    {


        $updatedAttributes = $data['inputAttributes'];
        $deliveryId = $updatedAttributes['deliveryId'];


        // Find the current delivery record
        $delivery = Delivery::find($deliveryId);


        // Check if the current delivery has associated backorders
        if ($delivery->backorderJoin->isNotEmpty()) {

            // Decode the old purchase order data from the delivery record
            $oldPoData = json_decode($delivery->old_po_id, true);
            $old_purchase = Purchase::find($oldPoData['id']);


            // dd($old_purchase->backorderJoin);

            // Loop through each backorder associated with the current delivery
            foreach ($delivery->backorderJoin as $backorderDetail) {
                if ($backorderDetail->status === 'Repurchased') {
                    // Update the status of each backorder to "Delivered"
                    $backorderDetail->update(['status' => 'Delivered']);
                }
            }


            $missingOrRepurchasedCount = $old_purchase->backorderJoin
                ->whereIn('status', ['Missing', 'Repurchased'])
                ->count();


            // If all backorders are delivered, update the old delivery status to "Complete Backorder"
            if ($missingOrRepurchasedCount == 0) {
                // Get the old delivery record associated with the old purchase order
                $old_delivery = Delivery::where('purchase_id', $oldPoData['id'])->first();
                $old_delivery->update(['status' => 'Backorder complete']);
            }

            // Update the current delivery details
            $delivery->date_delivered = $this->today_date;
            $delivery->status = "Delivered";
            $delivery->save();

            $this->alert('success', 'Delivery date and applicable backorders updated successfully');
            $this->resetPage();
        } else {
            // If there are no backorders, only update the current delivery details
            $delivery->date_delivered = $this->today_date;
            $delivery->status = "Delivered";
            $delivery->save();

            $this->alert('success', 'Delivery date changed successfully');
            $this->resetPage();
        }

        $this->resetPage();
        DeliveryEvent::dispatch('refresh-delivery');

        return back();
    }

    public function cancelDelivery($deliverId)
    {
        $this->confirm("Do you want to cancel this delivery?", [
            'onConfirmed' => 'cancelConfirmed',
            'inputAttributes' => $deliverId,
        ]);
    }

    public function cancelConfirmed($data)
    {

        $deliveryId = $data['inputAttributes'];

        $delivery = Delivery::find($deliveryId);
        $delivery->status = "Cancelled";
        $delivery->save();

        $this->alert('success', 'Delivery cancelled successfully');
        $this->resetPage();

        DeliveryEvent::dispatch('refresh-delivery');
    }

    public function viewRestockForm()
    {
        $this->dispatch('display-delivery-table', showDeliveryTable: false)->to(DeliveryPage::class);
        $this->dispatch('display-restock-form', showRestockForm: true)->to(DeliveryPage::class);
    }

    public function viewBackorderDetails()
    {
        $this->dispatch('display-delivery-table', showDeliveryTable: false)->to(DeliveryPage::class);
        $this->dispatch('display-backorder-form', showBackorderForm: true)->to(DeliveryPage::class);
    }


    public function getPO_ID($deliverId)
    {

        $this->dispatch('backorder-form', deliveryID: $deliverId)->to(BackorderForm::class);
    }

    public function dateCancelled()
    {
        $this->reset('delivery_date');
    }

    public function refreshFromPusher()
    {
        $this->resetPage();
    }
}
