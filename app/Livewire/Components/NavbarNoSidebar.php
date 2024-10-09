<?php

namespace App\Livewire\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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

    public function isAdmin()
    {
        $user = Auth::user();

        if ($user->user_role_id == 1 && $user->status_id == 1) {
            return true;
        }

        return false;
    }
}
