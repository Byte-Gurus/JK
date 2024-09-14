<div
    class="fixed top-0 left-0 right-0 z-50 items-center flex justify-center w-full overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <form class="relative z-50 w-1/3 bg-[rgb(238,238,238)] rounded-lg shadow " wire:submit.prevent="adjust">
        @csrf

        <div class="flex items-center justify-between px-6 py-2 border-b rounded-t ">

            <div class="flex justify-center w-full p-2">

                {{-- //* form title --}}
                <h3 class="text-xl font-black text-gray-900 item ">

                    Stock Adjust

                </h3>
            </div>

            {{-- //* close button --}}
            <button type="button" x-on:click="showStockAdjustPage=false" wire:click=' resetFormWhenClosed() '
                class="absolute right-[26px] inline-flex items-center justify-center w-8 h-8 text-sm text-[rgb(53,53,53)] bg-transparent rounded-lg hover:bg-[rgb(52,52,52)] transition duration-100 ease-in-out hover:text-gray-100 ms-auto "
                data-modal-hide="UserModal">

                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>

                <span class="sr-only">Close modal</span>

            </button>

        </div>
        <div class="flex flex-col p-6 space-y-6">

            <div class="flex flex-col gap-4">

                {{-- //* first area, personal information --}}
                <div class="border-2 border-[rgb(53,53,53)] rounded-md">

                    <div
                        class="p-2 border-b bg-[rgb(53,53,53)] text-[rgb(242,242,242)] pointer-events-none rounded-br-sm rounded-bl-sm">
                        <h1 class="font-bold">Stock Adjust Information</h1>
                    </div>

                    <div class="p-4">

                        {{-- //* first row --}}
                        <div class="flex justify-between gap-4">

                            {{-- //* sku --}}
                            <div class="flex flex-row gap-4 mb-3">
                                <div>
                                    <p class=" text-[1.2em] text-gray-900">SKU</p>
                                </div>
                                <div>
                                    <p class=" text-[1.2em] font-black text-gray-900">{{ $sku_code }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- //* second row --}}
                        <div class="flex justify-between gap-4">

                            {{-- //* item name --}}
                            <div class="flex flex-row gap-4 mb-3">
                                <div>
                                    <p class=" text-[1.2em] text-gray-900">Item Name</p>
                                </div>
                                <div>
                                    <p class=" text-[1.2em] font-black text-gray-900">{{ $item_name }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between gap-4">

                            {{-- //* item name --}}
                            <div class="flex flex-row gap-4 mb-3">
                                <div>
                                    <p class=" text-[1.2em] text-gray-900">Item description</p>
                                </div>
                                <div>
                                    <p class=" text-[1.2em] font-black text-gray-900">{{ $description }}</p>
                                </div>
                            </div>
                        </div>
                        {{-- //* third row --}}
                        <div class="flex justify-between gap-4">

                            {{-- //* item quantity --}}
                            <div class="flex flex-row gap-4 mb-3">
                                <div>
                                    <p class=" text-[1.2em] text-gray-900">Current Quantity</p>
                                </div>
                                <div>
                                    <p class=" text-[1.2em] font-black text-gray-900"> {{ $current_quantity }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- //* fourth row --}}
                        <div class="flex justify-between gap-4">

                            {{-- //* operation --}}
                            <div class="flex flex-row gap-4 mb-3">
                                <fieldset class="flex flex-col gap-8">
                                    <legend class=" text-[1.2em] text-gray-900">Select Adjustment Operation
                                    </legend>
                                    <div class="flex flex-row justify-center gap-2">
                                        <label class="flex gap-2 font-black radio">
                                            <input type="radio" wire:model="selectOperation" value="Add" />
                                            Add
                                        </label>
                                        @if ($current_quantity !== 0)
                                            <label class="flex gap-2 font-black radio">
                                                <input type="radio" wire:model="selectOperation" value="Deduct" />
                                                Deduct
                                            </label>
                                        @endif


                                        @error('selectOperation')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        {{-- //* fifth row --}}
                        <div class="flex justify-between gap-4">

                            {{-- //* adjust quantity --}}
                            <div class="flex flex-col gap-1 mb-3">

                                <div>
                                    <label for="adjust_quantity" class="text-[1.2em] text-gray-900">Adjust
                                        Quantity</label>
                                </div>

                                <div>
                                    <input type="number" wire:model="quantityToAdjust" placeholder="Quantity" required
                                        class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5">

                                    @error('quantityToAdjust')
                                        <span class="font-medium text-red-500 error">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        {{-- //* sixth row --}}
                        <div class="flex justify-between gap-4">

                            {{-- //* adjust reason --}}
                            <div class="flex flex-col gap-1 mb-3">

                                <div>
                                    <label for="adjust_quantity" class="text-[1.2em] text-gray-900">Reason</label>
                                </div>

                                <div>
                                    <input type="text" wire:model="adjustReason" placeholder="Reason" required
                                        class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5">
                                </div>

                                @error('adjustReason')
                                    <span class="font-medium text-red-500 error">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-row justify-end gap-2 mt-4">
                <div>
                    <div>

                        {{-- //* clear all button for create --}}
                        <button
                            class="text-[rgb(53,53,53)] hover:bg-[rgb(229,229,229)] font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition ease-in-out duration-100">
                            Cancel</button>
                    </div>
                </div>
                <div>
                    <button
                        class=" px-6 py-2 bg-orange-300 rounded-md text-[rgb(53,53,53)] hover:bg-orange-400 font-bold ease-in-out duration-100 transition-all">Adjust</button>
                </div>
            </div>
            {{-- //* form footer --}}
        </div>
    </form>
</div>
