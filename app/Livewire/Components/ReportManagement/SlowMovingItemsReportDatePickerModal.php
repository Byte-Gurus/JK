<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class SlowMovingItemsReportDatePickerModal extends Component
{
    public $date;
    public function render()
    {
        return view('livewire.components.ReportManagement.slow-moving-items-report-date-picker-modal');
    }

    public function displaySlowMovingItemsReport()
    {
        $this->dispatch(event: 'display-slow-moving-items-report')->to(ReportManagement::class);
    }
    public function getDate()
    {
        $this->dispatch('generate-report', $this->date)->to(SlowMovingItemsReport::class);
    }
}
