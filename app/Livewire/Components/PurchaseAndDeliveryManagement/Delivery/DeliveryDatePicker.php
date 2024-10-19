<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery;

use App\Events\DeliveryEvent;
use App\Livewire\Pages\DeliveryPage;
use App\Models\Delivery;
use App\Models\Purchase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DeliveryDatePicker extends Component
{
    use WithPagination, WithoutUrlPagination, LivewireAlert;

    public $date, $delivery_id, $selectedDate;

    public function render()
    {
        return view('livewire.components.purchaseanddeliverymanagement.delivery.delivery-date-picker');
    }

    protected $listeners = [
        'get-date' => 'getDate',
        'updateConfirmed'
    ];

    public function changeDate()
    {

        $delivery = Delivery::find($this->delivery_id);


        $inputDate = Carbon::parse($this->date)->startOfDay();
        $purchaseOrderDate = Carbon::parse($delivery->purchaseJoin->created_at)->startOfDay();



        if ($inputDate->lessThan($purchaseOrderDate)) {
            $this->alert('error', 'Delivery date must be after or on the creation date of the purchase order.');
            return;
        }
        if ($inputDate > Carbon::today()) {
            $this->alert('error', 'Delivery date maximum date is today.');
            return;
        }
        $this->selectedDate = $inputDate;

        $this->confirm("Do you want to update this delivery?", [
            'onConfirmed' => 'updateConfirmed',
        ]);
    }

    public function updateConfirmed()
    {


        DB::beginTransaction();

        try {
            $delivery = Delivery::find($this->delivery_id);

            if (!$delivery) {

                DB::rollback();
                $this->alert('error', 'Delivery not found.');
                return; // Exit the method

            }
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
                $delivery->date_delivered = $this->selectedDate;
                $delivery->status = "Delivered";
                $delivery->save();

                $this->alert('success', 'Delivery date and applicable backorders updated successfully');
                $this->resetPage();
            } else {
                // If there are no backorders, only update the current delivery details
                $delivery->date_delivered = $this->selectedDate;
                $delivery->status = "Delivered";
                $delivery->save();

                $this->alert('success', 'Delivery date changed successfully');
                $this->resetPage();
            }

            DB::commit();

            $this->resetPage();
            $this->dispatch(event: 'refresh-table')->to(DeliveryTable::class);
            DeliveryEvent::dispatch('refresh-delivery');
            $this->resetFormWhenClosed();
            return back();
        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            DB::rollback();
            $this->alert('error', 'An error occurred while updating the Delivery, please refresh the page ');
        }
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-delivery-date-picker')->to(DeliveryPage::class);
        $this->resetValidation();
    }

    public function getDate($id)
    {
        $this->delivery_id = $id;
    }
    public function resetForm()
    {
        $this->reset([
            'date'
        ]);
    }
}
