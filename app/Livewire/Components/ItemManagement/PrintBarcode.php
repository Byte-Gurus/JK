<?php

namespace App\Livewire\Components\ItemManagement;

use Livewire\Component;

class PrintBarcode extends Component
{

    public $displayPrintBarcode = true;
    public function render()
    {
        return view('livewire.components.ItemManagement.print-barcode');
    }

    public function togglePrintBarcode() {
        $this->displayPrintBarcode = !$this->displayPrintBarcode;
    }
}
