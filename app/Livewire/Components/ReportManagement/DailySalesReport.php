<?php

namespace App\Livewire\Components\ReportManagement;

use Livewire\Component;

class DailySalesReport extends Component
{

    public $showDailySalesReport = false;
    public function render()
    {
        return view('livewire.components.ReportManagement.daily-sales-report');
    }
}
