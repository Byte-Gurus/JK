<div>
    <div class="flex flex-col justify-between">
        <div class="flex flex-row items-center justify-between mb-4">
            <div>
                <h1 class="text-[2em] font-bold pointer-events-none">
                    @if (!$showRestockForm)
                        List of Deliveries
                    @else
                        @if ($showDeliveryDetails)
                            Delivery Details
                        @else
                            Restock
                        @endif
                    @endif
                </h1>
            </div>
            <div class="flex flex-row gap-4 ">
                <div>
                    <button wire:click='viewBackOrderPage()'
                        class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(183,180,255)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(194,128,255)] transition-all duration-100 ease-in-out">Backorders</button>
                </div>
                @if ($showRestockForm)
                    @if ($showDeliveryDetails)
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
    </div>
    <div x-show="showDeliveryTable" x-data="{ showDeliveryTable: @entangle('showDeliveryTable') }">
        @livewire('components.PurchaseAndDeliveryManagement.Delivery.delivery-table')
    </div>
    <div x-show="showDeliveryDetails" x-data="{ showDeliveryDetails: @entangle('showDeliveryDetails') }">
        @livewire('components.PurchaseAndDeliveryManagement.Delivery.view-delivery-details')
    </div>
    <div x-show="showRestockForm" x-data="{ showRestockForm: @entangle('showRestockForm') }">
        @livewire('components.PurchaseAndDeliveryManagement.Delivery.restock-form')
    </div>
    <div x-show"showBackOrderPage" x-data="{ showBackOrderPage: @entangle('showBackOrderPage') }">
        @livewire('components.PurchaseAndDeliveryManagement.Delivery.back-order-page')
    </div>
</div>
