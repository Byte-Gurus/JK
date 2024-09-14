<?php

namespace App\Livewire;

use App\Models\Inventory;
use App\Models\ReturnDetails;
use App\Models\Transaction;
use Livewire\Component;

class DashboardCards extends Component
{
    public $overallSales, $overallStocks, $overallReturn;
    public function render()
    {

        $this->overallSales = Transaction::sum('total_amount');
        $this->overallStocks = Inventory::where('status', 'Available')->sum('current_stock_quantity');
        $this->overallReturn = ReturnDetails::sum('return_quantity');

        return view('livewire.dashboard-cards');
    }
}
