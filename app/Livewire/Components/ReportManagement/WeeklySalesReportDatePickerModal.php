<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class WeeklySalesReportDatePickerModal extends Component
{

    public $showWeeklySalesReportDatePicker = true;

    public function render()
    {
        return view('livewire.components.ReportManagement.weekly-sales-report-date-picker-modal');
    }

    public function displayWeeklySalesReport()
    {
        $this->dispatch(event: 'display-weekly-sales-report')->to(ReportManagement::class);
    }
}
