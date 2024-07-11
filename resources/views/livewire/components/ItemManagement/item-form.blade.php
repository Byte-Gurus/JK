{{-- //var from livewire variable passed to blade file with entanglement --}}
<div x-cloak x-show="showModal" x-data="{ isCreate: @entangle('isCreate') }">

    {{-- //* form background --}}
    <div class="fixed inset-0 z-40 bg-gray-900/50 dark:bg-gray-900/80"></div>

    {{-- //* form position --}}
    <div
        class="fixed top-0 left-0 right-0 z-50 items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">

        <div class="relative w-full max-w-2xl max-h-full mx-auto">

            {{-- //* Modal content --}}
            @if (!$this->isCreate)
                {{-- *if form is edit --}}
                <form class="relative bg-[rgb(238,238,238)] rounded-lg shadow " wire:submit.prevent="update">
            @endif

            {{-- *if form is create --}}
            <form class="relative bg-[rgb(238,238,238)] rounded-lg shadow " wire:submit.prevent="create">
                @csrf

                <div class="flex items-center justify-between px-6 py-2 border-b rounded-t ">

                    <div class="flex justify-center w-full p-2">

                        {{-- //* form title --}}
                        <h3 class="text-xl font-black text-gray-900 item ">

                            @if (!$this->isCreate)
                                {{-- *if form is edit --}}
                                Edit User
                            @else
                                Create User
                            @endif

                        </h3>
                    </div>

                    {{-- //* close button --}}
                    <button type="button" x-on:click="showModal=false" wire:click=' resetFormWhenClosed() '
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
                                <h1 class="font-bold">Item Information</h1>
                            </div>

                            <div class="p-4">

                                {{-- //* first row --}}
                                <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">

                                    {{-- //* Item name --}}
                                    <div class="mb-3">

                                        <label for="item_name"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Item Name <span
                                                class="text-red-400 ">*</span></label>

                                        <input type="text" id="item_name" wire:model="item_name"
                                            class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                            placeholder="Item Name" />

                                        @error('item_name')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    
                                    {{-- //* barcode --}}
                                    @if ($barcode)
                                        <div class="mb-3">

                                            <label for="barcode"
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

                                {{-- //* second row --}}
                                <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">

                                    {{-- //* maximum stock ratio --}}
                                    <div class="mb-3">

                                        <label for="maximum_stock_ratio"
                                            class="block mb-2 text-sm font-medium text-gray-900 "> Maximum stock ratio
                                        </label>

                                        <input type="text" id="maximum_stock_ratio" wire:model="maximum_stock_ratio"
                                            class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                            placeholder="Maximum stock ratio" required />

                                        @error('maximum_stock_ratio')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    {{-- //* reorder point --}}
                                    <div class="mb-3">

                                        <label for="reorder_point"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Reorder Point</label>

                                        <input type="number" id="reorder_point" wire:model="reorder_point"
                                            class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                            placeholder="Reorder Point" required />

                                        @error('reorder_point')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>

                                </div>

                                {{-- //* third row --}}
                                <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">

                                    {{-- //* vat type --}}
                                    <div class="mb-3">

                                        <label for="vat_type" class="block mb-2 text-sm font-medium text-gray-900 ">Vat
                                            Type</label>

                                        <select id="vat_type" wire:model="vat_type"
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                                            <option value="" selected>Select vat type</option>
                                            <option value="1">Vat</option>
                                            <option value="2">Non vat</option>

                                        </select>

                                        @error('vat_type')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    {{-- //* vat amount --}}
                                    <div class="mb-3">

                                        <label for="vat_amount"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Vat Amount</label>

                                        <input type="text" id="vat_amount" wire:model="vat_amount"
                                            class=" bg-[rgb(245,245,245)] text-gray-900 text-sm rounded-lg  block w-full p-2.5"
                                            placeholder="Vat Amount" required />

                                        @error('vat_amount')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>


                                </div>

                                <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">
                                    {{-- //* status --}}
                                    <div class="mb-3">

                                        <label for="status"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Status</label>

                                        <select id="status" wire:model="status"
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                                            <option value="" selected>Set your status</option>
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
                                        </select>

                                        @error('status')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    {{-- //* form footer --}}

                    {{-- *if form is edit --}}
                    @if (!$this->isCreate)
                        <div class="flex flex-row justify-end gap-2">

                            <div>

                                {{-- //* submit button for edit --}}
                                <button type="submit"
                                    class="text-white bg-[rgb(55,55,55)] focus:ring-4 hover:bg-[rgb(28,28,28)] focus:outline-none  font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                                    <div class="flex flex-row items-center gap-2">
                                        <p>Update</p>

                                        <div wire:loading>

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5 gap-2 text-white animate-spin" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M12 2a10 10 0 00-4.472 18.965 1 1 0 01.258-1.976 8 8 0 115.429 0 1 1 0 01.258 1.976A10 10 0 0012 2z">
                                                </path>
                                            </svg>

                                        </div>
                                    </div>

                                </button>

                            </div>

                        </div>
                    @else
                        {{-- *if form is create --}}
                        <div class="flex flex-row justify-end gap-2">
                            <div>

                                {{-- //* clear all button for create --}}
                                <button type="reset"
                                    class="text-[rgb(53,53,53)] hover:bg-[rgb(229,229,229)] font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition ease-in-out duration-100">Clear
                                    All</button>
                            </div>

                            <div>

                                {{-- //* submit button for create --}}
                                <button type="submit"
                                    class="text-white bg-[rgb(55,55,55)] focus:ring-4 hover:bg-[rgb(28,28,28)] focus:outline-none  font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                                    <div class="flex flex-row items-center gap-2">
                                        <p>
                                            Create
                                        </p>

                                        <div wire:loading>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5 text-white animate-spin" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M12 2a10 10 0 00-4.472 18.965 1 1 0 01.258-1.976 8 8 0 115.429 0 1 1 0 01.258 1.976A10 10 0 0012 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>


                                </button>

                            </div>

                        </div>
                    @endif

                </div>

            </form>
        </div>

    </div>
</div>

<script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>

<x-livewire-alert::flash />
