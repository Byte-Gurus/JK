<?php

namespace App\Livewire\Components\CustomerManagement;

use App\Events\CustomerEvent;
use App\Livewire\Pages\CustomerManagementPage;
use App\Models\Address;
use App\Models\Customer;
use App\Models\PhilippineBarangay;
use App\Models\PhilippineCity;
use App\Models\PhilippineProvince;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Str;

class CustomerForm extends Component
{
    use WithFileUploads, LivewireAlert;
    public $isCreate; //var true for create false for edit

    public $selectProvince = null;
    public $selectCity = null;
    public $selectBrgy = null;
    public $cities = null;
    public $barangays = null;

    public $firstname, $middlename, $lastname, $birthdate, $contact_number, $street, $id_picture, $customertype, $senior_pwd_id, $imageUrl;

    public $proxy_customer_id, $customer_id;
    public function render()
    {
        return view('livewire.components.customer-management.customer-form', [
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

    public function updatedCustomertype()
    {
        $this->senior_pwd_id = null;
    }

    public function removeSelectedPicture()
    {
        $this->reset(['id_picture']);
    }


    public function create() //* create process
    {
        $validated = $this->validateForm();

        $this->confirm('Do you want to add this customer?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' => $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }

    public function createConfirmed($data) //* confirmation process ng create
    {


        $validated = $data['inputAttributes'];

        DB::beginTransaction();

        try {
            if ($this->id_picture) {
                // Validate and store the uploaded file temporarily
                $path = $this->id_picture->store('temp'); // This stores the file in the 'temp' directory temporarily

                // Generate a new filename
                $filename = Str::random(40) . '.' . $this->id_picture->getClientOriginalExtension();

                // Get the contents of the file
                $fileContents = Storage::disk('local')->get($path);

                // Store the file on S3
                $isStored = Storage::disk('s3')->put($filename, $fileContents);

                // Optionally delete the temporary file
                Storage::disk('local')->delete($path);

                $validated['id_picture'] = Storage::disk('s3')->url($filename);
            } else {
                $validated['id_picture'] = null; // or provide a default value if necessary
            }



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
                'customer_type' => $validated['customertype'],
                'senior_pwd_id' => $validated['senior_pwd_id'],
                'id_picture' => $validated['id_picture'],
            ]);

            DB::commit();

            $this->alert('success', 'Customer was created successfully');
            $this->refreshTable();
            CustomerEvent::dispatch('refresh-customer');
            $this->resetForm();
            $this->closeModal();

        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            DB::rollback();
            $this->alert('error', 'An error occurred while creating the Customer, please refresh the page ');
        }


    }

    public function update() //* update process
    {
        $validated = $this->validateForm();


        $customers = Customer::find($this->proxy_customer_id); //? kunin lahat ng data ng may ari ng proxy_supplier_id


        //* ipasa ang laman ng validated inputs sa models
        $customers->firstname = $validated['firstname'];
        $customers->middlename = $validated['middlename'];
        $customers->lastname = $validated['lastname'];
        $customers->birthdate = $validated['birthdate'];
        $customers->contact_number = $validated['contact_number'];
        $customers->id_picture = $validated['id_picture'] ?? null;
        $customers->customer_type = $validated['customertype'];
        $customers->senior_pwd_id = $validated['senior_pwd_id'] ?? null;
        $customers->province_code = $validated['selectProvince'];
        $customers->city_municipality_code = $validated['selectCity'];
        $customers->barangay_code = $validated['selectBrgy'];
        $customers->street = $validated['street'];

        $attributes = $customers->toArray();



        $this->confirm('Do you want to update this customer?', [
            'onConfirmed' => 'updateConfirmed', //* call the confmired method
            'inputAttributes' => $attributes, //* pass the $attributes array to the confirmed method
        ]);
    }

    public function updateConfirmed($data) //* confirmation process ng update
    {
        $updatedAttributes = $data['inputAttributes'];

        DB::beginTransaction();

        try {
            $customer = Customer::find($updatedAttributes['id']);
            $address = Address::find($updatedAttributes['address_id']);

            if (!$customer || !$address) {

                DB::rollback();
                $this->alert('error', 'Customer not found.');
                return; // Exit the method

            }
            if ($this->id_picture) {

                // Validate and store the uploaded file temporarily
                $path = $this->id_picture->store('temp'); // This stores the file in the 'temp' directory temporarily

                // Generate a new filename
                $filename = Str::random(40) . '.' . $this->id_picture->getClientOriginalExtension();

                // Get the contents of the file
                $fileContents = Storage::disk('local')->get($path);

                // Store the file on S3
                $isStored = Storage::disk('s3')->put($filename, $fileContents);

                // Optionally delete the temporary file
                Storage::disk('local')->delete($path);

                $updatedAttributes['id_picture'] = Storage::disk('s3')->url($filename);
            }

            $address->fill([
                'province_code' => $updatedAttributes['province_code'],
                'city_municipality_code' => $updatedAttributes['city_municipality_code'],
                'barangay_code' => $updatedAttributes['barangay_code'],
                'street' => $updatedAttributes['street'],
            ]);
            $address->save();

            $customer->fill([
                'firstname' => $updatedAttributes['firstname'],
                'middlename' => $updatedAttributes['middlename'],
                'lastname' => $updatedAttributes['lastname'],
                'contact_number' => $updatedAttributes['contact_number'],
                'birthdate' => $updatedAttributes['birthdate'],
                'address_id' => $address->id ?? null,
                'customer_type' => $updatedAttributes['customer_type'],
                'senior_pwd_id' => $updatedAttributes['senior_pwd_id'] ?? null,
                'id_picture' => $updatedAttributes['id_picture'] ?? $customer->id_picture,
            ]);
            $customer->save();

            DB::commit();

            $this->resetForm();
            $this->alert('success', 'Customer was updated successfully');
            CustomerEvent::dispatch('refresh-customer');
            $this->refreshTable();
            $this->closeModal();

        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            DB::rollback();
            $this->alert('error', 'An error occurred while updating the Customer, please refresh the page ');
        }


    }

    private function populateForm() //*lagyan ng laman ang mga input
    {

        $customer_details = Customer::find($this->customer_id); //? kunin lahat ng data ng may ari ng user_id


        //* ipasa ang laman ng model sa inputs
        //* fill() method [key => value] means [paglalagyan => ilalagay]
        $this->fill([
            'firstname' => $customer_details->firstname,
            'middlename' => $customer_details->middlename ?? null,
            'lastname' => $customer_details->lastname,
            'birthdate' => $customer_details->birthdate,
            'contact_number' => $customer_details->contact_number,
            // 'id_picture' => $customer_details->id_picture ?? null,
            'imageUrl' => $customer_details->id_picture ?? null,
            'customertype' => $customer_details->customer_type,
            'senior_pwd_id' => $customer_details->senior_pwd_id ?? null,
            'selectProvince' => $customer_details->addressJoin->province_code,
            'selectCity' => $customer_details->addressJoin->city_municipality_code,
            'selectBrgy' => $customer_details->addressJoin->barangay_code,
            'street' => $customer_details->addressJoin->street,
        ]);

        //todo nag ccause to ng bug, ang bug is sa unang render upadte supplier form, hindi makapag select sa City and barangay, but if mag punta sa create supplier then edit then mag render na sya
        //todo option 1 tanggalin ito para hindi mapopolate ang selectCity and SelectBarangay sa second render ng form
        //todo option 2 hayaan nalang at mag select nalang si user ng city and brgy ulit everytime mag update kasi idk pano aayusin
        $this->cities = PhilippineCity::where('province_code', $customer_details->addressJoin->province_code)->orderBy('city_municipality_description')->get();
        $this->barangays = PhilippineBarangay::where('city_municipality_code', $customer_details->addressJoin->city_municipality_code)->orderBy('barangay_description')->get();
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
        $this->middlename = $this->middlename ? trim($this->middlename) : null;

        $this->lastname = trim($this->lastname);

        $rules = [
            'firstname' => 'required|string|max:50|regex:/^[\p{L}\'\-\.]+(?: [\p{L}\'\-\.]+)*$/u', // Allow spaces between names
            'middlename' => 'nullable|string|max:50|regex:/^[\p{L}\'\-\.]+(?: [\p{L}\'\-\.]+)*$/u', // Allow spaces between names
            'lastname' => 'required|string|max:50|regex:/^[\p{L}\'\-\.]+(?: [\p{L}\'\-\.]+)*$/u',
            'contact_number' => 'required|numeric|digits:11|regex:/^09[0-9]{9}$/',
            'selectProvince' => 'required|exists:philippine_provinces,province_code',
            'selectCity' => 'required|exists:philippine_cities,city_municipality_code',
            'selectBrgy' => 'required|exists:philippine_barangays,barangay_code',
            'street' => 'required|string|max:255',
            'id_picture' => 'nullable|image|max:20480',
            'customertype' => 'required|in:Normal,PWD,Senior Citizen,Wholesale',

        ];

        if ($this->customertype == 'Senior Citizen') {
            $sixtyYearsAgo = now()->subYears(60)->format('Y-m-d');
            $rules['birthdate'] = 'required|date|before_or_equal:'. now()->subYears(60)->toDateString();
            $rules['senior_pwd_id'] = 'digits:4';
        } elseif ($this->customertype == 'PWD') {
            $eighteenYearsAgo = now()->subYears(18)->format('Y-m-d');
            $rules['birthdate'] = 'required|date|before_or_equal:' .now()->subYears(18)->toDateString();
            $rules['senior_pwd_id'] = 'digits:7';
        } elseif ($this->customertype == 'Normal') {
            $eighteenYearsAgo = now()->subYears(18)->format('Y-m-d');
            $rules['birthdate'] = 'required|date|before_or_equal:' .now()->subYears(18)->toDateString();
            $rules['senior_pwd_id'] = 'nullable|string|max:255';
        }


        return $this->validate($rules);
    }

    public function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        $this->reset([
            'firstname',
            'middlename',
            'lastname',
            'birthdate',
            'contact_number',
            'selectProvince',
            'selectCity',
            'selectBrgy',
            'street',
            'id_picture',
            'customertype',
            'senior_pwd_id',
            'imageUrl'
        ]);
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
        $this->dispatch('refresh-table')->to(CustomerTable::class);
    }
    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(CustomerManagementPage::class);
        $this->resetValidation();
        $this->cities = null;
        $this->barangays = null;
    }

    public function edit($customerID)
    {
        $this->customer_id = $customerID; //var assign ang parameter value sa global variable
        $this->proxy_customer_id = $customerID;  //var proxy_supplier_id para sa update ng supplier kasi i null ang supplier id sa update afetr populating the form

        $this->populateForm();

        $customer = Customer::find($customerID);

    }
}
