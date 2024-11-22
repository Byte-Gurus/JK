<div x-cloak>
    <div class="fixed inset-0 z-40 bg-gray-900/50 dark:bg-gray-900/80"></div>
    <div
        class="fixed flex justify-center items-center top-0 left-0 bg-transparent right-0 z-50 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)]">
        <div class="grid items-center justify-center grid-flow-col bg-transparent h-fit w-[460px]">

            <div class="h-full w-full gap-4 p-4 border-black border bg-[rgb(34,34,34)] rounded-lg shadow-md text-nowrap">
                <div class="flex flex-row items-center justify-between gap-4">
                    {{-- //* form title --}}
                    <h3 class="text-xl font-black text-[rgb(255,255,255)] item">
                        Set Date of Delivery
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
                <form class="flex flex-col items-center w-full h-full mt-2 justify-evenly">
                    @csrf

                    <div class="flex justify-center w-full my-4 ">
                        <input type="date" wire:model.live="date" class="w-full p-4 rounded-md hover:bg-gray-300">
                    </div>

                    @error('date')
                        <span class="font-medium text-red-500 error">{{ $message }}</span>
                    @enderror

                    <div class="mb-3">

                        <div class="flex flex-row justify-between w-full mb-2 ">
                            <label for="id_picture" class="block text-sm font-medium text-white">Receipt Picture
                            </label>

                            @if (!empty($receipt_picture))
                                <button type="button" wire:click='removeSelectedPicture()'
                                    class="px-4 text-sm font-medium transition-all duration-100 ease-in-out bg-red-200 rounded-md hover:bg-red-400">Remove
                                    Picture</button>
                            @endif
                        </div>

                        @if (empty($receipt_picture))
                            @if ($this->isCreate)
                                <input id="receipt_picture" type="file" accept="image/png, image/jpeg" required
                                    wire:model="receipt_picture"
                                    class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5">
                            @else
                                <input id="receipt_picture" type="file" accept="image/png, image/jpeg" nullable
                                    wire:model="receipt_picture"
                                    class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5">
                            @endif
                        @endif

                        @if ($receipt_picture instanceof \Illuminate\Http\UploadedFile)
                            <img src="{{ $receipt_picture->temporaryUrl() }}">
                        @elseif($receipt_picture)
                            <img src="{{ $receipt_picture }}" alt="Customer ID Picture" class="w-1/3 h-1/2">
                        @endif

                        @error('receipt_picture')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-center w-full my-4 ">
                        <label for="id_picture" class="block text-sm font-medium text-white">Receipt Number
                        </label>
                        <input type="text" wire:model.live="receipt_number"
                            class="w-full p-4 rounded-md hover:bg-gray-300">

                            @error('receipt_number')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    @error('receipt_number')
                        <span class="font-medium text-red-500 error">{{ $message }}</span>
                    @enderror
                    <div class="flex flex-row self-end gap-2 mb-6">
                        <div>
                            {{-- //* clear all button for create --}}
                            <button type="button" wire:click="resetFormWhenClosed"
                                class="text-[rgb(221,221,221)] hover:bg-[rgb(60,60,60)] font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition ease-in-out duration-100">
                                Cancel</button>
                        </div>
                        <div>
                            @if ($date && $receipt_picture && $receipt_number)
                                <button type="button" wire:click="changeDate()"
                                    class=" px-6 py-2 bg-[rgb(149,241,253)] rounded-md text-[rgb(30,30,30)] hover:bg-[rgb(97,204,219)] font-bold ease-in-out duration-100 transition-all">Set</button>
                            @else
                                <button type="button" wire:click="changeDate" disabled
                                    class=" px-6 py-2 bg-[rgb(75,102,105)] rounded-md text-[rgb(30,30,30)] font-bold">Set</button>
                            @endif

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
