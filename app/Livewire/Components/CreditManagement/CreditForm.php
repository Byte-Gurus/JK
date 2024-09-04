<?php

namespace App\Livewire\Components\CreditManagement;

use App\Models\Credit;
use App\Models\Customer;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreditForm extends Component
{
    use LivewireAlert;

    public $isCreate;
    public $credit_number, $selectCustomer, $credit_limit, $status, $due_date;
    public function render()
    {

        $this->generateCreditNumber();
        $customers = Customer::where('customer_type', 'Credit')->get();

        return view('livewire.components.CreditManagement.credit-form', [
            'customers' => $customers
        ]);
    }

    protected $listeners = [
        'edit-supplier-from-table' => 'edit',  //* key:'edit-supplier-from-table' value:'edit'  galing sa SupplierTable class
        //* key:'change-method' value:'changeMethod' galing sa SupplierTable class,  laman false
        'change-method' => 'changeMethod',
        'updateConfirmed',
        'createConfirmed',
    ];

    public function create()
    {

        $validated = $this->validateForm();

        $this->confirm('Do you want to add this credit?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' =>  $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }

    public function createConfirmed($data)
    {
        $validated = $data['inputAttributes'];

        $credit = Credit::create([
            'status' => $validated['status'],
            'due_date' => $validated['due_date'],
            'credit_amount' => null,
            'credit_number' => $this->credit_number,
            'credit_limit' => $validated['credit_limit'],
            'transaction_id' => null,
            'customer_id' => $validated['selectCustomer'],
        ]);
    }

    protected function validateForm()
    {

        $rules = [
            'selectCustomer' => 'required|numeric',
            'credit_limit' => ['required', 'numeric', 'min:1'],
            'status' => 'required|in:Paid,Pending,Overdue',
            'due_date' => 'required|date|after_or_equal:today'
        ];

        return $this->validate($rules);
    }



    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }

    public function changeMethod($isCreate)
    {
        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        if ($this->isCreate) {

            // $this->resetForm();
        }
    }

    public function generateCreditNumber()  //* generate a random barcode and contatinate the ITM
    {

        $randomNumber = random_int(0, 9999);
        $formattedNumber = str_pad($randomNumber, 4, '0', STR_PAD_LEFT);
        $this->credit_number = 'CR-' . $formattedNumber . '-' . now()->format('dmY');
    }
}
