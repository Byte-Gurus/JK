<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery;

use App\Events\DeliveryEvent;
use App\Livewire\Pages\DeliveryPage;
use App\Models\BackOrder;
use App\Models\Delivery;
use App\Models\Purchase;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

    public $dateDelivered = [], $delivery_date, $selectedDate, $today_date;
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

    public function changeDate($id)
    {
        $this->dispatch('get-date', $id)->to(DeliveryDatePicker::class);
    }

    public function ss()
    {
        dd('hi');
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

    public function displayDeliveryDatePicker()
    {
        $this->dispatch('display-delivery-date-picker')->to(DeliveryPage::class);
    }
}
