<div class="relative" x-cloak>
    <div class="fixed inset-0 z-40 bg-gray-900/50 dark:bg-gray-900/80"></div>
    <div x-show="showInventoryForm" x-data="{ showInventoryForm: @entangle('showInventoryForm') }"
        class="fixed flex justify-center items-center top-0 left-0 bg-transparent right-0 z-50 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)]">
        <div class="grid items-center justify-center grid-flow-col bg-transparent h-fit w-[460px]">
            <div
                class="flex backdrop-blur-xl flex-col h-full w-full justify-evenly gap-4 p-4 border border-black bg-[rgba(53,53,53,0.39)] rounded-l-lg shadow-md shadow-[rgb(149,241,253)] text-nowrap">
                <div class="flex flex-col gap-1 leading-none">
                    <p class="text-[1em] font-thin text-white">Barcode</p>
                    <p class="text-[1.2em] font-bold text-white">{{ $barcode }}</p>
                </div>
                <div class="flex flex-col gap-1 leading-none">
                    <p class="text-[1em] font-thin text-white">SKU</p>
                    <p class="text-[1.2em] font-bold text-white">{{ $sku_code }}</p>
                </div>
                <div class="flex flex-col gap-1 leading-none">
                    <p class="text-[1em] font-thin text-white">Item Name</p>
                    <p class="text-[1.2em] font-bold text-white">{{ $item_name }}</p>
                </div>
                <div class="flex flex-col gap-1 leading-none">
                    <p class="text-[1em] font-thin text-white">Item Description</p>
                    <p class="text-[1.2em] font-bold text-white">
                        {{ $item_description }}
                    </p>
                </div>
            </div>
            <div
                class="h-full w-full gap-4 p-4 border-black border bg-[rgb(34,34,34)] rounded-r-lg shadow-md text-nowrap">
                <div class="flex flex-row items-center justify-between gap-4">
                    {{-- //* form title --}}
                    <h3 class="text-xl font-black text-[rgb(255,255,255)] item">
                        Update Stock Information
                    </h3>

                    {{-- //* close button --}}
                    <button type="button" wire:click="resetFormWhenClosed"
                        class="w-8 h-8 text-sm text-[rgb(255,120,120)] flex justify-center items-center bg-transparent rounded-lg hover:bg-[rgb(231,231,231)] transition duration-100 ease-in-out hover:text-[rgb(0,0,0)] ms-auto"
                        data-modal-hide="UserModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>

                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                {{-- //* first row --}} {{-- //* adjust reason --}}
                <form wire:submit.prevent="update"
                    class="flex flex-col items-center w-full h-full pr-6 mt-2 justify-evenly">
                    @csrf

                    <div class="flex flex-col justify-start w-fit">
                        <div class="flex flex-col gap-1 mb-3">
                            <label for="itemPrice" class="text-white">Item Cost</label>

                            <input type="number" step="0.01"  wire:model.live="cost" oninput="this.value = this.value.replace(/[^\d.]/g, '')"
                                class=" bg-[#ffffff3d] w-full text-center font-medium text-xl border border-[rgb(143,143,143)] text-white rounded-md block p-2">
                        </div>

                    </div>
                    <div class="flex flex-col justify-start w-fit">
                        <div class="flex flex-col gap-1 mb-3">
                            <label for="itemPrice" class="text-white">Markup %</label>

                            <input type="number" step="0.01" wire:model.live="markup" oninput="this.value = this.value.replace(/[^\d.]/g, '')"
                                class=" bg-[#ffffff3d] w-full text-center font-medium text-xl border border-[rgb(143,143,143)] text-white rounded-md block p-2">
                        </div>

                    </div>

                    <div class="flex flex-col justify-start w-fit">
                        <div class="flex flex-col gap-1 mb-3">
                            <label for="itemPrice" class="text-white">Selling Price</label>

                            <input type="number" step="0.01" wire:model.live="seling_price"
                                class=" bg-[#ffffff3d] w-full text-center font-medium text-xl border border-[rgb(143,143,143)] text-white rounded-md block p-2">
                        </div>

                    </div>
                    <div class="flex flex-row self-end gap-2 mb-6">
                        <div>
                            {{-- //* clear all button for create --}}
                            <button type="button" wire:click="resetFormWhenClosed()"
                                class="text-[rgb(221,221,221)] hover:bg-[rgb(60,60,60)] font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition ease-in-out duration-100">
                                Cancel</button>
                        </div>
                        <div>
                            <button
                                class=" px-6 py-2 bg-[rgb(149,241,253)] rounded-md text-[rgb(30,30,30)] hover:bg-[rgb(97,204,219)] font-bold ease-in-out duration-100 transition-all">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div x-cloak x-show="showInventoryAdminLoginForm" x-data="{ showInventoryAdminLoginForm: @entangle('showInventoryAdminLoginForm') }">
        @livewire('components.InventoryManagement.inventory-admin-login-form')
    </div>
</div>
@script
    <script>
        Livewire.on("adjust_quantity_focus", () => {
            document.getElementById("adjust_quantity").focus();
        });
    </script>
@endscript
