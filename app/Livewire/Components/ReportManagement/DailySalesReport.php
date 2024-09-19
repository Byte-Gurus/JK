<?php

namespace App\Livewire\Components\ReportManagement;

use App\Livewire\Pages\ReportManagement;
use Livewire\Component;

class DailySalesReport extends Component
{
    public $showDailySalesReport = false;

    public function render()
    {
        return view('livewire.components.ReportManagement.daily-sales-report');
    }

    protected $listeners = [
        'generate-report' => 'generateReport'
    ];

    public function generateReport($date){
        dd($date);
    }

}
