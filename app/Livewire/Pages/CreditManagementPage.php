<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\CreditManagement\CreditForm;
use Livewire\Component;

class CreditManagementPage extends Component
{

    public $showCreditTable = true;
    public $showCreditHistory = false;

    public $showCreditPaymentForm = false;

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
        'display-stock-card' => 'displayStockCard',
    ];

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
        $this->showCreditTable = true;
        $this->showCreditHistory = false;
    }

    public function displayCreditPaymentForm($showCreditPaymentForm)
    {
        $this->showCreditPaymentForm = $showCreditPaymentForm;
    }
}
