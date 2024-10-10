<?php

namespace App\Livewire\Components\Sales;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class VoidTransactionFormModal extends Component
{
    public $reason, $fromPage = 'VoidAll';
    public $showSalesAdminLoginForm = false;
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
        $this->displaySalesAdminLoginForm();
    }
    public function displaySalesAdminLoginForm()
    {
        $this->showSalesAdminLoginForm = !$this->showSalesAdminLoginForm;
    }
    public function adminConfirmed($isAdmin)
    {
        $this->isAdmin = $isAdmin;


        if ($this->isAdmin) {
            $this->voidAllConfirmed();
        }
    }
}
