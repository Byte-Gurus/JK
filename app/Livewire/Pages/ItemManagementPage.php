<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\ItemManagement\ItemForm;
use Livewire\Component;

class ItemManagementPage extends Component
{


    public $showModal = false;
    public $showPrint = false;
    public $sidebarStatus;

    public $printBarcodeStatus;


    public function render()
    {
        return view('livewire.pages.item-management-page');
    }


    protected $listeners = [
        'close-modal' => 'closeModal',
        'close-print' => 'closePrint',
        'change-sidebar-status' => 'changeSidebarStatus',
        'print-barcode' => 'changePrintBarcodeStatus'
    ];

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function closePrint()
    {
        $this->showPrint = false;
    }

    public function formCreate()
    {
        $this->dispatch('change-method',  isCreate: true)->to(ItemForm::class);
        $this->dispatch('generate-barcode', isCreate: true)->to(ItemForm::class);
    }

    public function changeSidebarStatus($sidebarOpen)
    {
        $this->sidebarStatus = $sidebarOpen;
    }

    public function changePrintBarcodeStatus($printBarcodeOpen)
    {
        $this->printBarcodeStatus = $printBarcodeOpen;
    }
}
