<?php

namespace App\Livewire\Pages;

use App\Models\Log;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
class Logs extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $perPage = 10;
    public function render()
    {
        $logs = Log::query()->paginate($this->perPage);
        ;

        return view('livewire.pages.logs', [
            'logs' => $logs
        ]);
    }
}
