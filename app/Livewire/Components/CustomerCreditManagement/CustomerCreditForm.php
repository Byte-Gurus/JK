<?php

namespace App\Livewire\Components\CustomerCreditManagement;

use App\Livewire\Pages\CustomerCreditMangementPage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CustomerCreditForm extends Component
{

    use WithFileUploads;
    public $isCreate; //var true for create false for edit

    public $selectProvince = null;
    public $selectCity = null;
    public $selectBrgy = null;
    public $cities = null;
    public $barangays = null;

    public $firstname, $middlename, $lastname, $birthdate, $contact_number, $street, $photo;


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

    // public function save()
    // {
    //     $this->photo->store(path: 'photos');
    // }


    public function resetFormWhenClosed()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->cities = null;
        $this->barangays = null;
    }

    protected function validateForm()
    {
       

        $rules = [
             //? validation sa barcode paro iignore ang item_id para maupdate ang barcode kahit unique

            'photo' => 'nullable|image|max:20480',

        ];


        return $this->validate($rules);
    }

    public function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        $this->reset(['firstname', 'middlename', 'lastname', 'birthdate', 'contact_number', 'selectProvince', 'selectCity', 'selectBrgy', 'street', 'photo']);
    }

    public function changeMethod($isCreate)
    {

        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        if ($this->isCreate) {

            $this->resetForm();
        }
    }

    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(CustomerCreditMangementPage::class);
        $this->cities = null;
        $this->barangays = null;
    }
    public function test(){
        dd($this->photo);
    }

}
