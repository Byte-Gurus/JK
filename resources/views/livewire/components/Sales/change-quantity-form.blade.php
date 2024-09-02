<div class="relative" x-cloak x-show="showChangeQuantityForm">
    <div class="fixed inset-0 z-40 bg-gray-900/50 dark:bg-gray-900/80"></div>
    <div
        class="fixed top-0 left-0 right-0 z-50 items-center flex justify-center w-full overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <form class="relative z-50 w-1/3 bg-[rgb(238,238,238)] rounded-lg shadow " wire:submit.prevent="adjust">
            @csrf

            <div class="flex items-center justify-between px-6 py-2 border-b rounded-t ">

                <div class="flex justify-center w-full p-2">

                    {{-- //* form title --}}
                    <h3 class="text-xl font-black text-gray-900 item ">

                        Change Quantity

                    </h3>
                </div>

                {{-- //* close button --}}
                <button type="button" x-on:click="showChangeQuantityForm=false" wire:click='resetFormWhenClosed'
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
                            <h1 class="font-bold">Change Item Quantity</h1>
                        </div>

                        <div class="p-4">


                            {{-- //* first row --}}
                            <div class="flex flex-row items-center justify-between">

                                {{-- //* adjust reason --}}
                                <div class="flex flex-col items-center justify-center w-full gap-1 mb-3">

                                    <div>
                                        <p class="text-[1.6em] font-bold text-gray-900">Enter
                                            Quantity</p>
                                    </div>

                                    <div class="flex justify-center">
                                        <input autofocus type="text" wire:model='adjust_quantity' required
                                            class=" bg-[rgb(245,245,245)] text-center w-1/2 h-1/2 text-2xl border border-[rgb(143,143,143)] text-gray-900 rounded-md block p-4">
                                    </div>

                                    @error('adjust_quantity')
                                        <span class="font-medium text-red-500 error">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="flex flex-col w-full gap-2 p-4 m-2 border border-black rounded-lg shadow-md shadow-[rgb(149,241,253)] text-nowrap">
                                    <div class="flex flex-col gap-1 leading-none">
                                        <p class="text-[1em] font-thin text-gray-900">Item Barcode</p>
                                        <p class="text-[1.2em] font-bold text-gray-900">{{ $barcode }}
                                        </p>
                                    </div>
                                    <div class="flex flex-row justify-between w-full ">
                                        <div class="flex flex-col gap-1 leading-none">
                                            <p class="text-[1em] font-thin text-gray-900">Item Name</p>
                                            <p class="text-[1.2em] font-bold text-gray-900">{{ $item_name }}</p>
                                        </div>
                                        <div class="flex flex-col gap-1 leading-none">
                                            <p class="text-[1em] font-thin text-gray-900">Item Description</p>
                                            <p class="text-[1.2em] font-bold text-gray-900">{{ $item_description }}</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1 leading-none">
                                        <p class="text-[1em] font-thin text-gray-900">Current Stock</p>
                                        <p class="text-[1.6em] font-black text-gray-900">{{ $current_stock_quantity }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row justify-end gap-2 mt-4">
                    <div>
                        <div>

                            {{-- //* clear all button for create --}}
                            <button wire:click='resetFormWhenClosed'
                                class="text-[rgb(53,53,53)] hover:bg-[rgb(229,229,229)] font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition ease-in-out duration-100">
                                Cancel</button>
                        </div>
                    </div>
                    <div>
                        <button type="submit"
                            class=" px-6 py-2 bg-orange-300 rounded-md text-[rgb(53,53,53)] hover:bg-orange-400 font-bold ease-in-out duration-100 transition-all">Apply</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>