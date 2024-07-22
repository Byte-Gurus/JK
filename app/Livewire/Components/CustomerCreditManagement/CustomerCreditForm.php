<?php

namespace App\Livewire\Components\CustomerCreditManagement;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CustomerCreditForm extends Component
{

    use WithFileUploads;

    #[Validate('image|max:1024')] // 1MB Max
    public $photo;
    public $isCreate; //var true for create false for edit

    public function save()
    {
        $this->photo->store(path: 'photos');
    }
    public function render()
    {
        return view('livewire.components.CustomerCreditManagement.customer-credit-form');
    }
    protected $listeners = [
        'edit-user-from-table' => 'edit',  //* key:'edit-user-from-table' value:'edit'  galing sa UserTable class
        //* key:'change-method' value:'changeMethod' galing sa UserTable class,  laman false
        'change-method' => 'changeMethod',
        'updateConfirmed',
        'createConfirmed',
    ];

    public function resetFormWhenClosed()
    {
        $this->resetValidation();
    }

    public function changeMethod($isCreate)
    {

        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        //* kapag true ang laman ng $isCreate mag reset ang form then  go to create form and ishow ang password else hindi ishow
        if ($this->isCreate) {
        } else {
        }
    }
}
