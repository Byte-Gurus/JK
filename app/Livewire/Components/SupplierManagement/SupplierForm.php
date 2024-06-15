<?php

namespace App\Livewire\Components\SupplierManagement;

use App\Models\Philippine_Region;
use App\Models\PhilippineBarangay;
use App\Models\PhilippineCity;
use App\Models\PhilippineProvince;
use App\Models\PhilippineRegion;
use Livewire\Component;

class SupplierForm extends Component
{

    public $isCreate; //var true for create false for edit
    public $cities;
    public $barangays;
    //var form inputs
    public $supplier_id, $company_name, $contact_no, $province, $city, $brgy;

    public function render()
    {
        $provinces = PhilippineProvince::select('province_code', 'province_description')
            ->orderBy('province_description')
            ->get();

        return view('livewire.components.SupplierManagement.supplier-form', compact('provinces'));
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

    public function selectCity()
    {
        if ($this->province) {
            $this->cities = PhilippineCity::where('province_code', $this->province)
                ->select('city_municipality_code', 'city_municipality_description')
                ->orderBy('city_municipality_description')
                ->get();

            return view('livewire.components.SupplierManagement.supplier-form', [$this->cities]);
        } else {
            $this->cities = null;
        }


    }

    public function selectBarangay()
    {

            // if ($this->city) {
            //     $this->barangays = PhilippineBarangay::where('city_municipality_code', $this->city)
            //         ->select('barangay_code', 'barangay_description')
            //         ->orderBy('barangay_description')
            //         ->get();

            //     return view('livewire.components.SupplierManagement.supplier-form', [$this->barangays]);
            // } else {
            //     $this->barangays = null; // Reset city dropdown if no province selected
            // }
    }


    public function edit($supplierID)
    {
        $this->supplier_id = $supplierID; //var assign ang parameter value sa global variable
    }

    private function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        $this->reset(['company_name', 'contact_no', 'province_id', 'city', 'brgy_id', 'supplier_id']);
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
