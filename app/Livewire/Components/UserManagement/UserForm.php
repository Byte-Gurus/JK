<?php

namespace App\Livewire\Components\UserManagement;


use App\Livewire\Pages\UserManagementPage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;


class UserForm extends Component
{
    use LivewireAlert;
    public $show_password; //var true for show password false for hindi
    public $isCreate; //var true for create false for edit


    //var form inputs
    public $user_id, $firstname, $middlename, $lastname, $contact_number, $role, $status, $username, $password, $retype_password;
    public $image_path = null;

    public function render()
    {
        // *tignan if yung id na pinasa from table is walang laman, pag may laman means mag populate then sa edit form punta
        if ($this->user_id) {
            $this->populateForm();
        }
        return view('livewire.components.UserManagement.user-form');
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



    public function create() //* create process
    {

        $validated = $this->validateForm();


        $this->confirm('Do you want to add this user?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' =>  $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }




    public function createConfirmed($data) //* confirmation process ng create
    {

        $validated = $data['inputAttributes'];

        $user = User::create([
            'firstname' => $validated['firstname'],
            'middlename' => $validated['middlename'],
            'lastname' => $validated['lastname'],
            'contact_number' => $validated['contact_number'],
            'user_role_id' => $validated['role'],
            'status_id' => $validated['status'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'image_path' => $validated['image_path']
        ]);


        $this->alert('success', 'User was created successfully');
        $this->refreshTable();

        $this->resetForm();
        $this->closeModal();
    }



    public function refreshTable() //* refresh ang table after confirmation
    {
        $this->dispatch('refresh-table')->to(UserTable::class);
    }



    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(UserManagementPage::class);
    }




    public function update() //* update process
    {
        $validated = $this->validateForm();


        $user = User::find($this->user_id); //? kunin lahat ng data ng may ari ng user_id

        //*pag hindi palitan ang password
        //* ipasa ang laman ng validated inputs sa models
        $user->firstname = $validated['firstname'];
        $user->middlename = $validated['middlename'];
        $user->lastname = $validated['lastname'];
        $user->contact_number = $validated['contact_number'];
        $user->user_role_id = $validated['role'];
        $user->status_id = $validated['status'];
        $user->username = $validated['username'];


        $attributes = $user->toArray(); //var ilagay sa array ang model before i add ang password sa array kasi hindi ni reretrieve ang hashed password sa toArray() method

        //*pag palitan ang password
        //* staka palang ilagay ang hashed password kapag may array na
        if ($this->show_password) {
            $attributes['password'] = Hash::make($validated['password']);  //var gawing hash ang pass
        }

        $this->confirm('Do you want to update this user?', [
            'onConfirmed' => 'updateConfirmed', //* call the confmired method
            'inputAttributes' =>  $attributes, //* pass the $attributes array to the confirmed method
        ]);
    }



    public function updateConfirmed($data) //* confirmation process ng update
    {


        //var sa loob ng $data array, may array pa ulit (inputAttributes), extract the inputAttributes then assign the array to a variable array
        $updatedAttributes = $data['inputAttributes'];

        //* hanapin id na attribute sa $updatedAttributes array
        $user = User::find($updatedAttributes['id']);

        //* fill() method [key => value] means [paglalagyan => ilalagay]
        //* the fill() method automatically knows kung saan ilalagay ang elements as long as mag match ang mga keys, $users have same keys with $updatedAttributes array
        //var ipasa ang laman ng $updatedAttributes sa $user model
        $user->fill($updatedAttributes);

        $user->save(); //* Save the user model to the database

        $this->resetForm();
        $this->alert('success', 'User was updated successfully');

        $this->refreshTable();
        $this->closeModal();
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




    private function populateForm() //*lagyan ng laman ang mga input
    {

        $user_details = User::find($this->user_id); //? kunin lahat ng data ng may ari ng user_id

        //* ipasa ang laman ng model sa inputs
        //* fill() method [key => value] means [paglalagyan => ilalagay]
        $this->fill([
            'firstname' => $user_details->firstname,
            'middlename' => $user_details->middlename,
            'lastname' => $user_details->lastname,
            'contact_number' => $user_details->contact_number,
            'role' => $user_details->user_role_id,
            'status' => $user_details->status_id,
            'username' => $user_details->username,
        ]);
    }


    protected function validateForm()
    {
        $this->firstname = trim($this->firstname);
        $this->middlename = trim($this->middlename);
        $this->lastname = trim($this->lastname);
        $this->username = trim($this->username);
        $this->password = trim($this->password);
        $this->retype_password = trim($this->retype_password);

        $rules = [
            'firstname' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'middlename' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'lastname' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'contact_number' => ['required', 'numeric', 'digits:11', Rule::unique('users', 'contact_number')->ignore($this->user_id)],
            'role' => 'required|in:1,2,3',
            'status' => 'required|in:1,2',

            //? validation sa username paro iignore ang user_id para maupdate ang username kahit unique
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($this->user_id)],

        ];

        //*para sa create na validation or //*para sa edit na may passowrd na validation
        if ($this->isCreate || $this->show_password) {

            $rules['password'] = 'required|string|min:8|same:retype_password';
            $rules['retype_password'] = 'required|string|min:8';
        }

        return $this->validate($rules);
    }



    public function edit($userID)
    {
        $this->user_id = $userID; //var assign ang parameter value sa global variable
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
