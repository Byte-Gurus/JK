<?php

namespace App\Livewire\Components;

use App\Livewire\Components\CreditManagement\CreditTable;
use App\Livewire\Components\InventoryManagement\InventoryTable;
use App\Livewire\Pages\InventoryManagementPage;
use App\Models\Credit;
use App\Models\Inventory;
use App\Models\Notification;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{
    public function render()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();


        $notifications = Notification::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();


        return view('livewire.components.notifications', [
            'notifications' => $notifications
        ]);
    }

    public function goToOtherPage($id, $table)
    {
        $inventory = Inventory::find($id);

        if (Auth::user()->user_role_id == 3) {
            $this->dispatch('set-search', $inventory->sku_code)->to(InventoryTable::class);
        } else {
            if ($table == 'inventory') {
                return redirect()->route('inventorymanagement.index', ['sku_code' => $inventory->sku_code]);
            } elseif ($table == 'credit') {
                $credit = Credit::find($id);

                return redirect()->route('creditmanagement.index', ['sku_code' => $credit->sku_code]);
            }
        }

    }
}
