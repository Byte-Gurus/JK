<div>
    @livewire('components.navbar')
    <div x-data="{ showModal: @entangle('showModal') }">
        <div class=" ml-[250px] py-[28px] mr-8">
        <div class="flex flex-col justify-between">
                <div class="flex flex-row items-center justify-between">
                    <div>
                        <h1 class="text-[2em] font-bold pointer-events-none">Manage Supplier</h1>
                    </div>
                    <div class="flex flex-row gap-2">
                        <button
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(158,255,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out"
                            x-on:click="showModal=true;$wire.formCreate()">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </div>
                            <div>
                                <p>New Supplier</p>
                            </div>
                        </button>
                    </div>
                </div>

            </div>
            @livewire('components.SupplierManagement.supplier-form')
        </div>
        @livewire('components.SupplierManagement.supplier-table')
    </div>
</div>
