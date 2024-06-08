<?php

namespace App\Livewire\Components\UserManagement;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\On;

use function Laravel\Prompts\alert;

class UserForm extends Component
{
    public $show_password; //var true for show password false for hindi
    public $isCreate; //var true for create false for edit

    public $user_id;
    public $firstname;
    public $middlename;
    public $lastname;
    public $contact_number;
    public $role;
    public $status;
    public $username;
    public $password;
    public $retype_password;



    public function render()
    {
        // *tignan if yung id na pinasa from table is walang laman, pag may laman means sa edit form punta
        if ($this->user_id == null || $this->user_id == 0) {

            return view('livewire.components.UserManagement.user-form');
        } else {

            $this->populateForm();
            return view('livewire.components.UserManagement.user-form');
        }
    }


    public function create()
    {

        $validated = $this->validateForm();


        if ($this->isCreate) {
            $user = User::create([
                'firstname' => $validated['firstname'],
                'middlename' => $validated['middlename'],
                'lastname' => $validated['lastname'],
                'contact_number' => $validated['contact_number'],
                'user_role_id' => $validated['role'],
                'status' => $validated['status'],
                'username' => $validated['username'],
                'password' => Hash::make($validated['password'])
            ]);
        }

        $this->resetForm();
    }

    public function update()
    {
        $validated = $this->validateForm();

        $user = User::find($this->user_id); //? kunin lahat ng data ng may ari ng user_id

        //*pag hindi palitan ang password
        $user->firstname = $validated['firstname'];
        $user->middlename = $validated['middlename'];
        $user->lastname = $validated['lastname'];
        $user->contact_number = $validated['contact_number'];
        $user->user_role_id = $validated['role'];
        $user->status = $validated['status'];
        $user->username = $validated['username'];

        //*pag  palitan ang password
        if ($this->show_password) {
            $user->password = Hash::make($validated['password']);  //* gawing hash ang pass
        }

        $user->save();
        $this->resetForm();
    }

    private function resetForm() //*tanggalin ang laman ng input
    {
        $this->firstname = "";
        $this->middlename = "";
        $this->lastname = "";
        $this->contact_number = "";
        $this->role = "";
        $this->status = "";
        $this->username = "";
        $this->password = "";
        $this->retype_password = "";
        $this->user_id = "";  //*tanggalin ang id after mag update para matanggal ang laman ng edit form

    }


    private function populateForm() //*lagyan ng laman ang mga input
    {

        $user_details = User::find($this->user_id); //? kunin lahat ng data ng may ari ng user_id
        $this->firstname = $user_details->firstname;
        $this->middlename = $user_details->middlename;
        $this->lastname = $user_details->lastname;
        $this->contact_number = $user_details->contact_number;
        $this->role = $user_details->user_role_id;
        $this->status = $user_details->status;
        $this->username = $user_details->username;
    }

    protected function validateForm()
    {
        if ($this->isCreate) {   //*para sa create na validation
            return $this->validate([
                'firstname' => 'required|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'contact_number' => 'required|numeric|digits:11',
                'role' => 'required',
                'status' => 'required',

                //? validation sa username paro iignore ang user_id para maupdate ang username kahit unique
                'username' => 'required|string|max:255|unique:users,username',
                'password' => 'required|string|min:8|same:retype_password',
                'retype_password' => 'required|string|min:8',
            ]);
        } else {
            if ($this->show_password) { //*para sa edit na may passowrd na validation
                return $this->validate([
                    'firstname' => 'required|string|max:255',
                    'middlename' => 'nullable|string|max:255',
                    'lastname' => 'required|string|max:255',
                    'contact_number' => 'required|numeric|digits:11',
                    'role' => 'required',
                    'status' => 'required',

                    //? validation sa username paro iignore ang user_id para maupdate ang username kahit unique
                    'username' => 'required|string|max:255|unique:users,username,' . $this->user_id,
                    'password' => 'required|string|min:8|same:retype_password',
                    'retype_password' => 'required|string|min:8',
                ]);
            } else {

                return $this->validate([  //*para sa edit na walang passowrd na validation
                    'firstname' => 'required|string|max:255',
                    'middlename' => 'nullable|string|max:255',
                    'lastname' => 'required|string|max:255',
                    'contact_number' => 'required|numeric|digits:11',
                    'role' => 'required',
                    'status' => 'required',

                    //? validation sa username paro iignore ang user_id para maupdate ang username kahit unique
                    'username' => 'required|string|max:255|unique:users,username,' . $this->user_id,
                ]);
            }
        }
    }

    //*listeners

    #[On('edit-user-from-table')] //*name ng listener
    public function edit($userID) //@params parameter galing sa UserTable class
    {
        $this->user_id = $userID; //var assign ang parameter value sa global variable
    }


    #[On('change-method')] //*name ng listener
    public function changeMethod($isCreate) //@params parameter galing sa UserTable class,  laman false
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
