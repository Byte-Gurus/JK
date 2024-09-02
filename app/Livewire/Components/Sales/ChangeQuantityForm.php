<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ChangeQuantityForm extends Component
{
    use LivewireAlert;
    public $adjust_quantity, $current_stock_quantity, $barcode, $item_name, $item_description;

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
        $this->resetValidation();
    }

    public function adjust()
    {
        $validated = $this->validateForm();

        // $validated = $data['inputAttributes'];

        $this->dispatch('get-quantity', newQuantity: $validated['adjust_quantity'])->to(SalesTransaction::class);

        $this->reset('adjust_quantity');

        $this->dispatch('display-change-quantity-form', showChangeQuantityForm: false)->to(SalesTransaction::class);
        $this->alert('success', 'quantity was updated successfully');

        // $this->confirm('Do you want to add this item?', [
        //     'onConfirmed' => 'adjustConfirmed', //* call the createconfirmed method
        //     'inputAttributes' =>  $validated, //* pass the user to the confirmed method, as a form of array
        // ]);
    }

    // public function adjustConfirmed($data)
    // {


    // }

    protected function validateForm()
    {
        $rules = [
           'adjust_quantity' => ['required', 'numeric', 'min:1', 'lte:current_stock_quantity'],
        ];

        return $this->validate($rules);
    }

    public function resetForm()
    {
        $this->reset([
            'adjust_quantity'
        ]);
    }

    public function getQuantity($data)
    {
        $this->adjust_quantity = $data['itemQuantity'];
        $this->current_stock_quantity = $data['current_stock_quantity'];
        $this->barcode = $data['barcode'];
        $this->item_name = $data['item_name'];
        $this->item_description = $data['item_description'];
    }
}
