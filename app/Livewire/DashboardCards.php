<?php

namespace App\Livewire;

use App\Models\Delivery;
use App\Models\Inventory;
use App\Models\ReturnDetails;
use App\Models\Transaction;
use Livewire\Component;

class DashboardCards extends Component
{
    public $overallSales, $overallStocks, $overallReturn, $deliveryInProgress;
    public function render()
    {

        $this->overallSales = Transaction::whereNotIn('transaction_type', ['Return', 'Void'])
            ->whereDoesntHave('transactionDetailsJoin', function ($query) {
                $query->whereIn('status', ['Void', 'Return']);
            })
            ->sum('total_amount');

        $this->overallStocks = Inventory::where('status', 'Available')->sum('current_stock_quantity');
        $this->overallReturn = ReturnDetails::sum('return_quantity');
        $this->deliveryInProgress = Delivery::where('status', 'In Progress')->count();


        return view('livewire.dashboard-cards');
    }
}
