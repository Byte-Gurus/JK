<?php

namespace App\Livewire\Components\CustomerCreditManagement;

use App\Livewire\Pages\CustomerCreditMangementPage;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Validation\Rule;
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

        $address = Address::create([
            'province_code' => $validated['selectProvince'],
            'city_municipality_code' => $validated['selectCity'],
            'barangay_code' => $validated['selectBrgy'],
            'street' => $validated['street'],
        ]);

        $customer = Customer::create([
            'firstname' => $validated['firstname'],
            'middlename' => $validated['middlename'],
            'lastname' => $validated['lastname'],
            'contact_number' => $validated['contact_number'],
            'birthdate' => $validated['birthdate'],
            'address_id' => $address->id

        ]);


        $this->alert('success', 'User was created successfully');
        $this->refreshTable();

        $this->resetForm();
        $this->closeModal();
    }



    public function resetFormWhenClosed()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->cities = null;
        $this->barangays = null;
    }

    protected function validateForm()
    {

        $this->firstname = trim($this->firstname);
        $this->middlename = trim($this->middlename);
        $this->lastname = trim($this->lastname);

        $rules = [
            'firstname' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'middlename' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'lastname' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'birthdate' => 'required|string|max:255',
            'contact_number' => ['required', 'numeric', 'digits:11', Rule::unique('customers', 'contact_number')->ignore($this->proxy_customer_id)],
            'selectProvince' => 'required|exists:philippine_provinces,province_code',
            'selectCity' => 'required|exists:philippine_cities,city_municipality_code',
            'selectBrgy' => 'required|exists:philippine_barangays,barangay_code',
            'street' => 'required|string|max:255',
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
