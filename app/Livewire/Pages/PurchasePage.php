<?php

namespace App\Livewire\Pages;



use App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase\PurchaseOrderForm;
use Livewire\Component;

class PurchasePage extends Component
{

    public $isCreate;
    public $showModal;

    public $showEditModal;

    public function render()
    {
        return view('livewire.pages.purchase-page');
    }

    public function formCreate()
    {
        $this->dispatch('change-method', isCreate: true)->to(PurchaseOrderForm::class);
        $this->dispatch('display-modal', showModal: true)->to(PurchaseOrderForm::class);

    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'change-method' => 'changeMethod',
        'display-edit-modal' => 'displayEditModal',
        'form-cancel' => 'formCancel'
    ];

    public function changeMethod($isCreate)
    {
        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showEditModal = false;
        $this->dispatch('display-modal', showModal: false)->to(PurchaseOrderForm::class);
    }

    public function displayEditModal($showEditModal)
    {
        $this->showEditModal = $showEditModal;
        $this->dispatch('display-modal', showModal: false)->to(PurchasePage::class); //var assign ang parameter value sa global variable
    }

    public function formCancel()
    {
        $this->dispatch('display-modal', showModal: false)->to(PurchaseOrderForm::class); //var assign ang parameter value sa global variable
    }
}
