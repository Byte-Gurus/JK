<div class="relative" x-cloak>
    <div class="fixed inset-0 z-40 bg-gray-900/50 dark:bg-gray-900/80"></div>
    <div
        class="fixed top-0 left-0 right-0 z-50 items-center justify-center grid grid-flow-col w-full overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-fit">
        <div class="grid w-full grid-flow-col rounded-l-lg ">
            <div
                class="flex flex-col w-fit gap-4 p-4 border border-black bg-[rgba(53,53,53,0.39)] rounded-l-lg shadow-md shadow-[rgb(149,241,253)] text-nowrap">
                <div class="flex flex-col gap-1 leading-none">
                    <p class="text-[1em] font-thin text-white">Item Barcode</p>
                    <p class="text-[1.2em] font-bold text-white">203984290890432
                    </p>
                </div>
                <div class="flex flex-col gap-1 leading-none">
                    <p class="text-[1em] font-thin text-white">Item Name</p>
                    <p class="text-[1.2em] font-bold text-white">hotdog</p>
                </div>
                <div class="flex flex-col gap-1 leading-none">
                    <p class="text-[1em] font-thin text-white">Item Description</p>
                    <p class="text-[1.2em] font-bold text-white">espaysi</p>
                </div>
                <div class="flex flex-col gap-1 leading-none">
                    <p class="text-[1em] font-thin text-white">Current Stock</p>
                    <p class="text-[1.6em] font-black text-white">40
                    </p>
                </div>
            </div>
        </div>
        <div class="rounded-l-lg ">
            <div class="flex flex-col justify-center w-full p-2  bg-[rgba(53,53,53,0.39)]">

                {{-- //* form title --}}
                <h3 class="text-xl font-black text-gray-900 item ">

                    Change Quantity

                </h3>

                {{-- //* close button --}}
                <button type="button" x-on:click="showChangeQuantityForm=false" wire:click='resetFormWhenClosed'
                    class="flex items-center justify-center w-8 h-8 text-sm text-[rgb(53,53,53)] bg-transparent rounded-lg hover:bg-[rgb(52,52,52)] transition duration-100 ease-in-out hover:text-gray-100"
                    data-modal-hide="UserModal">

                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>

                    <span class="sr-only">Close modal</span>

                </button>
            </div>
            <div>
                <form class="flex flex-col w-1/3 bg-[rgb(238,238,238)] rounded-lg" wire:submit.prevent="adjust">
                    @csrf

                    <div class="flex flex-col items-center justify-center w-full gap-1 mb-3">

                        <div>
                            <p class="text-[1.6em] font-bold text-gray-900">Enter
                                Quantity</p>
                        </div>

                        <div class="flex justify-center">
                            <input autofocus type="text" wire:model='adjust_quantity' required
                                class=" bg-[rgb(245,245,245)] text-center w-1/2 h-1/2 text-2xl border border-[rgb(143,143,143)] text-gray-900 rounded-md block p-4">
                        </div>

                        {{-- @error('adjust_quantity')
                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                        @enderror --}}

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

