<div x-data="{ sidebar: @entangle('sidebarStatus') }"
    @if (!$this->sidebarStatus) class=" ml-[220px] transition-all ease-in-out duration-100"
    @else
        class=" ml-[0px] transition-all ease-in-out duration-100" @endif>
    @livewire('components.navbar')
    <div x-data="{ showModal: @entangle('showModal') }">
        <div class="m-[3vh]">
            <div class="flex flex-col justify-between">
                <div class="flex flex-row items-center justify-between">
                    <div>
                        <h1 class="text-[2em] font-bold pointer-events-none">
                            @if ($this->showSupplierTable)
                                Manage Supplier
                            @else
                                Supplier Item Costs
                            @endif
                        </h1>
                    </div>
                    @if ($this->showSupplierTable)
                        <div class="flex flex-row gap-2">
                            <button
                                class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(158,255,128)] transition-all duration-100 ease-in-out"
                                x-on:click="showModal=true;$wire.formCreate()">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </div>
                                <div>
                                    <p>Add New Supplier</p>
                                </div>
                            </button>
                        </div>
                    @else
                        <div>
                            <button x-on:click="$wire.returnToSupplierManagementPage()">
                                <div
                                    class="flex flex-row items-center justify-center gap-2 px-4 py-2 font-bold transition-all duration-75 ease-in-out bg-red-100 rounded-md hover:bg-red-200">
                                    <div><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            strokeWidth={1.5} stroke="currentColor" class="size-6">
                                            <path strokeLinecap="round" strokeLinejoin="round"
                                                d="M12 9.75 14.25 12m0 0 2.25 2.25M14.25 12l2.25-2.25M14.25 12 12 14.25m-2.58 4.92-6.374-6.375a1.125 1.125 0 0 1 0-1.59L9.42 4.83c.21-.211.497-.33.795-.33H19.5a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-9.284c-.298 0-.585-.119-.795-.33Z" />
                                        </svg>
                                    </div>
                                    <div>Return</div>
                                </div>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <div>
                @livewire('components.SupplierManagement.supplier-form')
            </div>
            <div x-cloak x-show="showSupplierTable" x-data="{ showSupplierTable: @entangle('showSupplierTable') }">
                @livewire('components.SupplierManagement.supplier-table')
            </div>
            <div x-cloak x-show="showSupplierItemCosts" x-data="{ showSupplierItemCosts: @entangle('showSupplierItemCosts') }">
                @livewire('components.SupplierManagement.supplier-item-costs-table')
            </div>
        </div>
    </div>
</div>
