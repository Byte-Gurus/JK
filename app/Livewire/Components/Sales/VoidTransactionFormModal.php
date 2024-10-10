<?php

namespace App\Livewire\Components\Sales;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class VoidTransactionFormModal extends Component
{
    public function render()
    {
        return view('livewire.components.Sales.void-transaction-form-modal');
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-void-transaction-form-modal')->to(VoidTransactionForm::class);
        $this->resetValidation();

    }

    public function resetForm()
    {
        // $this->reset(['selectedReason']);
    }
}
