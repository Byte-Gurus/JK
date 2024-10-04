<?php

namespace App\Livewire\Components\InventoryManagement;

use App\Models\Inventory;
use App\Models\InventoryMovement;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ViewStockCard extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $stock_id, $item_name, $item_description, $expiration_date, $supplier, $barcode, $selling_price;

    public $stock_cards = [];
    public $quantity_balance, $total_in_quantity, $total_in_value, $total_out_quantity, $total_out_value;
    public $startDate, $endDate;
    public function render()
    {
        if ($this->stock_id) {
            $this->computeStockCardData();
        }

        return view('livewire.components.InventoryManagement.view-stock-card', ['stock_cards' => $this->stock_cards]);
    }

    protected $listeners = [
        'stock-card' => 'stockCard', //*  galing sa UserTable class
        "echo:refresh-adjustment,AdjustmentEvent" => 'refreshFromPusher',
        "echo:refresh-stock,RestockEvent" => 'refreshFromPusher',
        "echo:refresh-transaction,TransactionEvent" => 'refreshFromPusher',
    ];

    private function populateForm() //*lagyan ng laman ang mga input
    {

        $stock_details = Inventory::find($this->stock_id); //? kunin lahat ng data ng may ari ng item_id


        $this->fill([
            'item_name' => $stock_details->itemJoin->item_name,
            'item_description' => $stock_details->itemJoin->item_description,
            'expiration_date' => $stock_details->expiration_date,
            'barcode' => $stock_details->itemJoin->barcode,
            'supplier' => $stock_details->deliveryJoin->purchaseJoin->supplierJoin->company_name,
            'selling_price' => $stock_details->selling_price,
        ]);
    }

    public function stockCard($stockID)
    {
        $this->stock_id = $stockID;
        $this->populateForm();
    }

    public function computeStockCardData()
    {
        $query = InventoryMovement::with(['inventoryJoin', 'adjustmentJoin.inventoryJoin', 'transactionDetailsJoin.inventoryJoin'])
            ->where(function ($query) {
                $query->whereHas('inventoryJoin', function ($query) {
                    $query->where('id', $this->stock_id);
                })
                    ->orWhereHas('adjustmentJoin.inventoryJoin', function ($query) {
                        $query->where('id', $this->stock_id);
                    })
                    ->orWhereHas('transactionDetailsJoin.inventoryJoin', function ($query) {
                        $query->where('id', $this->stock_id);
                    });
            });

        // Apply date range filter if both startDate and endDate are provided
        if ($this->startDate && $this->endDate) {
            $startDate = Carbon::parse($this->startDate)->startOfDay();
            $endDate = Carbon::parse($this->endDate)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $this->stock_cards = $query->get();

        $processedStockCards = [];
        $this->quantity_balance = 0;
        $this->total_in_quantity = 0;
        $this->total_in_value = 0;
        $this->total_out_quantity = 0;
        $this->total_out_value = 0;

        foreach ($this->stock_cards as $stock_card) {
            $in_quantity = 0;
            $in_value = 0;
            $out_quantity = 0;
            $out_value = 0;
            $value = 0; // Initialize value for each card

            switch ($stock_card->operation) {
                case 'Stock In':
                    $in_quantity = $stock_card->inventoryJoin->stock_in_quantity;
                    $this->quantity_balance += $in_quantity;
                    $in_value = $in_quantity * $stock_card->inventoryJoin->selling_price;
                    break;

                case 'Add':
                    $in_quantity = $stock_card->adjustmentJoin->adjusted_quantity;
                    $this->quantity_balance += $in_quantity;
                    $in_value = $in_quantity * $stock_card->adjustmentJoin->inventoryJoin->selling_price;
                    break;

                case 'Stock out':
                    $out_quantity = $stock_card->transactionDetailsJoin->item_quantity;
                    $this->quantity_balance -= $out_quantity;
                    $out_value = $out_quantity * $stock_card->transactionDetailsJoin->item_price;
                    break;

                case 'Deduct':
                    $out_quantity = $stock_card->adjustmentJoin->adjusted_quantity;
                    $this->quantity_balance -= $out_quantity;
                    $out_value = $out_quantity * $stock_card->adjustmentJoin->inventoryJoin->selling_price;
                    break;
                case 'Void':
                    $in_quantity = $stock_card->transactionDetailsJoin->item_quantity;
                    $this->quantity_balance += $in_quantity;
                    $in_value = $in_quantity * $stock_card->transactionDetailsJoin->item_price;
            }

            switch ($stock_card->operation) {
                case 'Add':
                case 'Deduct':
                    $selling_price = $stock_card->adjustmentJoin->inventoryJoin->selling_price;
                    break;

                case 'Stock In':
                    $selling_price = $stock_card->inventoryJoin->selling_price;
                    break;
                case 'Stock Out':
                case 'Void':
                    $selling_price = $stock_card->transactionDetailsJoin->item_price;
                    break;
            }

            $value = $this->quantity_balance * $selling_price;

            if ($stock_card->operation !== 'Void') {
                $this->total_in_quantity += $in_quantity;
                $this->total_in_value += $in_value;
            }
            
            $this->total_out_quantity += $out_quantity;
            $this->total_out_value += $out_value;

            $processedStockCards[] = [
                'created_at' => $stock_card->created_at->format('d-m-y h:i A'),
                'movement_type' => $stock_card->movement_type,
                'operation' => $stock_card->operation,
                'in_quantity' => $in_quantity,
                'in_value' => $in_value,
                'out_quantity' => $out_quantity,
                'out_value' => $out_value,
                'quantity_balance' => $this->quantity_balance,
                'value' => $value,
            ];
        }

        $this->stock_cards = $processedStockCards;
    }
    public function refreshFromPusher()
    {
        $this->resetPage();
    }
}
