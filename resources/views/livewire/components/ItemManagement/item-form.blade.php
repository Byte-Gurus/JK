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
                                Edit Item
                                @else
                                Create Item
                                @endif

                            </h3>
                        </div>

                        {{-- //* close button --}}
                        <button type="button" x-on:click="showModal=false" wire:click=' resetFormWhenClosed() '
                            class="absolute right-[26px] inline-flex items-center justify-center w-8 h-8 text-sm text-[rgb(53,53,53)] bg-transparent rounded-lg hover:bg-[rgb(52,52,52)] transition duration-100 ease-in-out hover:text-gray-100 ms-auto "
                            data-modal-hide="UserModal">

                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>

                            <span class="sr-only">Close modal</span>

                        </button>

                    </div>


                    <div class="p-6 space-y-6">

                        <div class="flex flex-col gap-4">

                            {{-- //* first area, personal information --}}
                            <div class="border-2 border-[rgb(53,53,53)] rounded-sm">

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
                                                class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md  block w-full p-2.5"
                                                placeholder="Item Name" />

                                            @error('item_name')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                            @enderror

                                        </div>

                                        {{-- //* Item Barcode --}}
                                        <div class="mb-3">
                                            <div class="flex flex-row justify-between">
                                                <div>
                                                    <label for="has_barcode"
                                                        class="block mb-2 text-sm font-medium text-gray-900 ">Barcode
                                                        <span class="text-red-400 ">*</span></label>
                                                </div>
                                            </div>
                                            <div class="transition-all duration-100 ease-in-out">
                                                @if ($this->hasBarcode)
                                                <div class="grid grid-flow-col gap-1 grid-col-5">
                                                    {{-- //* already have barcode --}}
                                                    <input type="text" id="create_barcode" wire:model="create_barcode"
                                                        class=" bg-[rgb(245,245,245)] col-span-4 border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5"
                                                        placeholder="Barcode" />



                                                    <div class="col-span-1 ">
                                                        <button type="button" wire:click="changeBarcodeForm()"
                                                            class="px-2 text-sm h-full w-full flex items-center justify-center font-medium rounded-lg bg-[rgb(36,36,36)] text-white hover:bg-[rgb(86,86,86)] duration-100 ease-in-out transition-all">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="size-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                @error('create_barcode')
                                                <span class="font-medium text-red-500 error">{{ $message }}</span>
                                                @enderror
                                                @else
                                                {{-- //* generate barcode --}}
                                                @if ($barcode)

                                                @php
                                                if ($barcode && strlen($barcode) == 13) {
                                                $barcodeNum = substr($barcode, 0, -1);
                                                }
                                                @endphp
                                                <div class="grid items-center grid-flow-col gap-1 grid-col-5">

                                                    <div class="flex justify-center w-full ">
                                                        <img id="barcode" wire:model="barcode">{!!
                                                        DNS1D::getBarcodeSVG($barcodeNum, 'EAN13', 2, 60) !!}</img>
                                                    </div>

                                                    <button type="button" wire:click="changeBarcodeForm()"
                                                        class="text-sm h-3/4 w-3/4 flex items-center justify-center font-medium rounded-lg bg-[rgb(36,36,36)] text-white hover:bg-[rgb(86,86,86)] duration-100 ease-in-out transition-all">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M5 12h14" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                @error('barcode')
                                                <span class="font-medium text-red-500 error">{{ $message }}</span>
                                                @enderror
                                                @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- //* second row --}}
                                    <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">

                                        {{-- //* Item Description --}}
                                        <div class="mb-3">

                                            <label for="item_description"
                                                class="block mb-2 text-sm font-medium text-gray-900 ">Item Description
                                                <span class="text-red-400 ">*</span></label>

                                            <input type="text" id="item_description" wire:model="item_description"
                                                class=" bg-[rgb(245,245,245)] text-gray-900 border border-[rgb(143,143,143)] text-sm rounded-md block w-full p-2.5"
                                                placeholder="Item Description" />

                                            @error('item_description')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                            @enderror

                                        </div>

                                        <div class="mb-3">

                                            <label for="shelf_life_type"
                                                class="block mb-2 text-sm font-medium text-gray-900 ">Shelf life
                                                type</label>

                                            <select id="shelf_life_type" wire:model="shelf_life_type"
                                                class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5 ">
                                                <option value="" selected>Set item shelf life</option>
                                                <option value="Perishable">Perishable</option>
                                                <option value="Non Perishable">Non Perishable</option>
                                            </select>

                                            @error('shelf_life_type')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                            @enderror

                                        </div>

                                    </div>


                                    {{-- //* third row row --}}
                                    <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">

                                        {{-- //* vat type --}}
                                        <div class="col-span-1 mb-3">

                                            <label for="vatType"
                                                class="block mb-2 text-sm font-medium text-gray-900 ">Vat
                                                Type</label>

                                            <select id="vatType" wire:model.live="vatType"
                                                class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5 ">
                                                <option value="" selected>Set vat</option>
                                                <option value="Vat">Vat</option>
                                                <option value="Vat Exempt">Vat Exempt</option>
                                                @error('vat_type')
                                                <span class="font-medium text-red-500 error">{{ $message }}</span>
                                                @enderror
                                            </select>
                                        </div>

                                        {{-- //* vat amount --}}
                                        <div class="col-span-1 mb-3 pointer-events-none">

                                            <label for="vat_percent"
                                                class="block mb-2 text-sm font-medium text-gray-900 ">Vat
                                                Percent</label>

                                            <input type="numeric" id="vat_percent" wire:model="vat_percent" readonly
                                                class=" bg-[rgb(245,245,245)] text-gray-900 border border-[rgb(143,143,143)] text-sm rounded-md block w-full p-2.5"
                                                placeholder="Vat Amount" required />

                                            @error('vat_percent')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>

                                    {{-- //* third row --}}

                                    <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">

                                        {{-- //* reorder point --}}
                                        <div class="mb-3">

                                            <label for="bulk_quantity"
                                                class="block mb-2 text-sm font-medium text-gray-900 ">Wholesale
                                                Quantity</label>

                                            <input type="number" id="bulk_quantity" wire:model="bulk_quantity"
                                                class=" bg-[rgb(245,245,245)] text-gray-900 border border-[rgb(143,143,143)] text-sm rounded-md block w-full p-2.5"
                                                placeholder="Wholesale Quantity" required />

                                            @error('bulk_quantity')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- //* status --}}

                                        @if (!$isCreate)
                                        <div class="mb-3">

                                            <label for="status"
                                                class="block mb-2 text-sm font-medium text-gray-900 ">Status</label>

                                            <select id="status" wire:model="status" disabled
                                                class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5 ">
                                                <option value="" selected>Set your status</option>
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                            </select>

                                            @error('status')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                            @enderror

                                        </div>
                                        @else
                                        <div class="mb-3 pointer-events-none">

                                            <label for="status"
                                                class="block mb-2 text-sm font-medium text-gray-900 ">Status</label>

                                            <input type="text" id="status" readonly value="Inactive"
                                                class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5 ">
                                            </input>
                                        </div>
                                        @endif
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
                                <button type="submit" wire:loading.remove
                                    class="text-white bg-[rgb(55,55,55)] focus:ring-4 hover:bg-[rgb(28,28,28)] focus:outline-none  font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                                    <div class="flex flex-row items-center gap-2">
                                        <p>Update</p>
                                    </div>

                                </button>
                                <div wire:loading>
                                    <div class="flex items-center justify-center loader loader--style3 " title="2">
                                        <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px"
                                            height="40px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;"
                                            xml:space="preserve">
                                            <path fill="#000"
                                                d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
                                                <animateTransform attributeType="xml" attributeName="transform"
                                                    type="rotate" from="0 25 25" to="360 25 25" dur="0.6s"
                                                    repeatCount="indefinite" />
                                            </path>
                                        </svg>
                                    </div>

                                </div>
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
                                <button type="submit" wire:loading.remove
                                    class="text-white bg-[rgb(55,55,55)] focus:ring-4 hover:bg-[rgb(28,28,28)] focus:outline-none  font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                                    <div class="flex flex-row items-center gap-2">
                                        <p>
                                            Create
                                        </p>
                                    </div>

                                </button>

                                <div wire:loading>
                                    <div class="flex items-center justify-center loader loader--style3 " title="2">
                                        <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px"
                                            height="40px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;"
                                            xml:space="preserve">
                                            <path fill="#000"
                                                d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
                                                <animateTransform attributeType="xml" attributeName="transform"
                                                    type="rotate" from="0 25 25" to="360 25 25" dur="0.6s"
                                                    repeatCount="indefinite" />
                                            </path>
                                        </svg>
                                    </div>
                                </div>
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
