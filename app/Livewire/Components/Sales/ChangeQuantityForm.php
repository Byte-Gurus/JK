<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ChangeQuantityForm extends Component
{
    use LivewireAlert;
    public $adjust_quantity;

    public function render()
    {
        return view('livewire.components.sales.change-quantity-form');
    }

    protected $listeners = [
        'get-quantity' => 'getQuantity',
        'adjustConfirmed'

    ];


    public function resetFormWhenClosed()
    {
        $this->resetForm();
        // $this->resetValidation();
    }

    public function adjust()
    {
        $validated = $this->validateForm();

        $this->confirm('Do you want to add this item?', [
            'onConfirmed' => 'adjustConfirmed', //* call the createconfirmed method
            'inputAttributes' =>  $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }

    public function adjustConfirmed($data)
    {

        $validated = $data['inputAttributes'];

        $this->dispatch('get-quantity', newQuantity: $validated['adjust_quantity'])->to(SalesTransaction::class);

        $this->reset('adjust_quantity');

        $this->dispatch('display-change-quantity-form', showChangeQuantityForm: false)->to(SalesTransaction::class);
        $this->alert('success', 'quantity was updated successfully');
    }

    protected function validateForm()
    {
        $rules = [
            'adjust_quantity' => ['required', 'numeric', 'min:1'],
        ];

        return $this->validate($rules);
    }

    public function resetForm()
    {
        $this->reset([
            'adjust_quantity'
        ]);
    }

    public function getQuantity($itemQuantity)
    {
        $this->adjust_quantity = $itemQuantity;
    }
}
