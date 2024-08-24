<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery\RestockForm;
use Livewire\Component;

class DeliveryPage extends Component
{

    public $showDeliveryTable = true;
    public $viewDeliveryTable = true;
    public $showRestockForm = false;
    public $showDeliveryDetails = false;
    public $showBackorderPage = false;


    public function render()
    {
        return view('livewire.pages.delivery-page');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'view-delivery-table' => 'viewDeliveryTable',
        'display-restock-form' => 'displayRestockForm',
        'display-delivery-table' => 'displayDeliveryTable',
        'display-delivery-details' => 'displayDeliveryDetails',
        'display-backorder-page' => 'displayBackorderPage',
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
    }

    public function displayDeliveryDetails($showDeliveryDetails)
    {
        $this->showDeliveryDetails = $showDeliveryDetails;
    }

    public function closeDeliveryDetails()
    {
        $this->showDeliveryTable = true;
        $this->showDeliveryDetails = false;
    }

    public function viewBackOrderPage()
    {
        $this->viewDeliveryTable = false;
        $this->showDeliveryTable = false;
        $this->showDeliveryDetails = false;
        $this->showRestockForm = false;
        $this->showBackorderPage = true;
    }

    public function viewDeliveryTable($viewDeliveryTable)
    {
        $this->viewDeliveryTable = $viewDeliveryTable;
    }

    public function displayBackorderPage($showBackorderPage)
    {
        $this->showBackorderPage = $showBackorderPage;
    }
}
