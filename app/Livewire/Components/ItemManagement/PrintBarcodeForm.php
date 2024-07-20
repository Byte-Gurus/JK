<?php

namespace App\Livewire\Components\ItemManagement;

use App\Livewire\Pages\ItemManagementPage;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PrintBarcodeForm extends Component
{
    use LivewireAlert;
    public $barcode;
    public $barcode_quantity;

    public function render()
    {
        return view('livewire.components.ItemManagement.print-barcode-form');
    }

    protected $listeners = [
        'get-barcode-from-table' => 'getBarcode',
        'createConfirmed',
    ];

    public function create() //* create process
    {


        $validated = $this->validateForm();

        $this->confirm('Do you want to print this barcodes?', [
            'onConfirmed' => 'createConfirmed', //* call the createconfirmed method
            'inputAttributes' =>  $validated, //* pass the user to the confirmed method, as a form of array
        ]);
    }
    public function createConfirmed($data) //* confirmation process ng create
    {

        $validated = $data['inputAttributes'];

        $this->closeModal();
        $this->print($validated['barcode_quantity'], $this->barcode);

        $this->resetForm();
    }
    protected function validateForm()
    {

        $rules = [
            'barcode_quantity' => ['required', 'numeric'],
        ];

        return $this->validate($rules);
    }
    private function resetForm() //*tanggalin ang laman ng input pati $item_id value
    {
        $this->reset(['barcode_quantity', 'barcode']);
    }
    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(ItemManagementPage::class);
    }
    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }               
    public function print($quantity, $barcode)
    {
        $this->dispatch('change-print-status')->to(ItemManagementPage::class);

        $this->dispatch('get-print-information', [
            'barcode' => $barcode,
            'barcode_quantity' => $quantity,
        ])->to(PrintBarcode::class);
    }
    public function refreshTable() //* refresh ang table after confirmation
    {
        $this->dispatch('refresh-table')->to(ItemTable::class);
    }
    public function getBarcode($barcode)
    {
        $this->barcode = $barcode['Barcode'];
    }
}
