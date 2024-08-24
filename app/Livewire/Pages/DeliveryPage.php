<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery\RestockForm;
use Livewire\Component;

class DeliveryPage extends Component
{

    public $showDeliveryTable = true;
    public $showRestockForm = false;
    public $showBackorderPage = false;


    public function render()
    {
        return view('livewire.pages.delivery-page');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'display-restock-form' => 'displayRestockForm',
        'display-delivery-table' => 'displayDeliveryTable',
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
        $this->showDeliveryTable = true;
    }

    public function displayBackorderPage($showBackorderPage)
    {
        $this->showBackorderPage = $showBackorderPage;
    }

    public function closeBackorderPage()
    {
        $this->showBackorderPage = false;
        $this->showDeliveryTable = true;
    }
}
