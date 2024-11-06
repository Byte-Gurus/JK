<?php

namespace App\Livewire\Pages;

use App\Models\Log;
use Livewire\Component;

class Logs extends Component
{
    public function render()
    {
        $logs = Log::all();

        return view('livewire.pages.logs', [
            'logs' => $logs
        ]);
    }
}
