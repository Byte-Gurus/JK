<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class VoidedTransactionsReportDatePickerModal extends Component
{
    public $showVoidedTransactionsReportDatePickerModal = true;

    public $toDate, $fromDate;
    public function render()
    {
        return view('livewire.components.ReportManagement.voided-transactions-report-date-picker-modal');
    }
    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-voided-transactions-report-date-picker-modal')->to(ReportManagement::class);
        $this->resetValidation();

    }

    public function resetForm()
    {
        $this->reset([
            'toDate',
            'fromDate'
        ]);
    }

    public function validateForm()
    {
        $rules = [
            'toDate' => 'required|date|before_or_equal:today|after_or_equal:1924-01-01',
            'fromDate' => 'required|date|before_or_equal:today|after_or_equal:1924-01-01|before_or_equal:toDate',
        ];

        return $this->validate($rules);
    }

    public function displayVoidedTransactionsReport()
    {
        $this->dispatch('display-voided-transactions-report')->to(ReportManagement::class);
    }

    public function getDate()
    {
        $validate = $this->validateForm();
        $this->dispatch('generate-report', $this->toDate, $this->fromDate)->to(VoidedTransactionsReport::class);
        $this->displayVoidedTransactionsReport();
    }
}
