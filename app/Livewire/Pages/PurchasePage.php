<?php

namespace App\Livewire\Pages;



use App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase\PurchaseOrderForm;
use Livewire\Component;
use Livewire\WithPagination;

class PurchasePage extends Component
{
    use WithPagination;
    public $isCreate;
    public $showModal;

    public $hideTable;

    public $showEditModal;

    public $viewPurchaseOrderDetails;

    public $showPurchaseOrderTable = true;

    public $showPurchaseOrderForm = false;

    public $showPurchaseOrderDetails = false;

    public $showPrintPurchaseOrderDetails = false;

    public function render()
    {
        return view('livewire.pages.purchase-page');
    }

    public function formCreate()
    {
        $this->showPurchaseOrderTable = false;
        $this->showPurchaseOrderForm = true;
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'change-method' => 'changeMethod',
        'display-edit-modal' => 'displayEditModal',
        'display-purchase-order-details' => 'displayPurchaseOrderDetails',
        'display-print-purchase-order-details' => 'displayPrintPurchaseOrderDetails',
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

    public function displayPrintPurchaseOrderDetails()
    {
        $this->showPurchaseOrderTable = false;
        $this->showPrintPurchaseOrderDetails = true;
    }

    public function formCancel()
    {
        $this->showPurchaseOrderForm = false;
        $this->showPurchaseOrderTable = true;
        $this->dispatch('reset-modal')->to(PurchaseOrderForm::class); //var assign ang parameter value sa global variable
    }

    public function displayPurchaseOrderDetails()
    {
        $this->showPurchaseOrderDetails = true;
        $this->showPurchaseOrderTable = false;

    }

    public function returnToPurchaseOrderTable()
    {
        $this->dispatch('refresh-purchase-order-form')->to(PurchaseOrderForm::class); //var assign ang parameter value sa global variable
        $this->showPurchaseOrderDetails = false;
        $this->showPurchaseOrderTable = true;
    }
}
