<div x-cloak>
    <div class="flex flex-row justify-between w-full">
        <div class="flex flex-row w-full items-center justify-between mb-[3vh]">
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
            @if (!$showRestockForm && !$showBackorderForm)
                <button wire:click="goPurchasePage()"
                    class="px-4 py-2 transition-all duration-100 ease-in-out bg-blue-200 rounded-md hover:rounded-lg hover:bg-blue-300 text-md">

                    <div class="flex flex-row items-center justify-center gap-2 text-sm font-bold">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                                stroke="currentColor" class="size-6">
                                <path strokeLinecap="round" strokeLinejoin="round"
                                    d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                        </div>
                        <div>
                            Go to Purchase Order Page
                        </div>
                    </div>
                </button>
            @endif
            @if ($showRestockForm)
                <button
                    class=" px-4 py-2 text-sm font-bold  bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out"
                    x-on:click="$wire.closeRestockForm()">
                    Cancel
                </button>
            @endif
            @if ($showBackorderForm)
                <button
                    class=" px-4 py-2 text-sm font-bold  bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out"
                    x-on:click="$wire.closeBackorderForm()">
                    Return
                </button>
            @endif
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
    <div x-show="showDeliveryDatePicker" x-data="{ showDeliveryDatePicker: @entangle('showDeliveryDatePicker') }">
        @livewire('components.PurchaseAndDeliveryManagement.Delivery.delivery-date-picker')
    </div>
</div>
