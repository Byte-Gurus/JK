<?php

namespace App\Livewire\Components\Sales;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class VoidTransactionFormModal extends Component
{
    public $reason, $fromPage = 'VoidAll';

    public $isAdmin;

    public function render()
    {
        return view('livewire.components.Sales.void-transaction-form-modal');
    }
    protected $listeners = [
        'admin-confirmed' => 'adminConfirmed',

    ];

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-void-transaction-form-modal')->to(VoidTransactionForm::class);
        $this->resetValidation();

    }
    public function voidAllConfirmed(){
        dd('sasa');
    }
    public function resetForm()
    {
        $this->reset('reason');
    }

    public function voidAll()
    {
        $this->dispatch('get-from-page', $this->fromPage)->to(SalesAdminLoginForm::class);
        $this->dispatch('close-void-transaction-form-modal')->to(VoidTransactionForm::class);
        $this->dispatch('display-sales-admin-login-form')->to(VoidTransactionForm::class);
    }

    
}
