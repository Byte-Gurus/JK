<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class DamagedItemsReportDatePickerModal extends Component
{
    public $showDamagedItemsReportDatePickerModal = true;

    public $toDate, $fromDate;
    public function render()
    {
        return view('livewire.components.ReportManagement.damaged-items-report-date-picker-modal');
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-damaged-items-report-date-picker-modal')->to(ReportManagement::class);
    }

    public function resetForm()
    {
        $this->reset([
            'toDate',
            'fromDate'
        ]);
    }

    public function displayExpiredItemsReport()
    {
        $this->dispatch( 'display-damaged-items-report')->to(ReportManagement::class);
    }

    public function getDate()
    {
        $this->dispatch('generate-report', $this->toDate, $this->fromDate)->to(DamagedItemsReport::class);
    }
}