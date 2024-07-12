<div class="relative" x-cloak x-show="showPrintModal">
    <div class="fixed inset-0 z-40 bg-gray-900/50 dark:bg-gray-900/80"></div>
    <div
        class="fixed top-0 left-0 right-0 z-50 items-center flex justify-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">

        <div class="w-1/3 bg-red-200 h-1/3">
            <form class="relative bg-[rgb(238,238,238)] rounded-lg shadow " wire:submit.prevent="create">
                @csrf

                <div class="flex items-center justify-between px-6 py-2 border-b rounded-t ">

                    <div class="flex justify-center w-full p-2">

                        {{-- //* form title --}}
                        <h3 class="text-xl font-black text-gray-900 item ">

                            Print Barcode

                        </h3>
                    </div>

                    {{-- //* close button --}}
                    <button type="button" x-on:click="showPrintModal=false"
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


                <div class="p-6 space-y-6">

                    <div class="flex flex-col gap-4">

                        {{-- //* first area, personal information --}}
                        <div class="border-2 border-[rgb(53,53,53)] rounded-md">

                            <div
                                class="p-2 border-b bg-[rgb(53,53,53)] text-[rgb(242,242,242)] pointer-events-none rounded-br-sm rounded-bl-sm">
                                <h1 class="font-bold">Print Information</h1>
                            </div>

                            <div class="p-4">

                                {{-- //* first row --}}
                                <div class="flex justify-between gap-4">

                                    {{-- //* Item name --}}
                                    <div class="mb-3">

                                        <label for="item_name"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">No. of copy<span
                                                class="text-red-400 ">*</span></label>

                                        <input type="text" id="item_name" wire:model="item_name"
                                            class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                            placeholder="Quantity" />

                                        @error('item_name')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>


                                    @if ($barcode)
                                        <div class="mb-3">

                                            <label for="asas"
                                                class="block mb-2 text-sm font-medium text-gray-900 ">Barcode:
                                                {{ $barcode }}
                                            </label>

                                            <img id="barcode" wire:model="barcode">{!! DNS1D::getBarcodeSVG($barcode, 'C128', 2, 60) !!}</img>


                                            @error('barcode')
                                                <span class="font-medium text-red-500 error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif

                                </div>
                                <div class="mt-4">
                                    <button class="w-full px-2 py-2 bg-orange-300 rounded-md text-[rgb(53,53,53)] hover:bg-orange-400 font-bold ease-in-out duration-100 transition-all">Print</button>
                                </div>


                            </div>
                        </div>


                    </div>

                    {{-- //* form footer --}}



                </div>

            </form>
        </div>
    </div>
</div>

{{-- //* form position --}}
