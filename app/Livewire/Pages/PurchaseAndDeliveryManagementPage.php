<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class PurchaseAndDeliveryManagementPage extends Component
{

    public $showPrintPurchaseOrderDetails = false;

    public $sidebarStatus;

    public $showNavbar = true;

    public $showDeliveryButton = true;

    public $purchaseOrderOpen = true;

    public $showDeliveryPage = false;

    public $showPurchasePage = true;


    public function render()
    {
        return view('livewire.pages.purchase-and-delivery-page');
    }

    protected $listeners = [
        'change-sidebar-status' => 'changeSidebarStatus',
        'hide-navbar' => 'hideNavbar',
        'display-print-purchase-order-details' => 'displayPrintPurchaseOrderDetails',
        'show-navbar-for-create-form-dashboard' => 'showNavbarForCreatePurchaseOrderFormFromDashboard',
        'display-delivery-page' => 'displayDeliveryPage',
        'display-purchase-page' => 'displayPurchasePage',
    ];

    public function showNavbarForCreatePurchaseOrderFormFromDashboard($showNavbar)
    {
        $this->showNavbar = $showNavbar;
    }

    public function displayDeliveryPage()
    {
        $this->showDeliveryPage = !$this->showDeliveryPage;
        $this->showPurchasePage = !$this->showPurchasePage;
    }

    public function displayPurchasePage()
    {
        $this->showDeliveryPage = !$this->showDeliveryPage;
        $this->showPurchasePage = !$this->showPurchasePage;
    }

    public function togglePurchaseOrder()
    {
        $this->purchaseOrderOpen = !$this->purchaseOrderOpen;
    }

    public function hideNavbar()
    {
        $this->sidebarStatus = true;
        $this->showDeliveryButton = false;
        $this->showNavbar = false;
    }

    public function changeSidebarStatus($sidebarOpen)
    {
        $this->sidebarStatus = $sidebarOpen;
    }


    public function displayPrintPurchaseOrderDetails()
    {
        $this->sidebarStatus = true;
        $this->showPrintPurchaseOrderDetails = true;
    }
}
