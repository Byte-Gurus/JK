<?php

namespace App\Livewire\Components\CustomerCreditManagement;

use App\Livewire\Pages\CustomerCreditMangementPage;
use App\Models\Address;
use App\Models\Customer;
use App\Models\PhilippineBarangay;
use App\Models\PhilippineCity;
use App\Models\PhilippineProvince;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CustomerCreditForm extends Component
{

    use WithFileUploads, LivewireAlert;
    public $isCreate; //var true for create false for edit

    public $selectProvince = null;
    public $selectCity = null;
    public $selectBrgy = null;
    public $cities = null;
    public $barangays = null;

    public $firstname, $middlename, $lastname, $birthdate, $contact_number, $street, $id_picture, $customer_type, $customer_discount_no ;

    public $proxy_customer_id, $customer_id;

    public function render()
    {
        return view('livewire.components.CustomerCreditManagement.customer-credit-form', [
            'provinces' => PhilippineProvince::orderBy('province_description')->get(),
        ]);
    }

    protected $listeners = [
        'edit-supplier-from-table' => 'edit',  //* key:'edit-supplier-from-table' value:'edit'  galing sa SupplierTable class
        //* key:'change-method' value:'changeMethod' galing sa SupplierTable class,  laman false
        'change-method' => 'changeMethod',
        'updateConfirmed',
        'createConfirmed',
    ];


    //* update hooks kung saan maguupdate ang selectCity if may napiling item sa selectProvince after ma rerender, hindi mag uupdate if hindi nakapag select sa selectProvince
    public function updatedSelectProvince($province_code) //@params province code for city query
    {

        $this->cities = PhilippineCity::where('province_code', $province_code)->orderBy('city_municipality_description')->get();
        //? i show sa selection ang mga city based sa province, hindi maglabas ang ibang city if hindi include sa province

    }

    //* update hooks kung saan maguupdate ang selectBaranagy if may napiling item sa selectCity after ma rerender, hindi mag uupdate if hindi nakapag select sa selectCity
    public function updatedSelectCity($city_municipality_code)
    {

        $this->barangays = PhilippineBarangay::where('city_municipality_code', $city_municipality_code)->orderBy('barangay_description')->get();
        //? i show sa selection ang mga barangay based sa city, hindi maglabas ang ibang city if hindi included sa city

    }


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
        $validated['id_picture'] = $this->id_picture->store('id_pictures', 'public');

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
            'address_id' => $address->id,
            'customer_type' => $validated['customer_type'],
            'customer_discount_no' => $validated['customer_discount_no'],
            'id_picture' => $validated['id_picture'],
        ]);


        $this->alert('success', 'Customer was created successfully');
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
            'id_picture' => 'nullable|image|max:20480',
            'customer_type' => 'required|in:Walk in, Credit, PWD, Senior Citizen, Wholesale',
            'customer_discount_no' => 'required|string|max:255',
        ];


        return $this->validate($rules);
    }

    public function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        $this->reset(['firstname', 'middlename', 'lastname', 'birthdate', 'contact_number', 'selectProvince', 'selectCity', 'selectBrgy', 'street', 'id_picture','customer_type',
        'customer_discount_no' ]);
    }

    public function changeMethod($isCreate)
    {

        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        if ($this->isCreate) {

            $this->resetForm();
        }
    }

    public function refreshTable() //* refresh ang table after confirmation
    {
        $this->dispatch('refresh-table')->to(CustomerCreditTable::class);
    }
    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(CustomerCreditMangementPage::class);
        $this->cities = null;
        $this->barangays = null;
    }

    public function edit($customerID)
    {
        $this->customer_id = $customerID; //var assign ang parameter value sa global variable
        $this->proxy_customer_id = $customerID;  //var proxy_supplier_id para sa update ng supplier kasi i null ang supplier id sa update afetr populating the form
    }
}
