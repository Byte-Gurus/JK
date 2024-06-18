<?php

namespace App\Livewire\Components\SupplierManagement;

use App\Livewire\Pages\SupplierManagementPage;
use App\Models\PhilippineBarangay;
use App\Models\PhilippineCity;
use App\Models\PhilippineProvince;
use App\Models\PhilippineRegion;
use App\Models\Supplier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class SupplierForm extends Component
{
    use LivewireAlert;

    public $isCreate; //var true for create false for edit

    public $selectProvince = null;
    public $selectCity = null;
    public $selectBrgy = null;

    public $cities = null;
    public $barangays = null;
    //var form inputs
    public $supplier_id, $company_name, $contact_number, $street;

    public function render()
    {
        if ($this->supplier_id) {
            $this->populateForm();
        }

        return view('livewire.components.SupplierManagement.supplier-form', [
            'provinces' => PhilippineProvince::orderBy('province_description')->get(),
        ]);
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

    public function updatedSelectProvince($province_code)
    {

        $this->cities = PhilippineCity::where('province_code', $province_code)->orderBy('city_municipality_description')->get();
    }

    public function updatedSelectCity($city_municipality_code)
    {

        $this->barangays = PhilippineBarangay::where('city_municipality_code', $city_municipality_code)->orderBy('barangay_description')->get();
    }

    public function create() //* create process
    {

        $validated = $this->validateForm();

        $this->confirm('Do you want to add this supplier?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' =>  $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }
    public function createConfirmed($data) //* confirmation process ng create
    {

        $validated = $data['inputAttributes'];

        $user = Supplier::create([
            'company_name' => $validated['company_name'],
            'contact_number' => $validated['contact_number'],
            'province_code' => $validated['selectProvince'],
            'city_municipality_code' => $validated['selectCity'],
            'barangay_code' => $validated['selectBrgy'],
            'street' => $validated['street'],
        ]);


        $this->alert('success', 'Supplier was created successfully');
        $this->refreshTable();

        $this->resetForm();
        $this->closeModal();
    }

    public function update() //* update process
    {
        $validated = $this->validateForm();


        $supplier = Supplier::find($this->supplier_id); //? kunin lahat ng data ng may ari ng user_id

        //*pag hindi palitan ang password
        //* ipasa ang laman ng validated inputs sa models
        $supplier->company_name = $validated['company_name'];
        $supplier->contact_number = $validated['contact_number'];
        $supplier->province_code = $validated['selectProvince'];
        $supplier->city_municipality_code = $validated['selectCity'];
        $supplier->barangay_code = $validated['selectBrgy'];
        $supplier->street = $validated['street'];

        $attributes = $supplier->toArray(); //var ilagay sa array ang model before i add ang password sa array kasi hindi ni reretrieve ang hashed password sa toArray() method


        $this->confirm('Do you want to update this user??', [
            'onConfirmed' => 'updateConfirmed', //* call the confmired method
            'inputAttributes' =>  $attributes, //* pass the $attributes array to the confirmed method
        ]);
    }

    public function updateConfirmed($data) //* confirmation process ng update
    {


        //var sa loob ng $data array, may array pa ulit (inputAttributes), extract the inputAttributes then assign the array to a variable array
        $updatedAttributes = $data['inputAttributes'];

        //* hanapin id na attribute sa $updatedAttributes array
        $supplier = Supplier::find($updatedAttributes['id']);

        //* fill() method [key => value] means [paglalagyan => ilalagay]
        //* the fill() method automatically knows kung saan ilalagay ang elements as long as mag match ang mga keys, $users have same keys with $updatedAttributes array
        //var ipasa ang laman ng $updatedAttributes sa $user model
        $supplier->fill($updatedAttributes);

        $supplier->save(); //* Save the user model to the database

        $this->resetForm();
        $this->alert('success', 'User was updated successfully');

        $this->refreshTable();
        $this->closeModal();
    }
    private function populateForm() //*lagyan ng laman ang mga input
    {

        $supplier_details = Supplier::find($this->supplier_id); //? kunin lahat ng data ng may ari ng user_id

        $this->updatedSelectProvince($supplier_details->province_code);
        $this->updatedSelectCity($supplier_details->city_municipality_code);


        //* ipasa ang laman ng model sa inputs
        //* fill() method [key => value] means [paglalagyan => ilalagay]
        $this->fill([
            'company_name' => $supplier_details->company_name,
            'contact_number' => $supplier_details->contact_number,
            'selectProvince' => $supplier_details->province_code,
            'selectCity' => $supplier_details->city_municipality_code,
            'selectBrgy' => $supplier_details->barangay_code,
            'street' => $supplier_details->street,

        ]);
    }
    public function edit($supplierID)
    {
        $this->supplier_id = $supplierID; //var assign ang parameter value sa global variable
    }

    private function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        $this->reset(['company_name', 'contact_number', 'selectProvince', 'selectCity', 'selectBrgy', 'street', 'supplier_id']);
    }

    //* pag iclose ang form using close hindi natatanggal ang validation, this method resets form input and validation
    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }
    public function refreshTable() //* refresh ang table after confirmation
    {
        $this->dispatch('refresh-table')->to(SupplierTable::class);
    }
    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(SupplierManagementPage::class);
    }

    protected function validateForm()
    {
        $this->company_name = trim($this->company_name);
        $this->street = trim($this->street);


        $rules = [
            'company_name' => 'required|string|max:255',
            'contact_number' => ['required', 'numeric', 'digits:11', Rule::unique('suppliers', 'contact_number')->ignore($this->supplier_id)],
            'selectProvince' => 'required|exists:philippine_provinces,province_code',
            'selectCity' => 'required|exists:philippine_cities,city_municipality_code',
            'selectBrgy' => 'required|exists:philippine_barangays,barangay_code',
            'street' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',

        ];

        return $this->validate($rules);
    }

    public function changeMethod($isCreate)
    {
        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        if ($this->isCreate) {

            $this->resetForm();
        }
    }
}
