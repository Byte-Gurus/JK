<?php

namespace App\Livewire\Components\ItemManagement;

use App\Livewire\Pages\ItemManagementPage;
use Livewire\Component;

class PrintBarcodeForm extends Component
{

    public function render()
    {
        return view('livewire.components.ItemManagement.print-barcode-form');
    }

    public function closePrint() //* close ang modal after confirmation
    {
        $this->dispatch('close-print')->to(ItemManagementPage::class);
    }
}

