<?php

namespace App\Livewire\Components\Sales;

use App\Events\ReturnEvent;
use App\Models\ReturnDetails;
use App\Models\Returns;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use App\Models\TransactionMovement;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SalesReturnDetails extends Component
{
    use LivewireAlert;
    public $showSalesReturnForm = false;
    public $showAdminLoginForm = false;

    public $returnQuantity = [];
    public $operation = [];
    public $description = [];
    public $transaction_number, $transaction_date, $total_amount, $payment_method, $reference_number, $discount_amount, $change, $tendered_amount, $subtotal, $transaction_id, $transaction_type, $new_total, $transactionDetails, $return_total_amount, $item_return_amount, $rules = [], $return_vat_amount, $new_vat_amount, $return_number;

    public $return_info = [];

    public function mount()
    {
        $this->generateReturnNumber();
    }

    public function render()
    {

        $this->transactionDetails = TransactionDetails::where('transaction_id', $this->transaction_id)->get();

        return view('livewire.components.Sales.sales-return-details', [
            'transactionDetails' => $this->transactionDetails,
        ]);
    }
    protected $listeners = [
        'get-transaction' => 'getTransaction',
        'returnConfirmed'
    ];

    public function return()
    {

        foreach ($this->return_info as $index => $info) {
            if ($this->returnQuantity[$index] > 0) {
                $this->rules["description.$index"] = ['required', 'in:Damaged,Expired'];
                $this->rules["operation.$index"] = ['required', 'in:Refund,Exchange'];
            }
        }
        $this->validate($this->rules);

        $this->confirm('Do you want to return this items?', [
            'onConfirmed' => 'returnConfirmed', //* call the createconfirmed method

        ]);
    }

    public function returnConfirmed()
    {

        $old_transaction = Transaction::find($this->transaction_id);
        // $old_transaction->transaction_type = 'Return';
        // $old_transaction->save();

        // $transaction->total_amount = $this->new_total;
        // $transaction->total_vat_amount = $this->new_vat_amount;

        $returns = Returns::create([
            'transaction_id' => $this->transaction_id,
            'return_total_amount' => $this->return_total_amount,
            'return_number' => $this->return_number,
            'original_amount' => $this->total_amount,

        ]);

        // $tranasction = Transaction::create([
        //     'transaction_number' =
        // 'transaction_type' =>
        // 'subtotal',
        // 'discount_id',
        // 'total_amount',
        // 'total_vat_amount',
        // 'total_discount_amount',
        // 'customer_id',
        // 'user_id'
        // ])



        foreach ($this->transactionDetails as $index => $transactionDetail) {
            // Ensure the index exists in return_info array
            if (isset($this->return_info[$index])) {
                $info = $this->return_info[$index];

                // Create return details record
                ReturnDetails::create([
                    'return_quantity' => $info['return_quantity'],
                    'item_return_amount' => $info['item_return_amount'],
                    'description' => $info['description'],
                    'return_id' => $returns->id,
                    'transaction_details_id' => $info['transaction_details_id'],
                    'operation' => $info['operation'],
                ]);

                $transactionDetails = TransactionDetails::find($info['transaction_details_id']);
                $transactionDetails->status = $info['operation'];
                $transactionDetails->save();
            }
        }

        ReturnEvent::dispatch('refresh-return');

        $this->alert('success', 'Item/s was returned successfully');
    }
    public function updatedOperation($value, $ind)
    {
        foreach ($this->transactionDetails as $index => $transactionDetail) {

            if (isset($this->operation[$index])) {
                $this->return_info[$index]['operation'] = $this->operation[$index];
            }
        }

        if (isset($this->returnQuantity[$ind])) {
            $this->returnQuantity[$ind] = 0;
            $this->calculateTotalRefundAmount();
        }

        if ($this->operation[$ind] === '') {
            unset($this->returnQuantity[$ind]);
            unset($this->description[$ind]);
            unset($this->return_info[$ind]);
            unset($this->operation[$ind]);


            $this->calculateTotalRefundAmount();
        }

        $this->resetValidation();
    }
    public function updatedReturnQuantity()
    {
        $validated = $this->validateForm();
        $this->calculateTotalRefundAmount();
    }

    public function calculateTotalRefundAmount()
    {
        $this->return_total_amount = 0;
        $this->item_return_amount = 0;
        $this->return_vat_amount = 0;

        foreach ($this->transactionDetails as $index => $transactionDetail) {


            if (isset($this->returnQuantity[$index]) && isset($this->operation[$index]) && is_numeric($this->returnQuantity[$index])) {

                if ($this->operation[$index] != 'Exchange') {
                    $this->item_return_amount = $this->returnQuantity[$index] * $transactionDetail['inventoryJoin']['selling_price'];

                    $this->return_total_amount += $this->item_return_amount;

                    $transactionDetail->item_subtotal -= ($transactionDetail->item_subtotal / ($transactionDetail->itemJoin->vat_percent + 100) * 100);

                    $this->return_vat_amount += $transactionDetail->item_subtotal;


                    $total_vat_amount = $transactionDetail->transactionJoin->total_vat_amount;

                    $this->new_vat_amount = round($total_vat_amount - $this->return_vat_amount);

                }



                if ($this->returnQuantity[$index] >= $transactionDetail->itemJoin->bulk_quantity) {
                    $this->return_total_amount = $this->return_total_amount - $transactionDetail->item_discount_amount;
                }


                $this->return_info[$index] = [
                    'item_return_amount' => $this->item_return_amount,
                    'return_quantity' => $this->returnQuantity[$index],
                    'description' => $this->description[$index] ?? '',
                    'transaction_details_id' => $transactionDetail->id,
                    'item_id' => $transactionDetail->item_id,
                    'inventory_id' => $transactionDetail->inventory_id,
                    'operation' => $this->operation[$index]

                ];
            }
        }


        $this->new_total = $this->total_amount - $this->return_total_amount;
    }
    public function updatedDescription()
    {
        foreach ($this->transactionDetails as $index => $transactionDetail) {
            // Check if returnQuantity at $index is set and greater than 0
            if (isset($this->returnQuantity[$index]) && isset($this->operation[$index]) && $this->returnQuantity[$index] > 0) {
                // Check if description at $index exists
                if (isset($this->description[$index])) {
                    $this->return_info[$index]['description'] = $this->description[$index];
                }
            }
        }
    }

    private function populateForm() //*lagyan ng laman ang mga input
    {

        $transaction = Transaction::find($this->transaction_id);

        $this->fill([
            'transaction_number' => $transaction->transaction_number,
            'transaction_date' => $transaction->created_at,
            'transaction_type' => $transaction->transaction_type ?? 'N/A',
            'total_amount' => $transaction->total_amount,
            'payment_method' => $transaction->paymentJoin->payment_type ?? 'N/A',
            'reference_number' => $transaction->paymentJoin->reference_number ?? 'N/A',
            'discount_amount' => $transaction->total_discount_amount,
            'change' => ($transaction->paymentJoin->tendered_amount ?? 0) - ($transaction->paymentJoin->amount ?? 0),
            'tendered_amount' => $transaction->paymentJoin->tendered_amount ?? 0,
            'subtotal' => $transaction->subtotal,

        ]);
    }
    protected function validateForm()
    {

        foreach ($this->transactionDetails as $index => $transactionDetail) {
            if (isset($this->returnQuantity[$index])) {
                $availableQty = $transactionDetail['item_quantity']; // Replace with the actual field for quantity
                $this->rules["returnQuantity.$index"] = ['required', 'numeric', 'min:1', "lte:$availableQty"];
            }
        }



        return $this->validate($this->rules);
    }

    public function getTransaction($Transaction)
    {
        $this->transaction_id = $Transaction['id'];
        $this->populateForm();
    }

    public function displaySalesReturnForm()
    {
        $this->showSalesReturnForm = true;
    }

    public function displayAdminLoginForm()
    {
        $this->showAdminLoginForm = true;
    }

    public function getItem($transactionDetails_id)
    {

        $this->dispatch('get-transaction-details', transactionDetails_ID: $transactionDetails_id)->to(SalesReturnForm::class);
    }

    public function generateReturnNumber()
    {
        do {
            $randomNumber = random_int(0, 9999);
            $formattedNumber = str_pad($randomNumber, 4, '0', STR_PAD_LEFT);
            $returnNumber = 'RN-' . $formattedNumber . '-' . now()->format('mdY');

            // Check if the transaction number already exists
            $exists = Returns::where('transaction_number', $returnNumber)->exists();
        } while ($exists);

        // Assign the unique transaction number
        $this->return_number = $returnNumber;
    }

}
