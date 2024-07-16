<?php

namespace App\Livewire\Components\ItemManagement;

use Livewire\Component;

class PrintBarcode extends Component
{

    public $barcode;
    public $barcode_quantity;


    public function render()
    {
        return view('livewire.components.ItemManagement.print-barcode');
    }
    protected $listeners = [
        'get-print-information' => 'getPrintInformation',

    ];

    public function getPrintInformation($barcode_info){

        $this->barcode = $barcode_info['barcode'];
        $this->barcode_quantity = $barcode_info['barcode_quantity'];

        
    }
}
