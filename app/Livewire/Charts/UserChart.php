<?php

namespace App\Livewire\Charts;

use App\Models\User;
use Livewire\Component;

class UserChart extends Component
{
    public function render()
    {
        $activeUsersCount = User::where('status_id', "1")->count();
        $inactiveUsersCount = User::where('status_id', "2")->count();
        return view('livewire.charts.user-chart', compact('activeUsersCount', 'inactiveUsersCount'));
    }
}
