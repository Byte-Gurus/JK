<?php

namespace App\Livewire\Pages;



use App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase\PurchaseOrderForm;
use Livewire\Component;

class PurchasePage extends Component
{

    public $isCreate = false;
    public $showModal;


    public function render()
    {
        return view('livewire.pages.purchase-page');
    }

    public function formCreate()
    {
        $this->dispatch('change-method', isCreate: true)->to(PurchaseOrderForm::class);
        $this->dispatch('display-modal', showModal: true)->to(PurchaseOrderForm::class);
        $this->showModal = true;
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'change-method' => 'changeMethod',
        'form-cancel' => 'formCancel'
    ];

    public function changeMethod($isCreate)
    {
        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable
    }

    public function formCancel($showModal)
    {
        $this->showModal = $showModal; //var assign ang parameter value sa global variable

        if ($this->showModal) {
        } else {
        }
    }
}
