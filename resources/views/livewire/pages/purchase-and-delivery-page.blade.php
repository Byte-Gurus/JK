<div x-data="{ sidebar: @entangle('sidebarStatus'), showPurchaseOrder: @entangle('purchaseOrderOpen') }"
    @if (!$this->sidebarStatus) class=" ml-[220px] transition-all ease-in-out duration-75"
    @else
        class=" ml-[0px] transition-all ease-in-out duration-100" @endif>
        @livewire('components.navbar')
        <div class=" mx-[28px] mt-4 text-right">
            <button wire:click="togglePurchaseOrder()"
                @if ($purchaseOrderOpen) class="px-4 py-2 transition-all duration-100 ease-in-out bg-orange-200 rounded-md hover:rounded-lg hover:bg-orange-300 text-md"
        @else
        class="px-4 py-2 transition-all duration-100 ease-in-out bg-blue-200 rounded-md hover:rounded-lg hover:bg-blue-300 text-md" @endif>
                @if ($purchaseOrderOpen)
                    <div class="flex flex-col items-center justify-center px-1">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                                stroke="currentColor" class="size-6">
                                <path strokeLinecap="round" strokeLinejoin="round"
                                    d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                        </div>
                        <div>
                            Delivery
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                                stroke="currentColor" class="size-6">
                                <path strokeLinecap="round" strokeLinejoin="round"
                                    d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                        </div>
                        <div>
                            Purchase
                        </div>
                    </div>
                @endif
            </button>
        </div>
        <div class=" m-[28px] duration-700 ease-linear transition-all">
            @if ($purchaseOrderOpen)
                @livewire('pages.purchase-page')
            @else
                @livewire('pages.delivery-page')
            @endif
        </div>
</div>
