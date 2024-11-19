<div class="relative" x-cloak>
    <div
        class="fixed flex justify-center items-center top-0 left-0 bg-transparent right-0 z-50 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)]">
        <div class="grid items-center justify-center grid-flow-col bg-transparent h-fit w-[660px]">
            <div
                class="flex backdrop-blur-xl flex-col h-full w-full justify-evenly gap-4 p-4 border border-black bg-[rgba(53,53,53,0.39)] rounded-l-lg shadow-md shadow-[rgb(149,241,253)] text-nowrap">
                <div class="flex flex-col gap-1 leading-none">
                    <p class="text-[1em] font-thin text-white">SKU</p>
                    {{-- <p class="text-[1.2em] font-bold text-white">{{ $sku_code }}</p> --}}sdsd
                </div>
                <div class="flex flex-col gap-1 leading-none">
                    <p class="text-[1em] font-thin text-white">Item Name</p>
                    {{-- <p class="text-[1.2em] font-bold text-white">{{ $item_name }}</p> --}}dsds
                </div>
                <div class="flex flex-col gap-1 leading-none">
                    <p class="text-[1em] font-thin text-white">Item Description</p>
                    <p class="text-[1.2em] font-bold text-white">
                        {{-- {{ $description }} --}}sdsdsds
                    </p>
                </div>
                <div class="flex flex-col gap-1 leading-none">
                    <p class="text-[1em] font-thin text-white">Current Quantity</p>
                    <p class="text-[1.6em] font-black text-white">
                        {{-- {{ $current_quantity }} --}}dsdsdsds
                    </p>
                </div>
            </div>
            <div
                class="h-full w-full gap-4 p-4 border-black border bg-[rgb(34,34,34)] rounded-r-lg shadow-md text-nowrap">
                <div class="flex flex-row items-center justify-between">
                    {{-- //* form title --}}
                    <h3 class="text-xl font-black text-[rgb(255,255,255)] item">
                        Stock Adjust
                    </h3>

                    {{-- //* close button --}}
                    <button type="button" x-on:click="showStockAdjustPage=false" wire:click="resetFormWhenClosed"
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
                <form wire:submit.prevent="adjust"
                    class="flex flex-col items-center w-full h-full pr-6 mt-2 justify-evenly">
                    @csrf

                    <div class="flex flex-col justify-start w-fit">
                        <div class="flex flex-row gap-4 mb-4">
                            <fieldset class="flex flex-col gap-8">
                                <legend class="text-[1.2em] text-white">
                                    Select Adjustment Operation
                                </legend>
                                <div class="flex flex-row gap-2 justify-evenly">
                                    <label class="flex gap-2 font-black text-white radio">
                                        <input type="radio" wire:model="selectOperation" value="Add" />
                                        Add
                                    </label>
                                    {{-- @if ($current_quantity !== 0)
                                        <label class="flex gap-2 font-black text-white radio">
                                            <input type="radio" wire:model="selectOperation" value="Deduct" />
                                            Deduct
                                        </label>
                                    @endif --}}
                                    @error('selectOperation')
                                        <span class="font-medium text-red-500 error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </fieldset>
                        </div>
                        {{-- //* adjust quantity --}}
                        <div class="flex flex-col gap-1 mb-3">

                            <div>
                                <label for="adjust_quantity" class="text-[1em] font-bold text-white">Adjust
                                    Quantity</label>
                            </div>

                            <div>
                                <input type="number" wire:model="quantityToAdjust" placeholder="Quantity" required
                                    class=" bg-[#ffffff3d] w-full text-center font-medium text-xl border border-[rgb(143,143,143)] text-white rounded-md block p-2">

                                @error('quantityToAdjust')
                                    <span class="my-4 font-medium text-red-500 text-wrap error">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        {{-- //* adjust reason --}}
                        <div class="flex flex-col gap-1 mb-3">

                            <div>
                                <label for="adjust_quantity" class="text-[1em] font-bold text-white">Reason</label>
                            </div>

                            <div class="flex flex-row ">
                                <input type="text" wire:model="adjustReason" placeholder="Reason" required
                                    class=" bg-[#ffffff3d] w-full text-center font-medium text-xl border border-[rgb(143,143,143)] text-white rounded-l-md block p-2">

                                <select id="description"
                                    class=" bg-[#ffffff3d] border border-[rgb(143,143,143)] text-ellipsis w-[160px] text-sm text-center text-white rounded-r-md block p-2.5 ">
                                    <option value="" selected>Description</option>
                                    <option value="Damaged">Damaged</option>
                                    <option value="Expired">Expired</option>
                                </select>
                            </div>

                            @error('adjustReason')
                                <span class="my-4 font-medium text-red-500 text-wrap error">{{ $message }}</span>
                            @enderror

                        </div>
                    </div>
                    <div class="flex flex-row self-end gap-2 mb-6">
                        <div>
                            {{-- //* clear all button for create --}}
                            <button type="button" wire:click='resetFormWhenClosed'
                                class="text-[rgb(221,221,221)] hover:bg-[rgb(60,60,60)] font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition ease-in-out duration-100">
                                Cancel</button>
                        </div>
                        <div>
                            <button type="submit"
                                class=" px-6 py-2 bg-[rgb(149,241,253)] rounded-md text-[rgb(30,30,30)] hover:bg-[rgb(97,204,219)] font-bold ease-in-out duration-100 transition-all">Adjust</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
@script
    <script>
        Livewire.on("adjust_quantity_focus", () => {
            document.getElementById("adjust_quantity").focus();
        });
    </script>
@endscript
