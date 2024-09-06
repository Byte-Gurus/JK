<?php

namespace App\Livewire\Components\Sales;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\PhilippineBarangay;
use App\Models\PhilippineCity;
use App\Models\PhilippineProvince;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\Rule;
use Livewire\Component;

class DiscountForm extends Component
{
    use LivewireAlert;
    public $isCreate = false;
    public $selectProvince = null;
    public $selectCity = null;
    public $selectBrgy = null;
    public $cities = null;
    public $barangays = null;

    public $firstname, $middlename, $lastname, $birthdate, $contact_number, $street, $selectCustomer, $customerType, $customer_discount_no, $customer_id, $discount_percentage, $discounts, $discount_id;
    public $customerDetails = [];

    public function render()
    {
        $this->discounts = Discount::whereIn('id', [1, 2, 3])->get()->keyBy('id');

        $customers = Customer::where('customer_type', 'PWD')
            ->orWhere('customer_type', 'Senior CItizen')->get();

        return view('livewire.components.sales.discount-form', [
            'provinces' => PhilippineProvince::orderBy('province_description')->get(),
            'customers' => $customers,
        ]);
    }

    protected $listeners = [

        'createConfirmed',
        'removeDiscountConfirmed',
    ];

    public function updatedCustomerType($customer_type) //@params province code for city query
    {



        if ($this->customerType == 'PWD') {
            $this->discount_percentage = $this->discounts[1]->percentage;
            $this->discount_id = $this->discounts[1]->id;
        } elseif ($this->customerType == 'Senior Citizen') {
            $this->discount_percentage = $this->discounts[2]->percentage;
            $this->discount_id = $this->discounts[2]->id;
        }
    }
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

    public function updatedSelectCustomer($customer_id)
    {
        if (!$customer_id) {

            $this->reset();
            return;
        }
        $customer = Customer::find($customer_id);
        $this->customer_id = $customer_id;
        $this->populateForm();

        if ($customer->customer_type == 'PWD') {
            $this->discount_percentage = $this->discounts[1]->percentage;
            $this->discount_id = $this->discounts[1]->id;
        } elseif ($customer->customer_type == 'Senior Citizen') {
            $this->discount_percentage = $this->discounts[2]->percentage;
            $this->discount_id = $this->discounts[2]->id;
        }
    }

    public function create() //* create process
    {

        $validated = $this->validateForm();

        $this->confirm('Do you want to create and apply the discount?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' =>  $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }

    public function createConfirmed($data) //* confirmation process ng create
    {


        $validated = $data['inputAttributes'];

        if ($this->isCreate) {
            $this->customerDetails = [
                'firstname' => $validated['firstname'],
                'middlename' => $validated['middlename'],
                'lastname' => $validated['lastname'],
                'contact_number' => $validated['contact_number'],
                'birthdate' => $validated['birthdate'],
                'customer_type' => $validated['customerType'],
                'customer_discount_no' => $validated['customer_discount_no'],
                'discount_percentage' =>  $validated['discount_percentage'],
                'discount_id' => $this->discount_id,

                'province_code' => $validated['selectProvince'],
                'city_municipality_code' => $validated['selectCity'],
                'barangay_code' => $validated['selectBrgy'],
                'street' => $validated['street'],
            ];
        } else {
            $this->customerDetails = [
                'customer_type' => $validated['customerType'],
                'customer_discount_no' => $validated['customer_discount_no'],
                'customer_id' =>  $validated['customer_id'],
                'discount_percentage' =>  $validated['discount_percentage'],
                'discount_id' => $this->discount_id,
            ];
        }




        $this->dispatch('get-customer-details', customerDetails: $this->customerDetails)->to(SalesTransaction::class);
        $this->dispatch('display-discount-form')->to(SalesTransaction::class);

        //   $this->closeModal();
    }
    public function removeDiscount()
    {

        $this->confirm('Do you want to remove this discount?', [
            'onConfirmed' => 'removeDiscountConfirmed', //* call the createconfirmed method
        ]);
    }

    public function removeDiscountConfirmed()
    {
        $this->resetForm();

        $this->dispatch('get-customer-details', customerDetails: null)->to(SalesTransaction::class);
    }
    public function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        $this->reset(['firstname', 'middlename', 'lastname', 'birthdate', 'contact_number', 'selectProvince', 'selectCity', 'selectBrgy', 'street', 'isCreate', 'customerType', 'customer_discount_no', 'discount_percentage', 'selectCustomer']);
    }
    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }

    private function populateForm() //*lagyan ng laman ang mga input
    {

        $customer_details = Customer::find($this->customer_id); //? kunin lahat ng data ng may ari ng item_id

        //* ipasa ang laman ng model sa inputs
        //* fill() method [key => value] means [paglalagyan => ilalagay]
        if ($this->customer_id) {

            $this->fill([
                'customerType' => $customer_details->customer_type,
                'customer_discount_no' => $customer_details->customer_discount_no,

            ]);
        }
    }

    protected function validateForm()
    {


        if ($this->isCreate) {

            $this->firstname = trim($this->firstname);
            $this->middlename = trim($this->middlename);
            $this->lastname = trim($this->lastname);

            $rules = [
                'firstname' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
                'middlename' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
                'lastname' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
                'birthdate' => 'required|string|max:255',
                'contact_number' => ['required', 'numeric', 'digits:11', Rule::unique('customers', 'contact_number')],
                'selectProvince' => 'required|exists:philippine_provinces,province_code',
                'selectCity' => 'required|exists:philippine_cities,city_municipality_code',
                'selectBrgy' => 'required|exists:philippine_barangays,barangay_code',
                'street' => 'required|string|max:255',
                'customerType' => 'required|in:PWD,Senior Citizen',
                'customer_discount_no' => 'required|string|max:255',
                'discount_percentage' => 'required|numeric|min:0',
            ];
        } else {
            $rules = [
                'customerType' => 'required|in:PWD,Senior Citizen',
                'customer_discount_no' => 'required|string|max:255',
                'customer_id' => 'required|numeric',
                'discount_percentage' => 'required|numeric|min:0',
            ];
        }

        return $this->validate($rules);
    }

    public function createCustomer()
    {
        $this->resetForm();
        $this->isCreate = !$this->isCreate;
    }

    public function returnToDiscountForm()
    {
        $this->isCreate = !$this->isCreate;
    }
}
