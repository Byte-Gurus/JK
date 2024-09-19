<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class FastMovingItemsReportDatePickerModal extends Component
{
    public function render()
    {
        return view('livewire.components.ReportManagement.fast-moving-items-report-date-picker-modal');
    }

    public function displayFastMovingItemsReport()
    {
        $this->dispatch(event: 'display-fast-moving-items-report')->to(ReportManagement::class);
    }
}
