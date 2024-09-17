<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\PurchaseAndDeliveryManagement\Delivery\RestockForm;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DeliveryPage extends Component
{
    use LivewireAlert;
    public $showDeliveryTable = true;
    public $showRestockForm = false;
    public $showBackorderForm = false;


    public function render()
    {
        return view('livewire.pages.delivery-page');
    }

    protected $listeners = [
        'close-backorder-form' => 'closeBackorderForm',
        'display-restock-form' => 'displayRestockForm',
        'display-delivery-table' => 'displayDeliveryTable',
        'display-backorder-form' => 'displayBackorderForm',
        'closeRestockFormConfirmed'
    ];

    public function displayDeliveryTable($showDeliveryTable)
    {
        $this->showDeliveryTable = $showDeliveryTable;
    }

    public function displayRestockForm($showRestockForm)
    {
        $this->showRestockForm = $showRestockForm;
    }

    public function closeRestockForm()
    {
        $this->confirm("Do you want to close the restock form?", [
            'onConfirmed' => 'closeRestockFormConfirmed',
        ]);
    }
    public function closeRestockFormConfirmed()
    {
        $this->dispatch('close-modal')->to(RestockForm::class);
        $this->showDeliveryTable = true;
        $this->showRestockForm = false;
    }



    public function displayBackorderForm($showBackorderForm)
    {
        $this->showBackorderForm = $showBackorderForm;
    }

    public function closeBackorderForm()
    {
        $this->showBackorderForm = false;
        $this->showDeliveryTable = true;
    }
}
