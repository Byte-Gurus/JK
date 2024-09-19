<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class DailySalesReportDatePickerModal extends Component
{
    public $showDailySalesReportDatePicker = true;
    public $date;

    public function render()
    {
        return view('livewire.components.ReportManagement.daily-sales-report-date-picker-modal');
    }

    public function displayDailySalesReport()
    {
        $this->dispatch(event: 'display-daily-sales-report')->to(ReportManagement::class);
    }

    public function getDate(){
       $this->dispatch('generate-report', $this->date)->to(DailySalesReport::class);
    }
}
