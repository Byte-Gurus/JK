<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class MonthlySalesReportDatePickerModal extends Component
{
    public $showMonthlySalesReportDatePicker = true;
    public $date;

    public function render()
    {
        return view('livewire.components.ReportManagement.monthly-sales-report-date-picker-modal');
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-monthly-sales-report-date-picker-modal')->to(ReportManagement::class);
    }

    public function resetForm()
    {
        $this->reset([
            'date'
        ]);
    }

    public function displayMonthlySalesReport()
    {
        $this->dispatch(event: 'display-monthly-sales-report')->to(ReportManagement::class);
    }
    public function getDate()
    {
        $this->dispatch('generate-report', $this->date)->to(MonthlySalesReport::class);
    }
}
