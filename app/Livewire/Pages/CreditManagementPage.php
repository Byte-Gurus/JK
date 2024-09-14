<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\CreditManagement\CreditForm;
use Livewire\Component;
use Livewire\WithPagination;

class CreditManagementPage extends Component
{
    use WithPagination;

    public $showNavbar = true;
    public $showModal = false;

    public $showCreditTable = true;
    public $showCreditHistory = false;

    public $showCreditPaymentForm = false;

    public $showPaymentReceipt = false;

    public $sidebarStatus;
    public function render()
    {
        return view('livewire.pages.credit-management-page');
    }

    public function formCreate()
    {
        $this->dispatch('change-method', isCreate: true)->to(CreditForm::class);
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'change-sidebar-status' => 'changeSidebarStatus',
        'display-credit-table' => 'displayCreditTable',
        'display-credit-payment-form' => 'displayCreditPaymentForm',
        'display-payment-receipt' => 'displayPaymentReceipt',
        'display-stock-card' => 'displayStockCard',
    ];

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function changeSidebarStatus($sidebarOpen)
    {
        $this->sidebarStatus = $sidebarOpen;
    }

    public function displayCreditHistory()
    {
        $this->showCreditTable = false;
        $this->showCreditHistory = true;
    }

    public function returnToCreditTable()
    {
        $this->resetPage();
        $this->showCreditHistory = false;
        $this->showPaymentReceipt = false;
        $this->showNavbar = true;
        $this->showCreditTable = true;
    }

    public function displayCreditPaymentForm($showCreditPaymentForm)
    {
        $this->showCreditPaymentForm = $showCreditPaymentForm;
    }

    public function displayPaymentReceipt()
    {
        $this->showNavbar = false;
        $this->sidebarStatus = true;
        $this->showCreditTable = false;
        $this->showCreditPaymentForm = false;
        $this->showPaymentReceipt = true;
    }
}
