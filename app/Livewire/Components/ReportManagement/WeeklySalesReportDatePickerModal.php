<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class WeeklySalesReportDatePickerModal extends Component
{

    public $showWeeklySalesReportDatePicker = true;
    public $date;


    public function render()
    {
        return view('livewire.components.ReportManagement.weekly-sales-report-date-picker-modal');
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-weekly-sales-report-date-picker-modal')->to(ReportManagement::class);
    }

    public function resetForm()
    {
        $this->reset([
            'date'
        ]);
    }

    public function displayWeeklySalesReport()
    {
        $this->dispatch(event: 'display-weekly-sales-report')->to(ReportManagement::class);
    }
    public function getDate(){
        $this->dispatch('generate-report', $this->date)->to(WeeklySalesReport::class);
     }
}
