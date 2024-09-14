<?php

namespace App\Livewire\Components\CreditManagement;

use App\Events\CreditEvent;
use App\Livewire\Pages\CreditManagementPage;
use App\Models\Credit;
use App\Models\CreditHistory;
use App\Models\Payment;
use GuzzleHttp\Promise\Create;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CreditPaymentForm extends Component
{
    use LivewireAlert;

    public $showCreditPaymentForm = false;

    public $credit_amount, $tendered_amount, $reference_no, $credit_id;
    public $payWithCash = true;

    public function render()
    {
        return view('livewire.components.credit-management.credit-payment-form');
    }
    protected $listeners = [
        'display-credit-payment-form' => 'displayCreditPaymentForm',
        'credit-payment' => 'creditPayment', //*  galing sa UserTable class
        'paymentConfirmed'
    ];

    public function pay()
    {

        $validated = $this->validateForm();

        $this->confirm('Do you want to add this user?', [
            'onConfirmed' => 'paymentConfirmed', //* call the createconfirmed method
            'inputAttributes' =>  $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }

    public function paymentConfirmed($data)
    {

        $validated = $data['inputAttributes'];

        $credit = Credit::find($this->credit_id);

        if ($this->payWithCash) {
            $payment = Payment::create([
                'tendered_amount' => $validated['tendered_amount'],
                'amount' => $this->credit_amount,
                'payment_type' => 'Cash',
                'reference_number' => 'N/A',
                'transaction_id' => $credit->transaction_id
            ]);
        } else {


            $payment = Payment::create([
                'tendered_amount' => $validated['tendered_amount'],
                'amount' => $this->credit_amount,
                'reference_no' => $validated['reference_no'],
                'payment_type' => 'GCash',
                'transaction_id' => $credit->transaction_id
            ]);
        }


        $credit->remaining_balance -= $validated['tendered_amount'];
        if ($credit->remaining_balance <= 0) {
            $credit->remaining_balance = 0;
            $credit->status = 'Fully paid';
        } else {
            $credit->status = 'With remaining balance';
        }
        $credit->save();

        CreditHistory::create([
            'description' => 'Payment made',
            'credit_id' => $credit->id,
            'credit_amount' => $credit->credit_amount,
            'remaining_balance' => $credit->remaining_balance,
            'payment_id' => $payment->id
        ]);

        $this->alert('success', 'Creditor was paid successfully');

        $this->dispatch('display-payment-receipt')->to(CreditManagementPage::class);
        CreditEvent::dispatch('refresh-credit');
    }

    public function creditPayment($credit_ID)
    {
        $credit = Credit::find($credit_ID);
        $this->credit_id = $credit->id;
        $this->credit_amount = $credit->credit_amount;
    }
    public function changePaymentMethod()
    {
        $this->payWithCash = !$this->payWithCash;
    }

    protected function validateForm()
    {


        if ($this->payWithCash) {


            $rules = [
                'tendered_amount' => 'required|numeric|min:1|gte:credit_amount',

            ];
        } else {
            $rules = [
                'tendered_amount' => 'required|numeric|min:1|gte:credit_amount',
                'reference_no' => 'required|numeric|min:0',
            ];
        }

        return $this->validate($rules);
    }

    private function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        // $this->reset(['tendered_amount', 'reference_no']);
    }

    public function resetFormWhenClosed()
    {
        // $this->resetForm();
        // $this->resetValidation();
    }

    public function displayCreditPaymentForm()
    {
        $this->showCreditPaymentForm = true;
    }
}
