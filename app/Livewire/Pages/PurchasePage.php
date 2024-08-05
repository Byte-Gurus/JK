<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class PurchasePage extends Component
{
    public $showModal = false;

    public function render()
    {
        return view('livewire.pages.purchase-page');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
    ];
}
