<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery;

use App\Events\DeliveryEvent;
use App\Livewire\Pages\DeliveryPage;
use App\Models\Delivery;
use App\Models\Log;
use App\Models\Purchase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DeliveryDatePicker extends Component
{
    use WithPagination, WithoutUrlPagination, LivewireAlert, WithFileUploads;

    public $date, $delivery_id, $selectedDate, $delivery_receipt, $isCreate = true;

    public function render()
    {
        return view('livewire.components.PurchaseAndDeliveryManagement.Delivery.delivery-date-picker');
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

        if (!$this->delivery_receipt && $this->isCreate != true) {
            $this->alert('error', 'Delivery Receipt is required.');
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

            if ($this->delivery_receipt && File::isImage($this->delivery_receipt)) {
                // Validate and store the uploaded file temporarily
                $path = $this->delivery_receipt->store('temp'); // This stores the file in the 'temp' directory temporarily

                // Generate a new filename
                $filename = Str::random(40) . '.' . $this->delivery_receipt->getClientOriginalExtension();

                // Get the contents of the file
                $fileContents = Storage::disk('local')->get($path);

                // Store the file on S3
                $isStored = Storage::disk('s3')->put($filename, $fileContents);

                // Optionally delete the temporary file
                Storage::disk('local')->delete($path);

                $this->delivery_receipt = Storage::disk('s3')->url($filename);
            } else {
                $this->delivery_receipt = null; // or provide a default value if necessary
            }


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
                $delivery->delivery_receipt = $this->delivery_receipt;
                $delivery->save();

                $this->alert('success', 'Delivery date and applicable backorders updated successfully');
                $this->resetPage();
            } else {
                // If there are no backorders, only update the current delivery details
                $delivery->date_delivered = $this->selectedDate;
                $delivery->status = "Delivered";
                $delivery->delivery_receipt = $this->delivery_receipt;
                $delivery->save();

                $this->alert('success', 'Delivery date changed successfully');
                $this->resetPage();
            }

            $userName = Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname;

            $log = Log::create([
                'user_id' => Auth::user()->id,
                'message' => $userName . ' (' . Auth::user()->username . ') ' . 'Updated a delivery',
                'action' => 'Delivery Update'
            ]);

            DB::commit();

            $this->resetPage();
            $this->dispatch(event: 'refresh-table')->to(DeliveryTable::class);
            DeliveryEvent::dispatch('refresh-delivery');
            $this->resetFormWhenClosed();
            return back();
        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            dump($e);
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
    private function populateForm() //*lagyan ng laman ang mga input
    {

        $delivery = Delivery::find($this->delivery_id); //? kunin lahat ng data ng may ari ng user_id

        $this->fill([
            'date' => $delivery->date_delivered,
            'delivery_receipt' => $delivery->delivery_receipt,
        ]);

    }


    public function getDate($id)
    {
        $this->delivery_id = $id;
        $this->isCreate = false;
        $this->populateForm();
    }
    public function resetForm()
    {
        $this->reset([
            'date'
        ]);
    }


    public function removeSelectedPicture()
    {
        $this->reset(['delivery_receipt']);
    }
}
