<?php

namespace App\Livewire\Components\ReportManagement;

use App\Models\Delivery;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeliveryListReport extends Component
{
    public $deliveries;
    public $date, $dateCreated, $createdBy;
    public $isTransactionEmpty = false;
    public function render()
    {
        return view('livewire.components.ReportManagement.delivery-list-report');
    }

    protected $listeners = [
        'generate-report' => 'generateReport'
    ];

    public function generateReport($month)
    {

        $date = Carbon::createFromFormat('Y-m', $month);

        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        $this->deliveries = Delivery::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();

        $this->date = $startOfMonth->format('M d Y') . ' - ' . $endOfMonth->format('M d Y');
        $this->dateCreated = Carbon::now()->format('M d Y h:i A');
        $this->createdBy = Auth::user()->firstname . ' ' . (Auth::user()->middlename ? Auth::user()->middlename . ' ' : '') . Auth::user()->lastname;
    }

}
