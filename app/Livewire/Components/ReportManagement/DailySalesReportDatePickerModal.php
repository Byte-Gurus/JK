<?php

namespace App\Livewire\Components\ReportManagement;

use App;
use App\Livewire\Pages\ReportManagement;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DailySalesReportDatePickerModal extends Component
{
    public $showDailySalesReportDatePickerModal = false;
    public $date;

    public function render()
    {
        return view('livewire.components.ReportManagement.daily-sales-report-date-picker-modal');
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-daily-sales-report-date-picker-modal')->to(ReportManagement::class);
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
            'date' => 'required|date|before_or_equal:today|after_or_equal:1924-01-01',
        ];

        return $this->validate($rules);
    }
    public function displayDailySalesReport()
    {
        // route('daily.sales.report', '_blank');
        $this->dispatch('display-daily-sales-report')->to(ReportManagement::class);

    }

    public function getDate()
    {
        $validated = $this->validateForm();


        $this->dispatch('generate-report', $this->date)->to(DailySalesReport::class);
        $this->displayDailySalesReport();
    }


}
