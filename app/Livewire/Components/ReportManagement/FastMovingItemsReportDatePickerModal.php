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
    public function validateForm()
    {
        $rules = [
            'date' => 'required|date|date_format:Y-m|before_or_equal:today',
        ];

        return $this->validate($rules);
    }
    public function displayFastMovingItemsReport()
    {

        $this->dispatch(event: 'display-fast-moving-items-report')->to(ReportManagement::class);
    }
    public function getDate()
    {
        $validated = $this->validateForm();
        $this->dispatch('generate-report', $this->date)->to(FastMovingItemsReport::class);
        $this->displayFastMovingItemsReport();
    }
}
