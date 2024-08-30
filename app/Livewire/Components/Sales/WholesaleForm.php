<?php

namespace App\Livewire\Components\Sales;

use Livewire\Component;

class WholesaleForm extends Component
{
    public function render()
    {
        return view('livewire.components.sales.wholesale-form');
    }

    private function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        // $this->reset(['firstname', 'middlename', 'lastname', 'contact_number', 'role', 'status', 'username', 'password', 'retype_password', 'user_id']);
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->resetValidation();
    }
}
