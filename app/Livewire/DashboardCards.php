<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;

class DashboardCards extends Component
{
    public $currentSales = 0.0;
    public function render()
    {
        if (!isset($currentSales)) {
            $this->currentSales = Transaction::sum('total_amount');
        }
        return view('livewire.dashboard-cards');
    }
    public function updateCurrentSales()
    {
        $this->currentSales = Transaction::sum('total_amount');
    }
}
