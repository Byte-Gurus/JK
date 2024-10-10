<?php

namespace App\Livewire\Components;

use App\Livewire\Components\InventoryManagement\InventoryTable;
use App\Models\Credit;
use App\Models\Inventory;
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

    public function goToOtherPage($id, $table)
    {
        if ($table == 'inventory') {
            $inventory = Inventory::find($id);

            return redirect()->route('inventorytable.index', ['sku_code' => $inventory->sku_code]);
        } elseif ($table == 'credit') {
            $credit = Credit::find($id);

            return redirect()->route('credittable.index', ['sku_code' => $credit->sku_code]);
        }
    }
}
