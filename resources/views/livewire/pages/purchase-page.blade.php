<div x-data="{ showModal: @entangle('showModal'), isCreate: @entangle('isCreate'), viewPurchaseOrderDetails: @entangle('viewPurchaseOrderDetails') }" x-cloak>
    <div class="flex flex-row items-center justify-between mb-[3vh]">
        <div>
            <h1 class="text-[2em] font-bold pointer-events-none">
                @if ($showPurchaseOrderDetails)
                    View Purchase Order Details
                @endif

                @if ($showPurchaseOrderForm)
                    Create Purchase Order
                @endif

                @if ($showPurchaseOrderTable)
                    Purchase Order
                @endif
            </h1>
        </div>
        <div class="flex flex-row gap-4">
            @if ($showPurchaseOrderTable)
                <button wire:click="goDeliveryPage()"
                    class="px-4 py-2 transition-all duration-100 ease-in-out bg-orange-200 rounded-md hover:rounded-lg hover:bg-orange-300 text-md">
                    <div class="flex flex-row items-center justify-center gap-2 text-sm font-bold">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                                stroke="currentColor" class="size-6">
                                <path strokeLinecap="round" strokeLinejoin="round"
                                    d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                        </div>
                        <div>
                            Go To Delivery Page
                        </div>
                    </div>
                </button>
                <button x-on:click="$wire.formCreate()" wire:click="createPO"
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
            @endif

            @if ($showPurchaseOrderForm)
                <button
                    class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out"
                    x-on:click="$wire.formCancel()">Cancel</button>
            @endif

            @if ($showPurchaseOrderDetails)
                <button
                    class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out"
                    x-on:click="$wire.returnToPurchaseOrderTable()">Return</button>
            @endif
        </div>
    </div>
    <div x-data="{ showPurchaseOrderForm: @entangle('showPurchaseOrderForm') }" x-show="showPurchaseOrderForm">
        @livewire('components.PurchaseAndDeliveryManagement.Purchase.purchase-order-form')
    </div>
    <div x-data="{ showPurchaseOrderDetails: @entangle('showPurchaseOrderDetails') }" x-show="showPurchaseOrderDetails">
        @livewire('components.PurchaseAndDeliveryManagement.Purchase.view-purchase-order-details')
    </div>
    <div x-data="{ showPurchaseOrderTable: @entangle('showPurchaseOrderTable') }" x-show="showPurchaseOrderTable">
        @livewire('components.PurchaseAndDeliveryManagement.Purchase.purchase-order-table')
    </div>
    <div x-data="{ showPrintPurchaseOrderDetails: @entangle('showPrintPurchaseOrderDetails') }" x-show="showPrintPurchaseOrderDetails">
        @livewire('components.PurchaseAndDeliveryManagement.print-purchase-order-details')
    </div>
</div>
