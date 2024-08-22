<div x-data="{ sidebar: @entangle('sidebarStatus') }"
    @if (!$this->sidebarStatus) class=" ml-[220px] transition-all ease-in-out duration-75"
    @else
        class=" ml-[0px] transition-all ease-in-out duration-100" @endif>
    @livewire('components.navbar')
    <div x-data="{ showStockAdjustModal: @entangle('showStockAdjustModal'), showInventoryHistory: @entangle('showInventoryHistory')}">
        <div class="m-[28px]">
            <div class="flex flex-col justify-between">
                <div class="flex flex-row items-center justify-between">
                    <div>
                        <h1 class="text-[2em] font-bold pointer-events-none">Manage Inventory</h1>
                    </div>
                    <div class="flex flex-row items-center gap-4">
                        <div>
                            <button
                            wire:click="showInventory()"
                            >
                                <div
                                    class="flex flex-col items-center justify-center px-4 py-2 transition-all duration-75 ease-in-out bg-blue-100 rounded-md hover:bg-blue-200">
                                    <div><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            strokeWidth={1.5} stroke="currentColor" class="size-6">
                                            <path strokeLinecap="round" strokeLinejoin="round"
                                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                        </svg>
                                    </div>
                                    <div>History</div>
                                </div>
                            </button>
                        </div>
                        <div>
                            <button>
                                <div
                                    class="flex flex-col items-center justify-center px-4 py-2 transition-all duration-75 ease-in-out bg-green-100 rounded-md hover:bg-green-200">
                                    <div><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 9.75h4.875a2.625 2.625 0 0 1 0 5.25H12M8.25 9.75 10.5 7.5M8.25 9.75 10.5 12m9-7.243V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0c1.1.128 1.907 1.077 1.907 2.185Z" />
                                        </svg>
                                    </div>
                                    <div>Restock</div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                {{-- @livewire('components.InventoryManagement.inventory-form') --}}
            </div>

            @if (!$showInventoryHistory)
            <div class="my-[28px]">
                @livewire('components.InventoryManagement.inventory-table')
            </div>
            @else
            <div class="my-[28px]">
                @livewire('components.InventoryManagement.inventory-history')
            </div>
            @endif
            <div class="my-[28px]">
                @livewire('components.InventoryManagement.stock-adjust-form')
            </div>
        </div>
    </div>
</div>
