<?php

namespace App\Livewire\Components\SupplierManagement;

use Livewire\Component;

class SupplierForm extends Component
{

    public $show_password; //var true for show password false for hindi
    public $isCreate; //var true for create false for edit

    //var form inputs
    public $user_id, $firstname, $middlename, $lastname, $contact_number, $role, $status, $username, $password, $retype_password;

    public function render()
    {
        return view('livewire.components.SupplierManagement.supplier-form');
    }

    //* assign all the listners in one array
    //* for methods
    protected $listeners = [
        'edit-user-from-table' => 'edit',  //* key:'edit-user-from-table' value:'edit'  galing sa UserTable class
        //* key:'change-method' value:'changeMethod' galing sa UserTable class,  laman false
        'change-method' => 'changeMethod',
        'updateConfirmed',
        'createConfirmed',
    ];


    public function edit($userID)
    {
        $this->user_id = $userID; //var assign ang parameter value sa global variable
    }

    private function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        $this->reset(['firstname', 'middlename', 'lastname', 'contact_number', 'role', 'status', 'username', 'password', 'retype_password', 'user_id']);
    }

    //* pag iclose ang form using close hindi natatanggal ang validation, this method resets form input and validation
    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }


    public function changeMethod($isCreate)
    {

        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        //* kapag true ang laman ng $isCreate mag reset ang form then  go to create form and ishow ang password else hindi ishow
        if ($this->isCreate) {

            $this->resetForm();
            $this->show_password = true;
        } else {
            $this->show_password = false;
        }
    }
}
