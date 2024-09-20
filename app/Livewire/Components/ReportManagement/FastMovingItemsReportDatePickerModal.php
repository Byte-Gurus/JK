<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class FastMovingItemsReportDatePickerModal extends Component
{
    public $date;
    public function render()
    {
        return view('livewire.components.ReportManagement.fast-moving-items-report-date-picker-modal');
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-fast-moving-items-report-date-picker-modal')->to(ReportManagement::class);
    }

    public function resetForm()
    {
        $this->reset([
            'date'
        ]);
    }

    public function displayFastMovingItemsReport()
    {
        $this->dispatch(event: 'display-fast-moving-items-report')->to(ReportManagement::class);
    }
    public function getDate(){
        $this->dispatch('generate-report', $this->date)->to(FastMovingItemsReport::class);
     }
}
