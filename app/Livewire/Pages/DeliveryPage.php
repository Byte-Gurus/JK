<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery\RestockForm;
use Livewire\Component;

class DeliveryPage extends Component
{

    public $showRestockForm = false;

    public $openDeliveryDetails = false;
    public function render()
    {
        return view('livewire.pages.delivery-page');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'display-restock-form' => 'displayRestockForm',
        'view-delivery-details' => 'viewDeliveryDetails',
    ];

    public function displayRestockForm($showRestockForm)
    {
        $this->showRestockForm = $showRestockForm;
    }

    public function cancelRestockForm()
    {
        $this->showRestockForm = false;
    }

    public function viewDeliveryDetails($openDeliveryDetails)
    {
        $this->openDeliveryDetails = $openDeliveryDetails;
        $this->showRestockForm = true;
    }

    public function closeDeliveryDetails()
    {
        $this->showRestockForm = false;
        $this->openDeliveryDetails = false;
    }
}
