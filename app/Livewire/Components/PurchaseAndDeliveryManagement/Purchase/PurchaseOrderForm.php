<?php

namespace App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase;

use App\Livewire\Pages\PurchasePage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PurchaseOrderForm extends Component
{

    use LivewireAlert;

    public $isCreate;
    public function render()
    {
        return view('livewire.components.PurchaseAndDeliveryManagement.Purchase.purchase-order-form');
    }

    protected $listeners = [
        'edit-user-from-table' => 'edit',  //* key:'edit-user-from-table' value:'edit'  galing sa UserTable class
        //* key:'change-method' value:'changeMethod' galing sa UserTable class,  laman false
        'change-method' => 'changeMethod',
        'updateConfirmed',
        'createConfirmed',
    ];

    public function closeModal() //* close ang modal after confirmation
    {
        $this->dispatch('close-modal')->to(PurchasePage::class);
    }

    public function changeMethod($isCreate)
    {

        $this->isCreate = $isCreate; //var assign ang parameter value sa global variable

        //* kapag true ang laman ng $isCreate mag reset ang form then  go to create form and ishow ang password else hindi ishow
        if ($this->isCreate) {

            // $this->resetForm();
        } else {
        }
    }
}
