<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery\RestockForm;
use Livewire\Component;

class DeliveryPage extends Component
{

    public $showRestockForm = false;
    public function render()
    {
        return view('livewire.pages.delivery-page');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'display-restock-form' => 'displayRestockForm',
        'dsplay-delivery-table' => 'displayDeliveryTable'
    ];

    public function displayRestockForm($showRestockForm)
    {
        $this->showRestockForm = $showRestockForm;
    }

    public function cancelRestockForm()
    {
        $this->dispatch('close-modal')->to(RestockForm::class);
        $this->showRestockForm = false;

    }
}
