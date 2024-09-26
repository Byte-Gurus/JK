<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class SalesReturnReportDatePickerModal extends Component
{
    public function render()
    {
        return view('livewire.components.ReportManagement.sales-return-report-date-picker-modal');
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-sales-return-report-date-picker-modal')->to(ReportManagement::class);
    }

    public function resetForm()
    {
        $this->reset([
            'date'
        ]);
    }

    public function displaySalesReturnReport()
    {
        $this->dispatch(event: 'display-sales-return-report')->to(ReportManagement::class);
    }

    public function getDate()
    {
        $this->dispatch('generate-report', $this->date)->to(SalesReturnReport::class);
    }
}