<?php

namespace App\Livewire\Components\Sales;

use App\Models\Address;
use App\Models\Credit;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\PhilippineBarangay;
use App\Models\PhilippineCity;
use App\Models\PhilippineProvince;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\Rule;
use Livewire\Component;

use function Laravel\Prompts\alert;

class DiscountForm extends Component
{
    use LivewireAlert;
    public $isCreate = false;
    public $selectProvince = null;
    public $selectCity = null;
    public $selectBrgy = null;
    public $cities = null;
    public $barangays = null;

    public $firstname, $middlename, $lastname, $birthdate, $contact_number, $street, $searchCustomer, $customerType, $senior_pwd_id, $customer_id, $discount_percentage, $discounts, $discount_id, $customer_name;

    public $customerDetails = [];
    public $credit_details = [];

    public function render()
    {
        $this->discounts = Discount::whereIn('id', [1, 2, 3])->get()->keyBy('id');

        $searchCustomerTerm = trim($this->searchCustomer);

        $customers = Customer::where(function ($query) {
            $query->where('customer_type', '!=', 'Normal');
        })
            ->where(function ($query) use ($searchCustomerTerm) {
                $query->whereRaw('LOWER(firstname) like ?', ["%{$searchCustomerTerm}%"])
                    ->orWhereRaw('LOWER(middlename) like ?', ["%{$searchCustomerTerm}%"])
                    ->orWhereRaw('LOWER(lastname) like ?', ["%{$searchCustomerTerm}%"]);
            })
            ->get();

        return view('livewire.components.Sales.discount-form', [
            'provinces' => PhilippineProvince::orderBy('province_description')->get(),
            'customers' => $customers,
        ]);
    }

    protected $listeners = [

        'createConfirmed',
        'removeDiscountConfirmed',
        'get-credit-detail' => 'getCreditDetail'
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

    public function getCustomer($customer_id)
    {

        $customer = Customer::find($customer_id);
        $this->customer_name = $customer->firstname . ' ' . $customer->middlename . ' ' . $customer->lastname;
        $this->customer_id = $customer_id;
        $this->populateForm();

        if ($customer->customer_type == 'PWD') {
            $this->discount_percentage = $this->discounts[1]->percentage;
            $this->discount_id = $this->discounts[1]->id;
        } elseif ($customer->customer_type == 'Senior Citizen') {
            $this->discount_percentage = $this->discounts[2]->percentage;
            $this->discount_id = $this->discounts[2]->id;
        }
        $this->searchCustomer = '';
    }

    public function create() //* create process
    {

        // dd($isSales);
        // if (!$isSales && isset($this->credit_details['customer_id'])) {
        //     $customer = Customer::find($this->customer_id);
        //     $customer_name = $customer->firstname . ' ' . $customer->middlename . ' ' . $customer->lastname;

        //     $creditor = Customer::find($this->credit_details['customer_id']);
        //     $creditor_name = $creditor->firstname . ' ' . $creditor->middlename . ' ' . $creditor->lastname;

        //     if ($customer_name != $creditor_name) {
        //         $this->alert('error', 'Name doesnt match with the credit');
        //         return;
        //     } else {
        //         $this->populateForm();
        //     }
        // } else {
        //     $this->alert('warning', 'Select creditor');
        //     $this->clearSelectedCustomerName();
        //     return;
        // }


        $validated = $this->validateForm();

        $this->confirm('Do you want to create and apply the discount?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' => $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }

    public function createConfirmed($data) //* confirmation process ng create
    {


        $validated = $data['inputAttributes'];

        if ($this->isCreate) {
            $this->customerDetails = [
                'firstname' => $validated['firstname'],
                'middlename' => $validated['middlename'] ?? null,
                'lastname' => $validated['lastname'],
                'contact_number' => $validated['contact_number'],
                'birthdate' => $validated['birthdate'],
                'customer_type' => $validated['customerType'],
                'senior_pwd_id' => $validated['senior_pwd_id'],
                'discount_percentage' => $validated['discount_percentage'],
                'discount_id' => $this->discount_id,

                'province_code' => $validated['selectProvince'],
                'city_municipality_code' => $validated['selectCity'],
                'barangay_code' => $validated['selectBrgy'],
                'street' => $validated['street'],
            ];
        } else {
            $this->customerDetails = [
                'customer_type' => $validated['customerType'],
                'senior_pwd_id' => $validated['senior_pwd_id'],
                'customer_id' => $validated['customer_id'],
                'discount_percentage' => $validated['discount_percentage'],
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
        $this->clearSelectedCustomerName();
        $this->dispatch('get-customer-details', customerDetails: null)->to(SalesTransaction::class);
    }
    public function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        $this->reset(['customer_name','firstname', 'middlename', 'lastname', 'birthdate', 'contact_number', 'selectProvince', 'selectCity', 'selectBrgy', 'street', 'isCreate', 'customerType', 'senior_pwd_id', 'discount_percentage', 'searchCustomer']);
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
                'senior_pwd_id' => $customer_details->senior_pwd_id,

            ]);
        }
    }

    protected function validateForm()
    {


        if ($this->isCreate) {

            $this->firstname = trim($this->firstname);
            $this->middlename = $this->middlename ? trim($this->middlename) : null;
            $this->lastname = trim($this->lastname);

            $rules = [
                'firstname' => 'required|string|max:50|regex:/^[\p{L}\'\-\.]+(?: [\p{L}\'\-\.]+)*$/u', // Allow spaces between names
                'middlename' => 'nullable|string|max:50|regex:/^[\p{L}\'\-\.]+(?: [\p{L}\'\-\.]+)*$/u', // Allow spaces between names
                'lastname' => 'required|string|max:50|regex:/^[\p{L}\'\-\.]+(?: [\p{L}\'\-\.]+)*$/u',
                'contact_number' => 'required|numeric|digits:11',
                'selectProvince' => 'required|exists:philippine_provinces,province_code',
                'selectCity' => 'required|exists:philippine_cities,city_municipality_code',
                'selectBrgy' => 'required|exists:philippine_barangays,barangay_code',
                'street' => 'required|string|max:255',
                'discount_percentage' => 'required|numeric|min:1',
                'customerType' => 'required|in:PWD,Senior Citizen',
            ];

            if ($this->customerType == 'Senior Citizen') {
                $rules['senior_pwd_id'] = 'digits:4';
                $rules['birthdate'] = 'required|date|before_or_equal:' . now()->subYears(60)->toDateString();
            } elseif ($this->customerType == 'PWD') {
                $rules['senior_pwd_id'] = 'digits:7';
                $rules['birthdate'] = 'required|date|before_or_equal:' . now()->subYears(18)->toDateString();
            }
        } else {
            $rules = [
                'customerType' => 'required|in:PWD,Senior Citizen',
                'customer_id' => 'required|numeric',
                'discount_percentage' => 'required|numeric|min:1',
            ];

            if ($this->customerType == 'Senior Citizen') {
                $rules['senior_pwd_id'] = 'digits:4';
            } elseif ($this->customerType == 'PWD') {
                $rules['senior_pwd_id'] = 'digits:7';
            }
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

    public function clearSelectedCustomerName()
    {
        $this->reset(['customer_name', 'customerType', 'discount_percentage', 'senior_pwd_id', 'customerDetails', 'credit_details']);
    }
    public function getCreditDetail($creditDetail)
    {


        $this->resetForm();
        $this->removeDiscountConfirmed();
        $this->credit_details = $creditDetail;

        // dd($this->credit_details);
    }
}
