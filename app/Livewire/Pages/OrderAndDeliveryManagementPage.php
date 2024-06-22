<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class OrderAndDeliveryManagementPage extends Component
{

    public $sidebarStatus;

    public $purchaseOrderOpen = true;


    public function render()
    {
        return view('livewire.pages.order-and-delivery-page');
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
