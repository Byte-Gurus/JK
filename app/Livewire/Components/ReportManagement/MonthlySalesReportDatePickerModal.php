<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class MonthlySalesReportDatePickerModal extends Component
{
    public $showMonthlySalesReportDatePicker = true;

    public function render()
    {
        return view('livewire.components.ReportManagement.monthly-sales-report-date-picker-modal');
    }
    
    public function displayMonthlySalesReport()
    {
        $this->dispatch(event: 'display-monthly-sales-report')->to(ReportManagement::class);
    }
}
