<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase\PurchaseOrderForm;
use Livewire\Component;

class PurchaseAndDeliveryManagementPage extends Component
{

    public $sidebarStatus;

    public $purchaseOrderOpen = true;


    public function render()
    {
        return view('livewire.pages.purchase-and-delivery-page');
    }

    protected $listeners = [
        'change-sidebar-status' => 'changeSidebarStatus',
        ];

    public function togglePurchaseOrder()
    {
        $this->purchaseOrderOpen = !$this->purchaseOrderOpen;
    }

    public function changeSidebarStatus($sidebarOpen)
    {
       $this->sidebarStatus = $sidebarOpen;
    }

}
