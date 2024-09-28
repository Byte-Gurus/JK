<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class ExpiredItemsReportDatePickerModal extends Component
{
    public $showExpiredItemsReportDatePickerModal = true;

    public $toDate, $fromDate;

    public function render()
    {
        return view('livewire.components.ReportManagement.expired-items-report-date-picker-modal');
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-expired-items-report-date-picker-modal')->to(ReportManagement::class);
    }

    public function resetForm()
    {
        $this->reset([
            'toDate',
            'fromDate'
        ]);
    }

    public function displayMonthlySalesReport()
    {
        $this->dispatch( 'display-expired-items-report-date-picker-modal')->to(ReportManagement::class);
    }

    public function getDate()
    {
        $this->dispatch('generate-report', $this->toDate, $this->fromDate)->to(ExpiredItemsReport::class);
    }
}
