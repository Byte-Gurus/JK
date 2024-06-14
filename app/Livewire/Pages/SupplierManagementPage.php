<?php

namespace App\Livewire\Pages;

use App\Livewire\Components\SupplierManagement\SupplierForm;
use Livewire\Component;

class SupplierManagementPage extends Component
{

    public $showModal = true;


    public function render()
    {
        return view('livewire.pages.supplier-management-page');
    }

    protected $listeners = [
        'close-modal' => 'closeModal'
        ];

    public function closeModal(){
        $this->showModal = false;
    }


    public function formCreate()
    {
        $this->dispatch('change-method', isCreate: true)->to(SupplierForm::class);
    }
}
