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

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-yearly-sales-report-date-picker-modal')->to(ReportManagement::class);
        $this->resetValidation();

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
            'date' => 'required|integer|digits:4|before_or_equal:' . date('Y'),
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

        $this->dispatch('generate-report', $this->date)->to(YearlySalesReport::class);
        $this->displayYearlySalesReport();
    }
}
