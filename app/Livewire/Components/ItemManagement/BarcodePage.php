<?php

namespace App\Livewire\Components\ItemManagement;

use Livewire\Component;

class BarcodePage extends Component
{
    public $barcode_quantity;
    public $barcode;


    public function render()
    {

        return view('livewire.components.ItemManagement.barcode-page');
    }

    protected $listeners = [
        'pass-barcode-from-barcode-form' => 'getBarcode'
    ];

    public function getBarcode($barcode, $barcode_quantity)
    {

        $this->barcode_quantity = $barcode_quantity;
        $this->barcode = $barcode;
    }
}
