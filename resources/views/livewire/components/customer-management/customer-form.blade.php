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
                                Edit Customer
                            @else
                                Create Customer
                            @endif

                        </h3>
                    </div>

                    {{-- //* close button --}}
                    <button type="button" x-on:click="showModal=false" wire:click='resetFormWhenClosed() '
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
                        <div class="border-2 border-[rgb(53,53,53)] rounded-sm">

                            <div
                                class="p-2 border-b bg-[rgb(53,53,53)] text-[rgb(242,242,242)] pointer-events-none rounded-br-sm rounded-bl-sm">
                                <h1 class="font-bold">Customer Information</h1>
                            </div>

                            <div class="p-4">

                                {{-- //* first row --}}
                                <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">

                                    {{-- //* firstname --}}
                                    <div class="mb-3">

                                        <label for="firstname"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">First Name
                                        </label>

                                        <input type="text" id="firstname" wire:model="firstname"
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md  block w-full p-2.5"
                                            placeholder="First Name" tabindex="2" required />

                                        @error('firstname')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- //* middlename --}}
                                    <div class="mb-3">

                                        <label for="middlename"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Middle
                                            Name <span class="text-red-400 ">*</span></label>

                                        <input type="text" id="middlename" wire:model="middlename"
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md  block w-full p-2.5"
                                            placeholder="Middle Name" />

                                        @error('middlename')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>

                                {{-- //* second row --}}
                                <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">

                                    {{-- //* lastname --}}
                                    <div class="mb-3">

                                        <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900 ">Last
                                            Name
                                        </label>

                                        <input type="text" id="lastname" wire:model="lastname"
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5"
                                            placeholder="Last Name" required />

                                        @error('lastname')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    {{-- //* birth date --}}
                                    <div class="mb-3">

                                        <label for="birthdate"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Birth Date</label>

                                        <input type="date" id="birthdate" wire:model="birthdate"
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5"
                                            placeholder="Birth Date" required />

                                        @error('birth_date')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>

                                </div>

                                {{-- //* third row --}}
                                <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">

                                    {{-- //* contact number --}}
                                    <div class="mb-3">

                                        <label for="contactno"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Contact No</label>

                                        <input type="number" id="contactno" wire:model="contact_number"
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md  block w-full p-2.5"
                                            placeholder="Contact No" required />

                                        @error('contact_number')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="mb-3">

                                        <label for="id_picture" class="block mb-2 text-sm font-medium text-gray-900 ">ID
                                            Picture
                                        </label>

                                        <input id="id_picture" type="file" accept="image/png, image/jpeg"
                                            wire:model="id_picture"
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5">

                                        @if ($id_picture instanceof \Illuminate\Http\UploadedFile)
                                            <img src="{{ $id_picture->temporaryUrl() }}">
                                        @elseif(is_string($id_picture))
                                            <img src="{{ $imageUrl }}" alt="Customer ID Picture"
                                                class="w-1/3 h-1/2">
                                        @endif

                                        @error('id_picture')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                {{-- //* fourth row --}}
                                <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">

                                    {{-- //* province --}}
                                    <div class="mb-3">

                                        <label for="selectProvince"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Province
                                        </label>

                                        <select id="selectProvince" wire:model.live="selectProvince" required
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5 ">
                                            <option value="" selected>Select province</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->province_code }}">
                                                    {{ $province->province_description }}</option>
                                            @endforeach

                                        </select>

                                        @error('selectProvince')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    {{-- //* city --}}
                                    <div class="mb-3">

                                        <label for="selectCity"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">City
                                            / Municipality
                                        </label>


                                        <select id="selectCity" wire:model.live="selectCity" required
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5 ">
                                            <option value="" selected>Select a city / municipality</option>

                                            @if (!is_null($cities))
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->city_municipality_code }}"
                                                        {{ $city->city_municipality_code == $selectCity ? 'selected' : '' }}>
                                                        {{ $city->city_municipality_description }}</option>
                                                @endforeach


                                            @endif

                                        </select>

                                        @error('selectCity')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>

                                </div>

                                {{-- //* fifth row --}}

                                <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">

                                    {{-- //* brgy --}}
                                    <div class="mb-3">

                                        <label for="selectBrgy"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Barangay</label>

                                        <select id="selectBrgy" wire:model.live="selectBrgy" required
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5 ">
                                            <option value="" selected>Select a barangay</option>

                                            @if (!is_null($barangays))
                                                @foreach ($barangays as $barangay)
                                                    <option value="{{ $barangay->barangay_code }}"
                                                        {{ $barangay->barangay_code == $selectBrgy ? 'selected' : '' }}>
                                                        {{ $barangay->barangay_description }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        @error('selectBrgy')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    {{-- //* street --}}
                                    <div class="mb-3">

                                        <label for="street"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Street</label>

                                        <input type="text" id="street" wire:model="street"
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5"
                                            placeholder="Street" required />
                                        @error('street')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </div>


                                </div>

                                {{-- //* sixth row --}}
                                <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">
                                    {{-- //* customer type --}}
                                    <div class="mb-3">

                                        <label for="customerType"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Customer
                                            Type</label>

                                        <select id="customer_type" wire:model.live="customerType" required
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5 ">
                                            <option value=""selected>Select Customer Type</option>
                                            <option value="Credit">Credit</option>
                                            <option value="PWD">PWD</option>
                                            <option value="Senior Citizen">Senior Citizen</option>


                                        </select>

                                        @error('customerType')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    {{-- //* discount no --}}
                                    <div class="mb-3">

                                        <label for="customer_discount_no"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Customer Discount
                                            No</label>

                                        <input type="number" id="customer_discount_no"
                                            wire:model="customer_discount_no"
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5"
                                            placeholder="Discount No" required />
                                        @error('customer_discount_no')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror
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
                                        <div class="flex items-center justify-center loader loader--style3 "
                                            title="2">
                                            <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                width="40px" height="40px" viewBox="0 0 50 50"
                                                style="enable-background:new 0 0 50 50;" xml:space="preserve">
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
                                    <button type="reset" wire:click="resetForm"
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
                                        <div class="flex items-center justify-center loader loader--style3 "
                                            title="2">
                                            <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                width="40px" height="40px" viewBox="0 0 50 50"
                                                style="enable-background:new 0 0 50 50;" xml:space="preserve">
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
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>

<x-livewire-alert::flash />
