<div>
    <div class="flex flex-col justify-between">
        <div class="flex flex-row items-center justify-between mb-4">
            <div>
                <h1 class="text-[2em] font-bold pointer-events-none">
                    @if (!$showRestockForm)
                        List of Deliveries
                    @else
                        @if ($openDeliveryDetails)
                            Delivery Details
                        @else
                            Restock
                        @endif
                    @endif
                </h1>
            </div>
            @if ($showRestockForm)
                @if ($openDeliveryDetails)
                    <button
                        class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out"
                        x-on:click="$wire.cancelRestockForm(); $wire.closeDeliveryDetails()">
                        Return
                    </button>
                @else
                    <button
                        class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out"
                        x-on:click="$wire.cancelRestockForm(); $wire.closeDeliveryDetails()">
                        Cancel
                    </button>
                @endif
            @endif
        </div>
    </div>
    @if (!$showRestockForm)
        <div>
            @livewire('components.PurchaseAndDeliveryManagement.Delivery.delivery-table')
        </div>
    @endif
    <div x-show="openDeliveryDetails" x-data="{ openDeliveryDetails: @entangle('openDeliveryDetails') }">
        @livewire('components.PurchaseAndDeliveryManagement.Delivery.view-delivery-details')
    </div>
    <div x-show="showRestockForm" x-data="{ showRestockForm: @entangle('showRestockForm') }">
        @livewire('components.PurchaseAndDeliveryManagement.Delivery.restock-form')
    </div>
</div>
