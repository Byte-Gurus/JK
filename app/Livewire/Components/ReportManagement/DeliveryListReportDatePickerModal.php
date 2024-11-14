<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class DeliveryListReportDatePickerModal extends Component
{
    public $date;
    public function render()
    {
        return view('livewire.components.ReportManagement.delivery-list-report-date-picker-modal');
    }

    public function resetFormWhenClosed()
    {
        $this->resetForm();
        $this->dispatch(event: 'close-delivery-list-report-date-picker-modal')->to(ReportManagement::class);
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
            'date' => 'required|date|date_format:Y-m|before_or_equal:today',
        ];

        return $this->validate($rules);
    }

    public function displayDeliveryListReport()
    {
        $this->dispatch(event: 'display-delivery-list-report')->to(ReportManagement::class);
    }
    public function getDate()
    {
        $validated = $this->validateForm();
        $this->dispatch('generate-report', $this->date)->to(DeliveryListReport::class);
    }
}
