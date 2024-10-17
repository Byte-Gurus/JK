<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class YearlySalesReportDatePickerModal extends Component
{
    public $showYearlySalesReportDatePircker = false;

    public $toYear, $fromYear;
    public function render()
    {
        return view('livewire.components.ReportManagement.yearly-sales-report-date-picker-modal');
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-yearly-sales-report-date-picker-modal')->to(ReportManagement::class);
        $this->resetValidation();

    }

    public function resetForm()
    {
        $this->reset([
            'toYear',
            'fromYear'
        ]);
    }
    public function validateForm()
    {
        $rules = [
            'toYear' => 'required|integer|digits:4|before_or_equal:' . date('Y'),
            'fromYear' => 'required|integer|digits:4|before_or_equal:toYear',
        ];

        return $this->validate($rules);
    }
    public function displayYearlySalesReport()
    {
        $this->dispatch(event: 'display-yearly-sales-report')->to(ReportManagement::class);
    }
    public function getDate()
    {


        $validated = $this->validateForm();

        $this->dispatch('generate-report', $this->fromYear, $this->toYear)->to(YearlySalesReport::class);
        $this->displayYearlySalesReport();
    }
}
