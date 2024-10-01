<div>
    <div class="flex flex-col justify-between">
        <div class="flex flex-row items-center justify-between mb-[3vh]">
            <div>
                <h1 class="text-[2em] font-bold pointer-events-none">
                        @if ($this->showDeliveryTable)
                            List of Deliveries
                        @endif
                        @if ($this->showRestockForm)
                            Restock Form
                        @endif
                        @if ($this->showBackorderForm)
                            Back Order Details
                        @endif
                </h1>
            </div>
            <div class="flex flex-row gap-4 ">
                    @if ($showRestockForm)
                        <button
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out"
                            x-on:click="$wire.closeRestockForm()">
                            Cancel
                        </button>
                    @endif
                    @if ($showBackorderForm)
                        <button
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out"
                            x-on:click="$wire.closeBackorderForm()">
                            Return
                        </button>
                    @endif
            </div>
        </div>
    </div>
        <div x-show="showDeliveryTable" x-data="{ showDeliveryTable: @entangle('showDeliveryTable') }">
            @livewire('components.PurchaseAndDeliveryManagement.Delivery.delivery-table')
        </div>
        <div x-show="showRestockForm" x-data="{ showRestockForm: @entangle('showRestockForm') }">
            @livewire('components.PurchaseAndDeliveryManagement.Delivery.restock-form')
        </div>
        <div x-show="showBackorderForm" x-data="{ showBackorderForm: @entangle('showBackorderForm') }">
            @livewire('components.PurchaseAndDeliveryManagement.Delivery.backorder-form')
        </div>
</div>
