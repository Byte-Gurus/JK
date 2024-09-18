<?php

namespace App\Livewire\Charts;

use App\Models\InventoryMovement;
use Livewire\Component;

class InventoryMovementChart extends Component
{
    public $Stock_In, $Stock_Out, $Add, $Deduct;
    public function render()
    {
        $this->getOperation();
        return view('livewire.charts.inventory-movement-chart', [
            'Stock_In' => $this->Stock_In,
            'Stock_Out' => $this->Stock_Out,
            'Add' => $this->Add,
            'Deduct' => $this->Deduct
        ]);
    }

    public function getOperation()
    {


        $this->Stock_In = InventoryMovement::where('operation', 'Stock In')->count();
        $this->Stock_Out = InventoryMovement::where('operation', 'Stock out')->count();
        $this->Add = InventoryMovement::where('operation', 'Add')->count();
        $this->Deduct = InventoryMovement::where('operation', 'Deduct')->count();
    }
}
