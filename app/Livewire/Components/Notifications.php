<?php

namespace App\Livewire\Components;

use App\Livewire\Components\CreditManagement\CreditTable;
use App\Livewire\Components\InventoryManagement\InventoryTable;
use App\Livewire\Pages\InventoryManagementPage;
use App\Models\Credit;
use App\Models\Inventory;
use App\Models\Notification;
use Carbon\Carbon;
use Livewire\Component;

class Notifications extends Component
{
    public function render()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();


        $notifications = Notification::whereBetween('created_at', [$startDate, $endDate])
            ->get();



        return view('livewire.components.notifications', [
            'notifications' => $notifications
        ]);
    }

    public function goToOtherPage($id, $table)
    {
        if ($table == 'inventory') {
            $inventory = Inventory::find($id);

            $this->dispatch('set-search', $inventory->sku_code)->to(InventoryTable::class);
        } elseif ($table == 'credit') {
            $credit = Credit::find($id);

            $this->dispatch('set-search', $credit->credit_number)->to(CreditTable::class);

        }
    }
}
