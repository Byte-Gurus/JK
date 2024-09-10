<?php

namespace App\Livewire\Pages;

use App\Livewire\Charts\DailySalesChart;
use App\Livewire\Charts\WeeklySalesChart;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $day, $week, $month, $year;
    public $selectPicker = 1;
    public $sidebarStatus;
    public function render()
    {
        return view('livewire.pages.dashboard');
    }

    protected $listeners = [
        'close-modal' => 'closeModal',
        'change-sidebar-status' => 'changeSidebarStatus'
    ];

    public function changeSidebarStatus($sidebarOpen)
    {
        $this->sidebarStatus = $sidebarOpen;
    }

    public function updatedSelectPicker($picker)
    {
        $this->selectPicker = $picker;
       
    }
}
