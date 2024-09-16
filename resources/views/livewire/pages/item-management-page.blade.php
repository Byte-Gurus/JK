<div x-data="{ sidebar: @entangle('sidebarStatus') }"
    @if (!$this->sidebarStatus) class=" ml-[220px] transition-all ease-in-out duration-75"
    @else
        class=" ml-[0px] transition-all ease-in-out duration-100" @endif>
    @livewire('components.navbar')
    <div x-data="{ showModal: @entangle('showModal'), showPrintModal: @entangle('showPrintModal'), isPrint: @entangle('isPrint')}">
        <div class="m-[28px]">
            <div class="flex flex-col justify-between">
                <div class="flex flex-row items-center justify-between">
                    <div>
                        <h1 class="text-[2em] font-bold pointer-events-none">Manage Item</h1>
                    </div>
                    <div>
                        <button
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(158,255,128)] transition-all duration-100 ease-in-out"
                            x-on:click="showModal=true;$wire.formCreate()">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </div>
                            <div>
                                <p >Add New Item</p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            <div>
                @livewire('components.ItemManagement.item-form')
            </div>
            <div class="my-[28px]">
                @livewire('components.ItemManagement.item-table')
            </div>
            <div>
                @livewire('components.ItemManagement.print-barcode-form')
            </div>
            <div>
                @livewire('components.ItemManagement.print-barcode')
            </div>
        </div>
    </div>
</div>
