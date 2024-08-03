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

                        <h1 class="text-[2em] font-bold pointer-events-none">Manage Customer</h1>
                    </div>
                    <div class="flex flex-row gap-4 ">
                        <button
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(158,255,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out"
                            x-on:click="showModal=true;$wire.formCreate()">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </div>
                            <p>Add New Customer</p>
                        </button>
                        <button
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(180,221,255)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(111,166,255)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                                </svg>
                            </div>
                            <p>Start New Transaction</p>
                        </button>
                    </div>
                </div>
            </div>
            <div>
                @livewire('components.CustomerManagement.customer-form')
            </div>
            <div class="my-[28px]">
                @livewire('components.CustomerManagement.customer-table')
            </div>
        </div>
    </div>
</div>
