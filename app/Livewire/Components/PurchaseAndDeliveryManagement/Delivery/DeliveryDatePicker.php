<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery;

use App\Livewire\Pages\DeliveryPage;
use Livewire\Component;

class DeliveryDatePicker extends Component
{

    public $date;

    public function render()
    {
        return view('livewire.components.purchaseanddeliverymanagement.delivery.delivery-date-picker');
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-delivery-date-picker')->to(DeliveryPage::class);
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset([
            'date'
        ]);
    }
}
