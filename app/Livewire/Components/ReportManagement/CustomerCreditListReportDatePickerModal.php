<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class CustomerCreditListReportDatePickerModal extends Component
{
    public $showExpiredItemsReportDatePickerModal = true;

    public $date;

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
            'date'
        ]);
    }

    public function displayMonthlySalesReport()
    {
        $this->dispatch(event: 'display-customer-credit-list-report')->to(ReportManagement::class);
    }

    public function getDate()
    {
        $this->dispatch('generate-report', $this->date)->to(CustomerCreditListReport::class);
    }
}
