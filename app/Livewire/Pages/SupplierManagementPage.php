<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\SupplierManagement\SupplierForm;
use App\Livewire\Components\SupplierManagement\SupplierItemCostsForm;
use Livewire\Component;

class SupplierManagementPage extends Component
{

    public $showModal = false;

    public $showSupplierTable = true;

    public $showSupplierItemCosts = false;

    public $sidebarStatus;

    public function render()
    {
        return view('livewire.pages.supplier-management-page');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'change-sidebar-status' => 'changeSidebarStatus',
        'display-supplier-item-costs' => 'displaySupplierItemCosts',
        ];

    public function closeModal(){
        $this->showModal = false;
    }

    public function formCreate()
    {
        $this->dispatch('change-method', isCreate: true)->to(SupplierForm::class);
    }

    public function changeSidebarStatus($sidebarOpen)
    {
       $this->sidebarStatus = $sidebarOpen;
    }

    public function displaySupplierItemCosts()
    {
        $this->showSupplierTable = false;
        $this->showSupplierItemCosts = true;
    }

    public function returnToSupplierManagementPage()
    {
        $this->showSupplierTable = true;
        $this->showSupplierItemCosts = false;
    }
}
