<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DailySalesReportDatePickerModal extends Component
{
    public $showDailySalesReportDatePickerModal = false;
    public $date;

    public function render()
    {
        return view('livewire.components.ReportManagement.daily-sales-report-date-picker-modal');
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-daily-sales-report-date-picker-modal')->to(ReportManagement::class);
    }

    public function resetForm()
    {
        $this->reset([
            'date'
        ]);
    }

    public function displayDailySalesReport()
    {
        route('daily.sales.report', '_blank');
        $this->dispatch(event: 'display-daily-sales-report')->to(ReportManagement::class);
    }

    public function getDate()
    {
        $this->dispatch('generate-report', $this->date)->to(DailySalesReport::class);
    }
}
