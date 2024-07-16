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

    public $displayPrint = true;
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


        $this->passBarcode($this->barcode, $validated['barcode_quantity']);
        $this->resetForm();
        $this->closeModal();


    }
    public function passBarcode($barcode, $barcode_quantity)
    {

        //*call the listesner 'edit-item-from-table' galing sa ItemForm class
        //@params itemID name ng parameter na ipapasa, $supplierId parameter value na ipapasa
        // $this->dispatch('pass-barcode-from-barcode-form', [
        //     'barcode' => $barcode,
        //     'barcode_quantity' => $barcode_quantity
        // ])->to(BarcodePage::class);


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
    public function refreshTable() //* refresh ang table after confirmation
    {
        $this->dispatch('refresh-table')->to(ItemTable::class);
    }
    public function getBarcode($barcode)
    {

        $this->barcode = $barcode['Barcode'];
    }

    public function togglePrint() {
        $this->displayPrint = !$this->displayPrint;
    }
}
