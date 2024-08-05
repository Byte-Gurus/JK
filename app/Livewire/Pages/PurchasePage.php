<?php

namespace App\Livewire\Pages;


use App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase\PurchaseOrderForm;
use Livewire\Component;

class PurchasePage extends Component
{

    public $isCreate;

    public $showModal = false;

    public function render()
    {
        return view('livewire.pages.purchase-page');
    }

    public function formCreate()
    {
        $this->dispatch('change-method', isCreate: true)->to(PurchaseOrderForm::class);
    }

    public function createPurchaseOrder()
    {
        $this->isCreate = true;
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
    ];

    public function cancelPurchaseOrder()
    {
        $this->isCreate = false;
    }

}
