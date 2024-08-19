<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class DeliveryPage extends Component
{

    public $showRestockForm = false;
    public function render()
    {
        return view('livewire.pages.delivery-page');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'display-restock-form' => 'displayRestockForm'
    ];

    public function displayRestockForm($showRestockForm)
    {
        $this->showRestockForm = $showRestockForm;
    }
}
