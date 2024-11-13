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
                                class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,235,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,225,128)] transition-all duration-100 ease-in-out"
                                x-on:click="$wire.viewSupplierItemCosts()">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                      </svg>

                                </div>
                                <div>
                                    <p>Supplier Item Costs</p>
                                </div>
                            </button>
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
