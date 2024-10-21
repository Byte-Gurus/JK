<?php

namespace App\Livewire\Components\SupplierManagement;

use App\Events\SupplierEvent;
use App\Livewire\Pages\SupplierManagementPage;
use App\Models\Address;
use App\Models\PhilippineBarangay;
use App\Models\PhilippineCity;
use App\Models\PhilippineProvince;
use App\Models\PhilippineRegion;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class SupplierForm extends Component
{
    use LivewireAlert;

    public $isCreate; //var true for create false for edit

    //var null muna silang lahat hanggat d narerender
    public $selectProvince = null;
    public $selectCity = null;
    public $selectBrgy = null;

    public $cities = null;
    public $barangays = null;

    //var form inputs
    public $supplier_id, $company_name, $status = 1, $contact_number, $street;

    //var proxy id para sa supplier id, same sila ng value ng supplier id
    public $proxy_supplier_id;

    public function render()
    {

        return view('livewire.components.SupplierManagement.supplier-form', [
            'provinces' => PhilippineProvince::orderBy('province_description')->get(),
        ]);
    }

    //* assign all the listners in one array
    //* for methods
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

        $this->confirm('Do you want to add this supplier?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' => $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }
    public function createConfirmed($data) //* confirmation process ng create
    {

        $validated = $data['inputAttributes'];

        DB::beginTransaction();
        try {
            $address = Address::create([
                'province_code' => $validated['selectProvince'],
                'city_municipality_code' => $validated['selectCity'],
                'barangay_code' => $validated['selectBrgy'],
                'street' => $validated['street'],
            ]);

            $supplier = Supplier::create([
                'company_name' => $validated['company_name'],
                'contact_number' => $validated['contact_number'],
                'status_id' => $validated['status'],
                'address_id' => $address->id
            ]);

            DB::commit();


            $this->alert('success', 'Supplier was created successfully');
            $this->refreshTable();
            SupplierEvent::dispatch('refresh-supplier');
            $this->resetForm();
            $this->closeModal();
        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            DB::rollback();
            $this->alert('error', 'An error occurred while creating the Supplier, please refresh the page ');
        }


    }

    public function update() //* update process
    {
        $validated = $this->validateForm();


        $suppliers = Supplier::find($this->proxy_supplier_id); //? kunin lahat ng data ng may ari ng proxy_supplier_id


        //* ipasa ang laman ng validated inputs sa models
        $suppliers->company_name = $validated['company_name'];
        $suppliers->contact_number = $validated['contact_number'];
        $suppliers->status_id = $validated['status'];
        $suppliers->province_code = $validated['selectProvince'];
        $suppliers->city_municipality_code = $validated['selectCity'];
        $suppliers->barangay_code = $validated['selectBrgy'];
        $suppliers->street = $validated['street'];

        $attributes = $suppliers->toArray();


        $this->confirm('Do you want to update this supplier?', [
            'onConfirmed' => 'updateConfirmed', //* call the confmired method
            'inputAttributes' => $attributes, //* pass the $attributes array to the confirmed method
        ]);
    }

    public function updateConfirmed($data) //* confirmation process ng update
    {


        //var sa loob ng $data array, may array pa ulit (inputAttributes), extract the inputAttributes then assign the array to a variable array
        $updatedAttributes = $data['inputAttributes'];

        DB::beginTransaction();

        try {
            $supplier = Supplier::find($updatedAttributes['id']);
            $address = Address::find($updatedAttributes['address_id']);

            if (!$supplier || !$address) {
                // If the item does not exist, rollback and alert the user
                DB::rollback();
                $this->alert('error', 'Supplier or Address not found.');
                return; // Exit the method
            }
            $address->fill([
                'province_code' => $updatedAttributes['province_code'],
                'city_municipality_code' => $updatedAttributes['city_municipality_code'],
                'barangay_code' => $updatedAttributes['barangay_code'],
                'street' => $updatedAttributes['street'],
            ]);
            $address->save();

            $supplier->fill([
                'company_name' => $updatedAttributes['company_name'],
                'contact_number' => $updatedAttributes['contact_number'],
                'status_id' => $updatedAttributes['status_id'],
                'address_id' => $address->id, // Associate with the updated address
            ]);
            $supplier->save();

            DB::commit();

            $this->resetForm();
            $this->alert('success', 'Supplier was updated successfully');
            SupplierEvent::dispatch('refresh-supplier');
            $this->refreshTable();
            $this->closeModal();

        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            DB::rollback();
            $this->alert('error', 'An error occurred while updating the Supplier, please refresh the page ');
        }

    }
    private function populateForm() //*lagyan ng laman ang mga input
    {

        $supplier_details = Supplier::find($this->supplier_id); //? kunin lahat ng data ng may ari ng user_id


        //* ipasa ang laman ng model sa inputs
        //* fill() method [key => value] means [paglalagyan => ilalagay]
        $this->fill([
            'company_name' => $supplier_details->company_name,
            'contact_number' => $supplier_details->contact_number,
            'status' => $supplier_details->status_id,
            'selectProvince' => $supplier_details->addressJoin->province_code,
            'selectCity' => $supplier_details->addressJoin->city_municipality_code,
            'selectBrgy' => $supplier_details->addressJoin->barangay_code,
            'street' => $supplier_details->addressJoin->street,
        ]);

        //todo nag ccause to ng bug, ang bug is sa unang render upadte supplier form, hindi makapag select sa City and barangay, but if mag punta sa create supplier then edit then mag render na sya
        //todo option 1 tanggalin ito para hindi mapopolate ang selectCity and SelectBarangay sa second render ng form
        //todo option 2 hayaan nalang at mag select nalang si user ng city and brgy ulit everytime mag update kasi idk pano aayusin
        $this->cities = PhilippineCity::where('province_code', $supplier_details->addressJoin->province_code)->orderBy('city_municipality_description')->get();

        $this->barangays = PhilippineBarangay::where('city_municipality_code', $supplier_details->addressJoin->city_municipality_code)->orderBy('barangay_description')->get();
    }
    public function edit($supplierID)
    {
        $this->supplier_id = $supplierID; //var assign ang parameter value sa global variable
        $this->proxy_supplier_id = $supplierID;  //var proxy_supplier_id para sa update ng supplier kasi i null ang supplier id sa update afetr populating the form

        $this->populateForm();
    }

    private function resetForm() //*tanggalin ang laman ng input pati $supplier_id value
    {
        $this->reset(['company_name', 'contact_number', 'status', 'selectProvince', 'selectCity', 'selectBrgy', 'street', 'supplier_id']);
    }

    //* pag iclose ang form using close hindi natatanggal ang validation, this method resets form input and validation
    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
        $this->cities = null;
        $this->barangays = null;
    }
    public function refreshTable() //* refresh ang table after confirmation
    {
        $this->dispatch('refresh-table')->to(SupplierTable::class);
    }
    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(SupplierManagementPage::class);
        $this->resetValidation();
        $this->cities = null;
        $this->barangays = null;
    }

    protected function validateForm()
    {
        $this->company_name = trim($this->company_name);
        $this->street = trim($this->street);

        $rules = [
            'company_name' => 'required|string|max:50|regex:/^[\p{L}\'\-\.]+(?: [\p{L}\'\-\.]+)*$/u', // Allo

            //? validation sa username paro iignore ang user_id para maupdate ang contact_number kahit unique
            'contact_number' => ['required', 'numeric', 'digits:11', 'regex:/^09[0-9]{9}$/',  Rule::unique('suppliers', 'contact_number')->ignore($this->proxy_supplier_id)],
            'status' => 'required|in:1,2',
            'selectProvince' => 'required|exists:philippine_provinces,province_code',
            'selectCity' => 'required|exists:philippine_cities,city_municipality_code',
            'selectBrgy' => 'required|exists:philippine_barangays,barangay_code',
            'street' => 'required|string|max:50',

        ];

        return $this->validate($rules);
    }

    public function changeMethod($isCreate)
    {
        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        if ($this->isCreate) {
            $this->status = 1;
            $this->resetForm();
        }
    }
}
