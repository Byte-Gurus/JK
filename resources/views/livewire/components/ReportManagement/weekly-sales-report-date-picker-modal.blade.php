<div x-cloak >
    <div class="fixed inset-0 z-40 bg-gray-900/50 dark:bg-gray-900/80"></div>
    <div
        class="fixed flex justify-center items-center top-0 left-0 bg-transparent right-0 z-50 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)]">
        <div class="grid items-center justify-center grid-flow-col bg-transparent h-fit w-[460px]">

            <div
                class="h-full w-full gap-4 p-4 border-black border bg-[rgb(34,34,34)] rounded-r-lg shadow-md text-nowrap">
                <div class="flex flex-row items-center justify-between">
                    {{-- //* form title --}}
                    <h3 class="text-xl font-black text-[rgb(255,255,255)] item">
                        Set Week
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
                <form
                    class="flex flex-col items-center w-full h-full mt-2 justify-evenly">
                    @csrf

                    <div class="flex justify-center w-full my-4 ">
                        <input type="week" wire:model="date" class="w-full p-4 rounded-md hover:bg-gray-300">
                    </div>
                    <div class="flex flex-row self-end gap-2 mb-6">
                        <div>
                            {{-- //* clear all button for create --}}
                            <button
                            type="button" wire:click="resetFormWhenClosed"
                                class="text-[rgb(221,221,221)] hover:bg-[rgb(60,60,60)] font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition ease-in-out duration-100">
                                Cancel</button>
                        </div>
                        <div>
                            <button type="button"  wire:click="getDate" x-on:click='$wire.displayWeeklySalesReport()'
                                class=" px-6 py-2 bg-[rgb(149,241,253)] rounded-md text-[rgb(30,30,30)] hover:bg-[rgb(97,204,219)] font-bold ease-in-out duration-100 transition-all">Generate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
