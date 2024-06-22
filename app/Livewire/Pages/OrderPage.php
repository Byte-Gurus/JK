<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class OrderPage extends Component
{
    public $showModal = false;

    public function render()
    {
        return view('livewire.pages.order-page');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
    ];
}
