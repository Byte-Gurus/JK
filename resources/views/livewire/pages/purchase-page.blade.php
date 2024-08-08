<div>
    <div class="flex flex-col justify-between">
        <div class="flex flex-row items-center justify-between mb-4">
            <div>
                <h1 class="text-[2em] font-bold pointer-events-none">
                    @if ($this->isCreate)
                        Create Purchase Order
                    @else
                        Purchase Order
                    @endif
                </h1>
            </div>
            <div x-data="{ showModal: @entangle('showModal') }">
                @if ($this->showModal)
                    <button
                        class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out"
                        x-on:click="showModal=false;$wire.formCancel()">Cancel</button>
                @else
                    <button x-on:click="showModal=true;$wire.formCreate()"
                        class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(158,255,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out">
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
                @endif
            </div>
        </div>
    </div>

    @if ($this->showModal)
        <div>
            @livewire('components.PurchaseAndDeliveryManagement.Purchase.purchase-order-form')
        </div>
    @else
        <div>
            @livewire('components.PurchaseAndDeliveryManagement.Purchase.purchase-order-table')
        </div>
    @endif

</div>
