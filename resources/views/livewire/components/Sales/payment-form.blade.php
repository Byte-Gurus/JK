<div class="relative" x-cloak x-show="showPaymentForm" x-data="{ payWithCash: @entangle('payWithCash') }">
    <div class="fixed inset-0 z-40 bg-gray-900/50 dark:bg-gray-900/80"></div>
    <div
        class="fixed top-0 left-0 right-0 z-50 items-center flex justify-center w-full overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <form class="relative z-50 w-1/3 bg-[rgb(238,238,238)] rounded-lg shadow " wire:submit.prevent="pay">
            @csrf

            <div class="flex items-center justify-between px-6 py-2 border-b rounded-t ">

                <div class="flex justify-center w-full p-2">

                    {{-- //* form title --}}
                    <h3 class="text-xl font-black text-gray-900 item ">

                        Payment

                    </h3>
                </div>

                {{-- //* close button --}}
                <button type="button" x-on:click="showPaymentForm=false" wire:click='resetFormWhenClosed'
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
                            class="p-2 pr-6 border-b flex flex-row justify-between bg-[rgb(53,53,53)] text-[rgb(242,242,242)] pointer-events-none rounded-br-sm rounded-bl-sm">
                            <div>
                                <h1 class="font-bold">Payment Information</h1>
                            </div>
                            <div class="italic font-thin text-white">
                                @if ($payWithCash)
                                    Payment Method: <strong>Cash</strong>
                                @else
                                    Payment Method: <strong>GCash</strong>
                                @endif
                            </div>
                        </div>

                        <div class="p-4">

                            <div class="flex flex-row items-center gap-2">
                                {{-- //* first row --}}
                                <div class="flex justify-between w-full gap-4">

                                    {{-- //* adjust reason --}}
                                    <div class="flex flex-col items-center h-full gap-1 mb-3">
                                        <div class="flex flex-col">
                                            <div>
                                                <label for="amount" class="text-[1.2em] text-gray-900">Enter
                                                    Amount</label>
                                            </div>

                                            <div>
                                                <input type="number" wire:model='tendered_amount' placeholder="Amount" required
                                                    class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-xl font-black  rounded-lg  block w-full p-2.5">

                                                @error('tendered_amount')
                                                    <span class="font-medium text-red-500 error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        @if (!$payWithCash)
                                            <div class="flex flex-col transition-all duration-100 ease-in-out">
                                                <div>
                                                    <label for="reference_no"
                                                        class="text-[1.2em] text-gray-900">Reference
                                                        No.</label>
                                                </div>

                                                <div>
                                                    <input type="number" wire:model='reference_no'
                                                        placeholder="Reference No" required
                                                        class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-xl font-black  rounded-lg  block w-full p-2.5">

                                                    @error('reference_no')
                                                        <span
                                                            class="font-medium text-red-500 error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif


                                    </div>
                                </div>
                                <div
                                    class="flex flex-col gap-4 w-full shadow-md shadow-[rgb(244,255,147)] items-center justify-center p-4 m-2 leading-none border border-black rounded-lg bg-[rgb(255,255,255)]">
                                    <div>
                                        <p class="text-[1.6em] font-thin text-center">To Pay</p>
                                    </div>
                                    <div>
                                        <p class="text-[2em] font-black">{{ number_format($grand_total, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-between">
                    @if ($payWithCash)
                        <div>
                            {{-- //* clear all button for create --}}
                            <div x-on:click="$wire.changePaymentMethod()"
                                class="text-[rgb(228,228,228)] bg-[rgb(79,79,79)] cursor-pointer hover:bg-[rgb(21,21,21)] font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition ease-in-out duration-100">
                                Pay with GCash</div>
                        </div>
                    @else
                        <div>
                            {{-- //* clear all button for create --}}
                            <div x-on:click="$wire.changePaymentMethod()"
                                class="text-[rgb(228,228,228)] bg-[rgb(79,79,79)] cursor-pointer hover:bg-[rgb(21,21,21)] font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition ease-in-out duration-100">
                                Pay with Cash</div>
                        </div>
                    @endif
                    <div class="flex flex-row justify-end gap-2 mt-4">
                        <div>
                            {{-- //* clear all button for create --}}
                            <button wire:click='resetFormWhenClosed'
                                class="text-[rgb(53,53,53)] hover:bg-[rgb(229,229,229)] font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition ease-in-out duration-100">
                                Cancel</button>
                        </div>
                        <div>
                            <button type="submit" x-on:keydown.window.prevent.ctrl.enter="$wire.call('pay')"
                                class=" px-6 py-2 bg-orange-300 rounded-md text-[rgb(53,53,53)] hover:bg-orange-400 font-bold ease-in-out duration-100 transition-all">Pay</button>
                        </div>
                    </div>
                </div>
                {{-- //* form footer --}}
            </div>
        </form>
    </div>
</div>
