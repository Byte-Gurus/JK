<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery\RestockForm;
use Livewire\Component;

class DeliveryPage extends Component
{

    public $showDeliveryTable = true;
    public $showRestockForm = false;
    public $showBackorderDetails = false;


    public function render()
    {
        return view('livewire.pages.delivery-page');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'display-restock-form' => 'displayRestockForm',
        'display-delivery-table' => 'displayDeliveryTable',
        'display-backorder-details' => 'displayBackorderDetails',
    ];

    public function displayDeliveryTable($showDeliveryTable)
    {
        $this->showDeliveryTable = $showDeliveryTable;
    }

    public function displayRestockForm($showRestockForm)
    {
        $this->showRestockForm = $showRestockForm;
    }

    public function cancelRestockForm()
    {
        $this->showRestockForm = false;
        $this->showDeliveryTable = true;
    }

    public function displayBackorderDetails($showBackorderDetails)
    {
        $this->showBackorderDetails = $showBackorderDetails;
    }

    public function closeBackorderDetails()
    {
        $this->showBackorderDetails = false;
        $this->showDeliveryTable = true;
    }
}
