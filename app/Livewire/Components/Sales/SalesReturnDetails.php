<?php

namespace App\Livewire\Components\Sales;

use App\Events\ReturnEvent;
use App\Livewire\Pages\CashierPage;
use App\Models\ReturnDetails;
use App\Models\Returns;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use App\Models\TransactionMovement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SalesReturnDetails extends Component
{
    use LivewireAlert;

    public $showSalesReturnForm = false;
    public $showSalesAdminLoginForm = false;
    public $returnQuantity = [];
    public $operation = [];
    public $isAdmin;
    public $description = [];
    
    public $transaction_number, $transaction_date, $total_amount, $payment_method, $reference_number, $discount_amount, $change, $tendered_amount, $subtotal, $transaction_id, $transaction_type, $new_total, $transactionDetails, $return_total_amount, $item_return_amount, $rules = [], $return_vat_amount, $new_vat_amount, $return_number, $current_tax_amount;
    public $fromPage = 'ReturnDetails';
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
        'return-sales-return-details' => 'returnSalesReturnDetails',
        'admin-confirmed' => 'adminConfirmed',
        'returnConfirmed'
    ];



    public function return()
    {

        $validated = $this->validateForm();

        $this->dispatch('get-from-page', $this->fromPage)->to(SalesAdminLoginForm::class);
        $this->displaySalesAdminLoginForm();

    }

    public function returnConfirmed()
    {
        $returns = Returns::create([
            'transaction_id' => $this->transaction_id,
            'return_total_amount' => $this->return_total_amount,
            'return_number' => $this->return_number,
            'original_amount' => $this->total_amount,
            'return_vat_amount' => $this->return_vat_amount,
            'hasTransaction' => false,
            'user_id' => Auth::id(),
        ]);

        $transaction_movement = TransactionMovement::create([
            'transaction_type' => 'Return',
            'returns_id' => $returns->id
        ]);

        foreach ($this->transactionDetails as $index => $transactionDetail) {
            if (isset($this->return_info[$index])) {
                $info = $this->return_info[$index];

                $return_details[] = ReturnDetails::create([
                    'return_quantity' => $info['return_quantity'],
                    'item_return_amount' => $info['item_return_amount'],
                    'description' => $info['description'],
                    'return_id' => $returns->id,
                    'transaction_details_id' => $info['transaction_details_id'],
                    'operation' => $info['operation'],
                    'user_id' => Auth::id(),

                ]);

                $transactionDetails = TransactionDetails::find($info['transaction_details_id']);
                $transactionDetails->status = $info['operation'];
                $transactionDetails->save();
            }
        }

        ReturnEvent::dispatch('refresh-return');

        $this->alert('success', 'Item/s was returned successfully');

        $this->dispatch('display-sales-return-slip', showSalesReturnSlip: true)->to(CashierPage::class);
        $this->dispatch('get-return-details', $returns->id)->to(SalesReturnSlip::class);
    }


    public function updatedReturnQuantity($value, $index)
    {
        $this->resetSpecificValidation("returnQuantity.$index");
        // Check if the provided index exists in the transaction details
        if (isset($this->transactionDetails[$index])) {
            $availableQty = $this->transactionDetails[$index]['item_quantity'];

            // Check if the return quantity exceeds the available quantity
            if (isset($this->returnQuantity[$index]) && $this->returnQuantity[$index] > $availableQty) {
                $this->addError('returnQuantity.' . $index, 'The return quantity must be less than or equal to the available quantity.');
                return;
            }
        }

        // If all checks pass, calculate the total refund amount
        $this->calculateTotalRefundAmount();
    }


    public function calculateTotalRefundAmount()
    {
        $this->return_total_amount = 0;
        $this->item_return_amount = 0;
        $this->return_vat_amount = 0;
        $vatable_Return_Subtotal = 0;
        $vat_exempt_Return_Subtotal = 0;
        $vatable_return_total_amount = 0;
        $vat_exempt_return_total_amount = 0;

        foreach ($this->transactionDetails as $index => $transactionDetail) {
            if (isset($this->returnQuantity[$index]) && isset($this->operation[$index]) && is_numeric($this->returnQuantity[$index]) && isset($this->description[$index])) {

                $this->return_info[$index]['operation'] = $this->operation[$index];
                $this->return_info[$index]['description'] = $this->description[$index];

                if ($this->operation[$index] != 'Exchange') {



                    if ($transactionDetail->discount_id == 3) {
                        $discounted_selling_price = $transactionDetail->item_price - ($transactionDetail->item_price * ($transactionDetail->discountJoin->percentage / 100));

                        $this->item_return_amount = $this->returnQuantity[$index] * $discounted_selling_price;

                    } else {
                        $this->item_return_amount = $this->returnQuantity[$index] * $transactionDetail->item_price;

                    }

                    $this->return_total_amount += $this->item_return_amount;

                    if ($transactionDetail->vat_type === 'Vat') {
                        $vatable_Return_Subtotal += $this->item_return_amount;
                        $vat_Percent = $transactionDetail->item_vat_percent;
                        $vatable_return_total_amount = $vatable_Return_Subtotal - ($vatable_Return_Subtotal / (100 + $vat_Percent) * 100);


                    } elseif ($transactionDetail->vat_type === 'Vat Exempt') {
                        $vat_exempt_Return_Subtotal += $this->item_return_amount;
                        $vat_Percent = $transactionDetail->item_vat_percent;
                        $vat_exempt_return_total_amount = $vat_exempt_Return_Subtotal - ($vat_exempt_Return_Subtotal / (100 + $vat_Percent) * 100);

                    }

                }


                $this->return_info[$index] = [
                    'availableQty' => $transactionDetail->item_quantity,
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
        $this->return_vat_amount = $vat_exempt_return_total_amount + $vatable_return_total_amount;
        $this->new_total = $this->total_amount - $this->return_total_amount;
    }



    private function populateForm()
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
            'current_tax_amount' => $transaction->total_vat_amount,
        ]);
    }
    //             $rules["operation.$index"] = ['required', 'in:Refund,Exchange'];
    protected function validateForm()
    {
        $rules = [];
        foreach ($this->transactionDetails as $index => $transactionDetail) {
            if (isset($this->returnQuantity[$index]) && $this->returnQuantity[$index] != null) {
                $rules["operation.$index"] = 'required|in:Refund,Exchange';
                $rules["description.$index"] = 'required|in:Damaged,Expired';
            }
        }

        return $this->validate($rules);
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
            $exists = Returns::where('return_number', $returnNumber)->exists();
        } while ($exists);

        // Assign the unique transaction number
        $this->return_number = $returnNumber;
    }

    public function adminConfirmed($isAdmin)
    {
        $this->isAdmin = $isAdmin;


        if ($this->isAdmin) {
            $this->returnConfirmed();
        }
    }

    public function updatedOperation($value, $index)
    {
        $this->returnQuantity[$index] = null;
        $this->resetSpecificValidation("returnQuantity.$index");
        $this->return_info[$index] = null;
        $this->calculateTotalRefundAmount();

    }
    public function updatedDescription($value, $index)
    {
        $this->returnQuantity[$index] = null;
        $this->resetSpecificValidation("returnQuantity.$index");
        $this->return_info[$index] = null;
        $this->calculateTotalRefundAmount();

    }
    public function displaySalesAdminLoginForm()
    {
        $this->showSalesAdminLoginForm = !$this->showSalesAdminLoginForm;
    }
    public function resetSpecificValidation($fieldName)
    {
        $this->resetErrorBag($fieldName);
    }

    public function allReturnQuantitiesNull()
    {
        foreach ($this->returnQuantity as $quantity) {
            if (!is_null($quantity) && !empty($quantity)) {
                return false;
            }
        }
        return true;
    }

    // public function validateForm()
    // {
    //     $rules = [];
    //     foreach ($this->return_info as $index => $info) {
    //         if ($this->returnQuantity[$index] != null) {
    //             $rules["description.$index"] = ['required', 'in:Damaged,Expired'];
    //             $rules["operation.$index"] = ['required', 'in:Refund,Exchange'];
    //             return $this->validate($rules);

    //         }
    //     }
    // }

}
