<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PaymentForm extends Component
{
    use LivewireAlert;
    public $payWithCash = true;
    public $tendered_amount, $reference_no, $grand_total, $payment = [];

    public function render()
    {
        return view('livewire.components.sales.payment-form');
    }
    protected $listeners = [

        'get-grand-total' => 'getGrandTotal',
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

        if ($this->payWithCash) {
            $this->payment = [
                'tendered_amount' => $validated['tendered_amount'],
                'payment_method' => 'Cash',
            ];
        } else {

            $this->payment = [
                'tendered_amount' => $validated['tendered_amount'],
                'reference_no' => $validated['reference_no'],
                'payment_method' => 'GCash',
            ];
        }

        $this->alert('success', 'Customer was saved successfully');

        $this->dispatch('get-customer-payments', Payment: $this->payment)->to(SalesTransaction::class);
    }
    public function changePaymentMethod()
    {
        $this->payWithCash = !$this->payWithCash;
    }

    private function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        $this->reset(['tendered_amount', 'reference_no']);
    }

    public function resetFormWhenClosed()
    {
        // $this->resetForm();
        $this->resetValidation();
    }
    public function getGrandTotal($GrandTotal)
    {
        $this->grand_total = $GrandTotal;
    }

    protected function validateForm()
    {


        if ($this->payWithCash) {


            $rules = [
                'tendered_amount' => 'required|numeric|min:1|gte:grand_total',

            ];
        } else {
            $rules = [
                'tendered_amount' => 'required|numeric|min:1|gte:grand_total',
                'reference_no' => 'required|numeric|min:0',
            ];
        }

        return $this->validate($rules);
    }
}
