<?php

namespace App\Livewire\Pages;



use App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase\PurchaseOrderForm;
use Livewire\Component;

class PurchasePage extends Component
{

    public $isCreate;
    public $showModal;

    public $hideTable;

    public $showEditModal;

    public $viewPurchaseOrderDetails;

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
        'display-purchase-order-details' => 'displayPurchaseOrderDetails',
        'form-cancel' => 'formCancel',
        'display-table' => 'displayTable'
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
    }

    public function formCancel()
    {
        $this->dispatch('display-modal', showModal: false)->to(PurchaseOrderForm::class); //var assign ang parameter value sa global variable
    }

    public function displayPurchaseOrderDetails($viewPurchaseOrderDetails)
    {
        $this->viewPurchaseOrderDetails = $viewPurchaseOrderDetails;
    }

    public function displayTable()
    {
        $this->showModal = true;
    }

    public function returnToTable()
    {
        $this->viewPurchaseOrderDetails = false;
        $this->showModal = false;
    }
}
