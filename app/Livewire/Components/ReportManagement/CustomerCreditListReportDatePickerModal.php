<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class CustomerCreditListReportDatePickerModal extends Component
{
    public $showExpiredItemsReportDatePickerModal = true;

    public $toDate, $fromDate;

    public function render()
    {
        return view('livewire.components.ReportManagement.customer-credit-list-report-date-picker-modal');
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-customer-credit-list-report-date-picker-modal')->to(ReportManagement::class);
    }

    public function resetForm()
    {
        $this->reset([
            'toDate',
            'fromDate'
        ]);
    }

    public function displayCustomerCreditListReport()
    {
        $this->dispatch(event: 'display-customer-credit-list-report')->to(ReportManagement::class);
    }

    public function getDate()
    {
        $this->dispatch('generate-report', $this->fromDate, $this->toDate)->to(CustomerCreditListReport::class);
    }
}
