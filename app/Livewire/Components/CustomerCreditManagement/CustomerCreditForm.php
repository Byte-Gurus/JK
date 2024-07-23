<?php

namespace App\Livewire\Components\CustomerCreditManagement;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CustomerCreditForm extends Component
{

    use WithFileUploads;
    public $isCreate; //var true for create false for edit

    #[Validate('image|max:1024')] // 1MB Max
    public $photo;


    public function render()
    {
        return view('livewire.components.CustomerCreditManagement.customer-credit-form');
    }

    protected $listeners = [
        'edit-supplier-from-table' => 'edit',  //* key:'edit-supplier-from-table' value:'edit'  galing sa SupplierTable class
        //* key:'change-method' value:'changeMethod' galing sa SupplierTable class,  laman false
        'change-method' => 'changeMethod',
        'updateConfirmed',
        'createConfirmed',
    ];

    public function save()
    {
        $this->photo->store(path: 'photos');
    }


    public function resetFormWhenClosed()
    {
        $this->resetValidation();
    }

    private function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        $this->reset([]);
    }

    public function changeMethod($isCreate)
    {

        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        if ($this->isCreate) {

            $this->resetForm();
        }
    }
}
