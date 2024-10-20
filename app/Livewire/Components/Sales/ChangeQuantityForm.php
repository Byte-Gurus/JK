<?php

namespace App\Livewire\Components\Sales;

use App\Models\Inventory;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ChangeQuantityForm extends Component
{
    use LivewireAlert;
    public $adjust_quantity, $current_stock_quantity, $barcode, $item_name, $item_description, $credit_limit,
    $selling_price, $grandTotal, $original_quantity, $bulk_quantity;

    public function render()
    {

        return view('livewire.components.Sales.change-quantity-form');
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


        if ($this->original_quantity < $validated['adjust_quantity']) {
            if ($validated['adjust_quantity'] * $this->selling_price + $this->grandTotal > $this->credit_limit && $this->credit_limit) {
                $this->alert('error', 'Credit limit is reached');
                return;
            }
        }

        $this->dispatch('get-quantity', newQuantity: $validated['adjust_quantity'])->to(SalesTransaction::class);

        $this->reset('adjust_quantity');

        $this->dispatch('display-change-quantity-form', showChangeQuantityForm: false)->to(SalesTransaction::class);
        $this->alert('success', 'Quantity was updated successfully');

        // $this->confirm('Do you want to add this item?', [
        //     'onConfirmed' => 'adjustConfirmed', //* call the createconfirmed method
        //     'inputAttributes' =>  $validated, //* pass the user to the confirmed method, as a form of array
        // ]);

        $this->dispatch('unselect-item')->to(SalesTransaction::class);
    }

    // public function adjustConfirmed($data)
    // {

    // }

    protected function validateForm()
    {
        $rules = [
            'adjust_quantity' => ['required', 'numeric', 'min:1', 'lte:current_stock_quantity'],
        ];
        $this->focusInput();

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

        $groupedItems = Inventory::whereHas('itemJoin', function ($query) use ($data) {
            $query->where('barcode', $data['barcode'])
                ->where('selling_price', $data['selling_price'])
                ->where('status', 'Available');
        })->get()->groupBy('item_id');

        $totalStock = $groupedItems->map(function ($group) {
            return $group->sum('current_stock_quantity');
        })->sum();

        $this->adjust_quantity = $data['itemQuantity'];
        $this->original_quantity = $data['itemQuantity'];
        $this->current_stock_quantity = $totalStock;
        $this->barcode = $data['barcode'];
        $this->item_name = $data['item_name'];
        $this->item_description = $data['item_description'];
        $this->credit_limit = $data['credit_limit'];
        $this->selling_price = $data['selling_price'];
        $this->grandTotal = $data['grandTotal'];
        $this->bulk_quantity = $data['bulk_quantity'];

        $this->focusInput();
    }

    public function focusInput()
    {
        $this->dispatch('adjust_quantity_focus');
    }
}
