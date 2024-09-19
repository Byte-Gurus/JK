<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class YearlySalesReportDatePickerModal extends Component
{
    public $showYearlySalesReportDatePircker = false;

    public $date;
    public function render()
    {
        return view('livewire.components.ReportManagement.yearly-sales-report-date-picker-modal');
    }

    public function displayYearlySalesReport()
    {
        $this->dispatch(event: 'display-yearly-sales-report')->to(ReportManagement::class);
    }
     public function getDate(){
        $this->dispatch('generate-report', $this->date)->to(YearlySalesReport::class);
     }
}
