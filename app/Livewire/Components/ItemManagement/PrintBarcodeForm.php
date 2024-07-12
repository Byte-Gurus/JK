<?php

namespace App\Livewire\Components\ItemManagement;

use App\Livewire\Pages\ItemManagementPage;
use Livewire\Component;

class PrintBarcodeForm extends Component
{
    public $barcode;

    public function render()
    {
        return view('livewire.components.ItemManagement.print-barcode-form');
    }

    protected $listeners = [
        'print-barcode-from-table' => 'printBarcode',
    ];

    public function printBarcode($barcode)
    {
        
        $this->barcode = $barcode['Barcode'];
    }
}
