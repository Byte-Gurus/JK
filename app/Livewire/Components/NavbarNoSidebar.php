<?php

namespace App\Livewire\Components;

use Carbon\Carbon;
use Livewire\Component;

class NavbarNoSidebar extends Component
{
    public $time;
    public $date;
    public function render()
    {
        $this->showTime();
        return view('livewire.components.navbar-no-sidebar');
    }

    public function showTime()
    {
        $manilaTime = Carbon::now('Asia/Manila');

        $this->date = $manilaTime->format('F j, Y');
        $this->time = $manilaTime->format('h:i A');
    }
}
