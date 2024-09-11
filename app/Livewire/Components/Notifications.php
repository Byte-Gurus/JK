<?php

namespace App\Livewire\Components;

use App\Models\Notification;
use Carbon\Carbon;
use Livewire\Component;

class Notifications extends Component
{
    public function render()
    {
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addMonth();

        $notifications = Notification::whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return view('livewire.components.notifications', [
            'notifications' => $notifications
        ]);
    }
}
