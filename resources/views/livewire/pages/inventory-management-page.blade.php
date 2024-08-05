<div x-data="{ sidebar: @entangle('sidebarStatus') }"
    @if (!$this->sidebarStatus) class=" ml-[220px] transition-all ease-in-out duration-75"
    @else
        class=" ml-[0px] transition-all ease-in-out duration-100" @endif>
    @livewire('components.navbar')
    <div x-data="{ showModal: @entangle('showModal') }">
        <div class="m-[28px]">
            <div class="flex flex-col justify-between">
                <div class="flex flex-row items-center justify-between">
                    <div>
                        <h1 class="text-[2em] font-bold pointer-events-none">Manage Inventory</h1>
                    </div>
                    <div class="flex flex-row items-center gap-4">
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
            <div>
                {{-- @livewire('components.InventoryManagement.inventory-form') --}}
            </div>
            <div class="my-[28px]">
                @livewire('components.InventoryManagement.inventory-table')
            </div>
        </div>
    </div>
</div>
