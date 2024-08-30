<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery;

use App\Livewire\Pages\DeliveryPage;
use App\Models\BackOrder;
use App\Models\Delivery;
use App\Models\Purchase;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DeliveryTable extends Component
{
    use WithPagination,  WithoutUrlPagination, LivewireAlert;

    public $sortDirection = 'desc'; //var default sort direction is ascending
    public $sortColumn = 'id'; //var defualt sort is ID
    public $perPage = 10; //var for pagination
    public $search = '';  //var search component

    public $statusFilter = 0; //var filtering value = all
    //var filtering value = all
    public $supplierFilter = 0;

    public $dateDelivered = [];
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

        return view('livewire.components.PurchaseAndDeliveryManagement.delivery.delivery-table', compact('deliveries', 'suppliers'));
    }

    protected $listeners = [
        'refresh-table' => 'refreshTable', //*  galing sa UserTable class
        'updateConfirmed',
        'cancelConfirmed',
    ];


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
        $deliveries = [
            'date' => $date,
            'deliveryId' => $id
        ];


        $this->confirm("Do you want to update this delivery?", [
            'onConfirmed' => 'updateConfirmed',
            'inputAttributes' => $deliveries,
        ]);
    }

    public function updateConfirmed($data)
    {

        $updatedAttributes = $data['inputAttributes'];

        $deliveryId = $updatedAttributes['deliveryId'];

        $delivery = Delivery::find($deliveryId);

        if ($delivery->backorderJoin->isNotEmpty()) {
            // Loop through each backorder associated with the delivery where status is 'Repurchased'
            foreach ($delivery->backorderJoin as $backorderDetail) {
                if ($backorderDetail->status === 'Repurchased') {
                    // Update the status of each backorder to "Delivered"
                    $backorderDetail->update(['status' => 'Delivered']);
                }
            }

            // Update the delivery details after updating backorders
            $delivery->date_delivered = $updatedAttributes['date'];
            $delivery->status = "Delivered";
            $delivery->save();

            $this->alert('success', 'Delivery date and applicable backorders updated successfully');
        } else {
            // If there are no backorders, only update the delivery details
            $delivery->date_delivered = $updatedAttributes['date'];
            $delivery->status = "Delivered";
            $delivery->save();

            $this->alert('success', 'Delivery date changed successfully');
        }

        $this->resetPage();
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
}
