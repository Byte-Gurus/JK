<?php

namespace App\Livewire\Components\SupplierManagement;


use App\Models\PhilippineBarangay;
use App\Models\PhilippineCity;
use App\Models\PhilippineProvince;
use App\Models\PhilippineRegion;
use Livewire\Component;

class SupplierForm extends Component
{

    public $isCreate; //var true for create false for edit

    public $selectProvince = null;
    public $selectCity = null;
    public $selectBrgy = null;

    public $cities = null;
    public $barangays = null;
    //var form inputs
    public $supplier_id, $company_name, $contact_no;

    public function render()
    {


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
    public function edit($supplierID)
    {
        $this->supplier_id = $supplierID; //var assign ang parameter value sa global variable
    }

    private function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        $this->reset(['company_name', 'contact_no', 'selectProvince', 'selectCity', 'selectBrgy', 'supplier_id']);
    }

    //* pag iclose ang form using close hindi natatanggal ang validation, this method resets form input and validation
    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }

    protected function validateForm()
    {

        $rules = [
            'company_name' => '',
            'contact_number' => '',
            'province' => '',
            'city/Municipality' => '',
            'brgy' => '',

        ];

        return $this->validate($rules);
    }

    public function changeMethod($isCreate)
    {
        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable
    }
}
