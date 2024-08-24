<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery\RestockForm;
use Livewire\Component;

class DeliveryPage extends Component
{

    public $showRestockForm = true;

    public $showDeliveryDetails = false;

    public $showBackOrderPage = false;

    public $showDeliveryTable = true;

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

    public function viewDeliveryDetails($showDeliveryDetails)
    {
        $this->showDeliveryDetails = $showDeliveryDetails;
        $this->showRestockForm = true;
    }

    public function closeDeliveryDetails()
    {
        $this->showRestockForm = false;
        $this->showDeliveryDetails = false;
    }

    public function viewBackOrderPage()
    {
        $this->showDeliveryTable = false;
        $this->showDeliveryDetails = false;
        $this->showRestockForm = false;
        $this->showBackOrderPage = true;
    }
}
