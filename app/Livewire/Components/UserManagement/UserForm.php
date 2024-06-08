<?php

namespace App\Livewire\Components\UserManagement;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\On;
class UserForm extends Component
{
    public $show_password;
    public $isCreate;
    //true for create false for edit
    public $user_id;
    public $firstname ;
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
        if($this->user_id == null || $this->user_id == 0){

            return view('livewire.components.UserManagement.user-form');
        }
        else{
            $this->populateForm();
            return view('livewire.components.UserManagement.user-form');
        }
    }


    public function create()
    {

        $validated = $this->validateForm();


        if($this->isCreate){
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
        }else{
            //update code here
            dd("lagyan mo code pang update");
            if($this->show_password){

            }else{

            }

        }

        $this->resetForm();

        // session()->flash('success', 'User created successfully!');
    }

    private function resetForm(){
        $this->firstname ="";
        $this->middlename = "";
        $this->lastname = "";
        $this->contact_number = "";
        $this->role = "";
        $this->status = "";
        $this->username = "";
        $this->password = "";
        $this->retype_password = "";
    }


    private function populateForm()
    {
        $this->resetForm();
        $user_details = User::find($this->user_id);
        $this->firstname =$user_details->firstname;
        $this->middlename =$user_details->middlename;
        $this->lastname =$user_details->lastname;
        $this->contact_number =$user_details->contact_number;
        $this->role =$user_details->user_role_id;
        $this->status =$user_details->status;
        $this->username =$user_details->username;
    }

    protected function validateForm()
    {
        if($this->isCreate){
            // dd("pangcreate");
            return $this->validate([
                'firstname' => 'required|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'contact_number' => 'required|numeric',
                'role' => 'required',
                'status' => 'required',
                'username' => 'required|string|max:255|unique:users,username',
                'password' => 'required|string|min:8|same:retype_password',
                'retype_password' => 'required|string|min:8',
            ]);
        }else{
           if($this->show_password){
            // dd("edit pero may password");
                return $this->validate([
                    'firstname' => 'required|string|max:255',
                    'middlename' => 'nullable|string|max:255',
                    'lastname' => 'required|string|max:255',
                    'contact_number' => 'required|numeric',
                    // 'contact_number' => 'required|numeric|min:11|max:11',
                    'role' => 'required',
                    'status' => 'required',
                    'username' => 'required|string|max:255|unique:users,username,'.$this->user_id,
                    'password' => 'required|string|min:8|same:retype_password',
                    'retype_password' => 'required|string|min:8',
                ]);
           }else{
            // dd("edit pero walang password");
            return $this->validate([
                'firstname' => 'required|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'contact_number' => 'required|numeric',
                // 'contact_number' => 'required|numeric|min:11|max:11',
                'role' => 'required',
                'status' => 'required',
                'username' => 'required|string|max:255|unique:users,username,'.$this->user_id,
            ]);
           }
        }
    }

    //listeners
    #[On('edit-user-from-table')]
    public function edit($userID)
    {

        $this->user_id = $userID;
    }
    #[On('change-method')]
public function changeMethod($isCreate)
    {

        $this->isCreate = $isCreate;
        if($this->isCreate){
        $this->resetForm();
           $this->show_password = true;

        }else{
           $this->show_password = false;
        }
    }
}
