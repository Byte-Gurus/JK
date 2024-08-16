<?php

namespace App\Livewire\Components\InventoryManagement;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class StockAdjustForm extends Component
{
    use LivewireAlert;
    public function render()
    {
        return view('livewire.components.InventoryManagement.stock-adjust-form');
    }

    private function resetForm() //*tanggalin ang laman ng input pati $user_id value
    {
        // $this->reset(['firstname', 'middlename', 'lastname', 'contact_number', 'role', 'status', 'username', 'password', 'retype_password', 'user_id']);
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        // $this->resetValidation();
    }
}
