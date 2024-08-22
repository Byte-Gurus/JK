<?php

namespace App\Livewire\Components;

use App\Livewire\Pages\CustomerCreditMangementPage;
use App\Livewire\Pages\CustomerManagementPage;
use App\Livewire\Pages\Dashboard;
use App\Livewire\Pages\HomePage;
use App\Livewire\Pages\InventoryManagementPage;
use App\Livewire\Pages\ItemManagementPage;
use App\Livewire\Pages\OrderAndDeliveryManagementPage;
use App\Livewire\Pages\PurchaseAndDeliveryManagementPage;
use App\Livewire\Pages\SupplierManagementPage;
use App\Livewire\Pages\UserManagementPage;
use Carbon\Carbon;
use Livewire\Component;

class Navbar extends Component
{
    public $time;
    public $date;

    public $sidebarOpen = true;
    public $sidebarStatusOpen = true;

    public function render()
    {
        $this->showTime();
        return view('livewire.components.navbar');
    }

    public function toggleSidebar($sidebarOpen) {
        $this->sidebarOpen = !$this->sidebarOpen;
        $this->dispatch('change-sidebar-status', sidebarOpen: $sidebarOpen )->to(SupplierManagementPage::class);
        $this->dispatch('change-sidebar-status', sidebarOpen: $sidebarOpen )->to(UserManagementPage::class);
        $this->dispatch('change-sidebar-status', sidebarOpen: $sidebarOpen )->to(HomePage::class);
        $this->dispatch('change-sidebar-status', sidebarOpen: $sidebarOpen )->to(PurchaseAndDeliveryManagementPage::class);
        $this->dispatch('change-sidebar-status', sidebarOpen: $sidebarOpen )->to(Dashboard::class);
        $this->dispatch('change-sidebar-status', sidebarOpen: $sidebarOpen )->to(ItemManagementPage::class);
        $this->dispatch('change-sidebar-status', sidebarOpen: $sidebarOpen )->to(CustomerManagementPage::class);
        $this->dispatch('change-sidebar-status', sidebarOpen: $sidebarOpen )->to(InventoryManagementPage::class);
    }


    public function showTime()
    {
        $manilaTime = Carbon::now('Asia/Manila');

        $this->date = $manilaTime->format('F j, Y');
        $this->time = $manilaTime->format('h:i A');
    }


}
