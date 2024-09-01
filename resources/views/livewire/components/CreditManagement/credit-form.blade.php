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
                                Edit Credit
                            @else
                                Create Credit
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
                                <h1 class="font-bold">Credit Information</h1>
                            </div>

                            <div class="p-4">

                                <div class="flex flex-col gap-2">

                                    {{-- //* credit id --}}
                                    <div class="mb-3">

                                        <label for="credit_id"
                                            class="block mb-2 font-medium text-gray-900 text-md ">Credit ID
                                        </label>

                                        <p class=" text-[2em] font-black">192038</p>

                                    </div>

                                    {{-- //* province --}}
                                    <div class="mb-3">

                                        <label for="selectCustomer"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Customer Name
                                        </label>

                                        <select id="selectCustomer" wire:model.live="selectCustomer" required
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5 ">
                                            {{-- <option value="" selected>Select Customer</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->province_code }}">
                                                    {{ $province->province_description }}</option>
                                            @endforeach --}}

                                        </select>

                                        {{-- @error('selectProvince')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror --}}

                                    </div>

                                    {{-- //* credit limit --}}
                                    <div class="mb-3">

                                        <label for="credit_limit"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Credit Limit
                                        </label>

                                        <input type="number" id="credit_limit" wire:model="credit_limit"
                                            class=" bg-[rgb(245,245,245)] text-gray-900 border border-[rgb(143,143,143)] text-sm rounded-md  block w-full p-2.5"
                                            placeholder="Enter Credit Limit" tabindex="2" required />

                                        {{-- @error('credit_limit')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror --}}

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
                                <button type="submit" wire:loading.remove
                                    class="text-white bg-[rgb(55,55,55)] focus:ring-4 hover:bg-[rgb(28,28,28)] focus:outline-none  font-medium rounded-md text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
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
