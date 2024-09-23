<?php

namespace App\Livewire\Components\CreditManagement;

use App\Events\CreditEvent;
use App\Events\TransactionEvent;
use App\Livewire\Pages\CreditManagementPage;
use App\Models\Credit;
use App\Models\CreditHistory;
use App\Models\Customer;
use App\Models\TransactionMovement;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreditForm extends Component
{
    use LivewireAlert;

    public $isCreate;
    public $credit_number, $searchCustomer, $credit_limit = 5000, $status = 'Pending', $due_date, $customer_id, $customer_name;

    public function render()
    {
        $searchCustomerTerm = trim($this->searchCustomer);
        $searchCustomerTerm = strtolower($searchCustomerTerm); // Convert to lowercase for case-insensitive search

        // Get customers who have credits that are not fully paid
        $customersWithUnpaidCredits = Customer::whereHas('creditJoin', function ($query) {
            $query->where('status', '!=', 'Fully paid');
        })->pluck('id');

        // Get customers who are of type 'Credit' and either have fully paid credits or no credits at all
        $customers = Customer::whereNotIn('id', $customersWithUnpaidCredits)
            ->where(function ($query) use ($searchCustomerTerm) {
                $query->whereRaw('LOWER(firstname) like ?', ["%{$searchCustomerTerm}%"])
                    ->orWhereRaw('LOWER(middlename) like ?', ["%{$searchCustomerTerm}%"])
                    ->orWhereRaw('LOWER(lastname) like ?', ["%{$searchCustomerTerm}%"]);
            })
            ->get();

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

    public function getCustomer($customer_id)
    {
        $this->customer_id = $customer_id;


        $customer = Customer::find($customer_id);
        $this->customer_name = $customer->firstname . ' ' . ($customer->middlename ? $customer->middlename . ' ' : '') . $customer->lastname;


        $this->generateCreditNumber();
        $this->searchCustomer = '';
    }

    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(CreditManagementPage::class);
        $this->resetValidation();
    }

    public function create()
    {

        $validated = $this->validateForm();

        $this->confirm('Do you want to add this credit?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' => $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }


    public function createConfirmed($data)
    {
        $validated = $data['inputAttributes'];

        $credit = Credit::create([
            'status' => $validated['status'],
            'due_date' => $validated['due_date'],
            'credit_amount' => null,
            'remaining_balance' => null,
            'credit_number' => $this->credit_number,
            'credit_limit' => $validated['credit_limit'],
            'transaction_id' => null,
            'customer_id' => $this->customer_id
        ]);

        $creditHistory = CreditHistory::create([
            'description' => 'Credit Approved',
            'credit_id' => $credit->id,
            'credit_amount' => null,
            'remaining_balance' => null,
        ]);


        $transaction_movements = TransactionMovement::create([
            'movement_type' => 'Credit',
            'transaction_id' => null,
            'credit_id' => $credit->id,
            'returns_id' => null
        ]);


        $this->alert('success', 'Creditor was created successfully');
        $this->resetForm();

        $this->refreshTable();
        CreditEvent::dispatch('refresh-credit');


        $this->closeModal();
    }

    public function clearSelectedCustomerName()
    {
        $this->reset(['customer_name']);
    }

    public function resetForm()
    {
        $this->reset(['credit_number', 'searchCustomer', 'due_date', 'customer_name']);
    }

    public function refreshTable() //* refresh ang table after confirmation
    {
        $this->dispatch('refresh-table')->to(CreditTable::class);
    }

    protected function validateForm()
    {

        $rules = [
            'customer_name' => 'required',
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

    public function generateCreditNumber()
    {
        do {
            $randomNumber = random_int(0, 9999);
            $formattedNumber = str_pad($randomNumber, 4, '0', STR_PAD_LEFT);
            $creditNumber = 'CR-' . $formattedNumber . '-' . now()->format('mdY');

            // Check if the credit number already exists
            $exists = Credit::where('credit_number', $creditNumber)->exists();
        } while ($exists);

        // Assign the unique credit number
        $this->credit_number = $creditNumber;
    }
}
