<div x-data="{ showModal: @entangle('showModal'), isCreate: @entangle('isCreate'), viewPurchaseOrderDetails: @entangle('viewPurchaseOrderDetails') }" x-cloak>
    <div class="flex flex-col justify-between">
        <div class="flex flex-row items-center justify-between mb-4">
            <div>
                <h1 class="text-[2em] font-bold pointer-events-none">
                    @if ($this->showModal)
                        @if ($viewPurchaseOrderDetails)
                            View Purchase Order Details
                        @else
                            Create Purchase Order
                        @endif
                    @else
                        Purchase Order
                    @endif
                </h1>
            </div>
            <div>
                @if (!$showModal)
                    <button x-on:click="showModal=true;$wire.formCreate()"
                        class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(158,255,128)] transition-all duration-100 ease-in-out">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d=" M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <div>
                            <p>Add New Purchase Order</p>
                        </div>
                    </button>
                @else
                    @if ($viewPurchaseOrderDetails)
                        <button
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out"
                            x-on:click="showModal=false;$wire.returnToTable()">Return</button>
                    @else
                        <button
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out"
                            x-on:click="showModal=false;$wire.formCancel()">Cancel</button>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div>
        @livewire('components.PurchaseAndDeliveryManagement.Purchase.purchase-order-form')
    </div>
    <div x-show="viewPurchaseOrderDetails">
        @livewire('components.PurchaseAndDeliveryManagement.Purchase.view-purchase-order-details')
    </div>
    @if (!$this->showModal)
        <div>
            @livewire('components.PurchaseAndDeliveryManagement.Purchase.purchase-order-table')
        </div>
    @endif
    <table>
        <thead>
            <tr>hi</tr>
        </thead>
        <tbody>
            <tr>
                <label for="datepicker">Expiration Date</label>
                <input type="text" id="datepicker" wire:change="hi(picker.toString('YYYY-MM-DD'))">
            </tr>
        </tbody>
    </table>
</div>
<script src="pikaday.js"></script>
<script>
    var picker = new Pikaday({
        field: document.getElementById('datepicker')
    });
</script>
