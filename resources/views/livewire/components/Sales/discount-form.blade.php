{{-- //var from livewire variable passed to blade file with entanglement --}}
<div x-cloak x-show="showDiscountForm">

    {{-- //* form background --}}
    <div class="fixed inset-0 z-40 bg-gray-900/50 dark:bg-gray-900/80"></div>

    {{-- //* form position --}}
    <div
        class="fixed top-0 left-0 right-0 z-50 items-center flex justify-center w-full overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">

        <div class="relative w-full max-w-2xl max-h-full mx-auto my-auto">

            <form class="relative bg-[rgb(238,238,238)] rounded-lg shadow " wire:submit.prevent="create">
                @csrf

                <div class="flex items-center justify-between px-6 py-2 border-b rounded-t ">

                    <div class="flex justify-center w-full p-2">

                        {{-- //* form title --}}
                        <h3 class="text-xl font-black text-gray-900 item ">

                            @if ($isCreate)
                                Create Customer
                            @else
                                Discount Form
                            @endif

                        </h3>
                    </div>

                    {{-- //* close button --}}
                    <button type="button" x-on:click="showDiscountForm=false" wire:click=' resetFormWhenClosed() '
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
                                <h1 class="font-bold">
                                    @if ($isCreate)
                                        Customer Information
                                    @else
                                        Discount Information
                                    @endif
                                </h1>
                            </div>

                            <div class="p-4">

                                @if ($isCreate)
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

                                                <label for="lastname"
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Last
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
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Birth
                                                    Date</label>

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
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Contact
                                                    No</label>

                                                <input type="number" id="contactno" wire:model="contact_number"
                                                    class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md  block w-full p-2.5"
                                                    placeholder="Contact No" required />

                                                @error('contact_number')
                                                    <span class="font-medium text-red-500 error">{{ $message }}</span>
                                                @enderror

                                            </div>

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
                                        </div>

                                        {{-- //* fourth row --}}
                                        <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">



                                            {{-- //* city --}}
                                            <div class="mb-3">

                                                <label for="selectCity"
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">City
                                                    / Municipality
                                                </label>


                                                <select id="selectCity" wire:model.live="selectCity" required
                                                    class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5 ">
                                                    <option value="" selected>Select a city / municipality
                                                    </option>

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
                                                    <span
                                                        class="font-medium text-red-500 error">{{ $message }}</span>
                                                @enderror

                                            </div>

                                        </div>

                                        <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">

                                            {{-- //* street --}}
                                            <div class="mb-3">

                                                <label for="street"
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Street</label>

                                                <input type="text" id="street" wire:model="street"
                                                    class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5"
                                                    placeholder="Street" required />
                                                @error('street')
                                                    <span
                                                        class="font-medium text-red-500 error">{{ $message }}</span>
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

                                                <select id="customerType" wire:model.live="customerType" required
                                                    class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5 ">
                                                    <option value=""selected>Select Customer Type</option>
                                                    <option value="PWD">PWD</option>
                                                    <option value="Senior Citizen">Senior Citizen</option>

                                                </select>

                                                @error('customerType')
                                                    <span
                                                        class="font-medium text-red-500 error">{{ $message }}</span>
                                                @enderror

                                            </div>

                                            <div class="mb-3">

                                                <label for="customer_discount_no"
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Customer
                                                    Discount
                                                    No</label>

                                                <input type="number" id="customer_discount_no"
                                                    wire:model="customer_discount_no"
                                                    class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5"
                                                    placeholder="Discount No" required />
                                                @error('customer_discount_no')
                                                    <span
                                                        class="font-medium text-red-500 error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- //* fifth row --}}
                                        <div class="mb-3">
                                            <label for="discount_percentage"
                                                class="block mb-2 text-sm font-medium text-gray-900 ">Discount
                                                Percentage
                                                (%)<span class="text-red-400 ">*</span></label>

                                            <input type="number" id="discount_percentage" required
                                                wire:model="discount_percentage"
                                                class=" bg-[rgb(245,245,245)] text-gray-900 border border-[rgb(143,143,143)] text-sm rounded-md block w-full p-2.5"
                                                placeholder="Discount Percentage" />

                                            @error('discount_percentage')
                                                <span class="font-medium text-red-500 error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @else
                                    @if (empty($customer_name))
                                        <div class="flex flex-col">
                                            <label for="credit_id"
                                                class="block mb-1 text-sm font-medium text-gray-900 ">Customer Name
                                            </label>
                                            <div class="flex flex-row w-1/2 gap-2">

                                                <input wire:model.live.debounce.300ms='searchCustomer' type="search"
                                                    value="{{ $customer_name }}" list="itemList"
                                                    class="w-full p-2 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(143,143,143)] placeholder-[rgb(101,101,101)] text-[rgb(53,53,53)] rounded-md cursor-pointer text-sm bg-[rgb(242,242,242)]"
                                                    placeholder="Search Customer">

                                                    <div class="mt-6.5">
                                                        <button type="button" wire:loading.remove wire:click="createCustomer"
                                                            class="text-white bg-[rgb(55,55,55)] focus:ring-4 hover:bg-[rgb(28,28,28)] focus:outline-none  font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                                                            <div class="flex flex-row items-center gap-2">
                                                                <p>
                                                                    +
                                                                </p>
                                                            </div>
                                                        </button>
                                                    </div>
                                            </div>
                                            @if (!empty($searchCustomer))
                                                <div
                                                    class="fixed max-h-1/2 z-99 h-[200px] mt-16 rounded-b-lg overflow-y-scroll bg-[rgb(75,75,75)]">
                                                    @foreach ($customers as $customer)
                                                        <ul wire:click="getCustomer({{ $customer->id }})"
                                                            class="w-full px-4 py-2 transition-all duration-100 ease-in-out text-white cursor-pointer hover:bg-[rgb(233,72,84)] h-fit">
                                                            <li class="flex items-start justify-between">
                                                                <!-- Item details on the left side -->
                                                                <div class="text-[0.8em] font-medium text-wrap">
                                                                    {{ $customer->firstname . ' ' . $customer->middlename . ' ' . $customer->lastname }}
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    @endforeach
                                                </div>
                                            @endif
                                            {{-- <div class="font-medium text-[1.6em] w-1/2">
                                    <select id="selectCustomer" wire:model.live="selectCustomer" autofocus
                                        class="bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5">
                                        <option value="" selected>Select customer</option>
                                        @foreach ($credit_customers as $credit_customer)
                                            <option value="{{ $credit_customer->id }} ">
                                                {{ $credit_customer->firstname . ' ' . $credit_customer->middlename . ' ' . $credit_customer->lastname }}
                                                {{ $credit_customer->creditJoin->credit_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                        </div>
                                    @else
                                        <div class="mb-3">
                                            <label for="credit_id"
                                                class="block mb-2 text-sm font-medium text-gray-900 ">Customer Name
                                            </label>
                                            <div class="flex flex-row items-center justify-between">
                                                <p class="text-2xl font-bold ">{{ $customer_name }}</p>

                                                {{-- clear customer name --}}
                                                <div wire:click='clearSelectedCustomerName()'>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor"
                                                        class="size-6">
                                                        <path strokeLinecap="round" strokeLinejoin="round"
                                                            d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @error('customer_name')
                                        <span class="font-medium text-red-500 error">{{ $message }}</span>
                                    @enderror

                                    <div class="grid justify-between grid-flow-col grid-cols-2 gap-4">

                                        {{-- //* discount type --}}

                                        <div class="mb-3">

                                            <label for="customerType"
                                                class="block mb-2 text-sm font-medium text-gray-900 ">Customer
                                                Type</label>

                                            <input id="customerType" wire:model.live="customerType" required disabled
                                            class=" bg-[rgb(245,245,245)] text-gray-900 border border-[rgb(143,143,143)] text-sm rounded-md block w-full p-2.5" placeholder="Select Customer Type"/>

                                            @error('customerType')
                                                <span class="font-medium text-red-500 error">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        {{-- //* middlename --}}
                                        <div class="mb-3">

                                            <label for="discount_percentage"
                                                class="block mb-2 text-sm font-medium text-gray-900 ">Discount
                                                Percentage
                                                (%)<span class="text-red-400 ">*</span></label>

                                            <input type="number" id="discount_percentage" required disabled
                                                wire:model="discount_percentage"
                                                class=" bg-[rgb(245,245,245)] text-gray-900 border border-[rgb(143,143,143)] text-sm rounded-md block w-full p-2.5"
                                                placeholder="Discount Percentage" />

                                            @error('discount_percentage')
                                                <span class="font-medium text-red-500 error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">

                                        <label for="customer_discount_no"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Customer
                                            Discount
                                            No</label>

                                        <input type="number" id="customer_discount_no" disabled
                                            wire:model="customer_discount_no"
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5"
                                            placeholder="Discount No" required />
                                        @error('customer_discount_no')
                                            <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror

                                    </div>
                                @endif
                                {{-- //* lastname --}}


                                @if ($isCreate)
                                    <div class="flex flex-row justify-between mx-4">
                                        <div>
                                            <button type="button" wire:click='returnToDiscountForm()'
                                                class="text-[rgb(0,0,0)] bg-[rgb(218,218,218)] hover:bg-[rgb(165,165,165)] font-medium rounded-md text-sm w-full sm:w-auto px-5 py-2.5 text-center transition ease-in-out duration-100">Return</button>
                                        </div>
                                        <div class="flex flex-row gap-2 ">

                                            <div>
                                                <button type="reset"
                                                    class="text-[rgb(53,53,53)] hover:bg-[rgb(229,229,229)] font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition ease-in-out duration-100">Clear
                                                    All</button>
                                            </div>
                                            <div>
                                                <button type="button" wire:loading.remove wire:click="create"
                                                    class="text-white bg-[rgb(55,55,55)] focus:ring-4 hover:bg-[rgb(28,28,28)] focus:outline-none  font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                                                    <div class="flex flex-row items-center gap-2">
                                                        <p>
                                                            Create
                                                        </p>
                                                    </div>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center justify-between w-full">
                                        <div>
                                            <div>
                                                <button type="button" wire:loading.remove wire:click="removeDiscount"
                                                    class="text-[rgb(53,53,53)] bg-[rgb(238,238,238)] underline focus:ring-4  focus:outline-none  font-medium rounded-lg text-sm w-full ease-in-out duration-100 transition-all sm:w-auto text-center ">
                                                    <div class="flex flex-row items-center gap-2">
                                                        <p>
                                                            Remove Discount
                                                        </p>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                        {{-- //* submit button for create --}}
                                        <button type="submit" wire:loading.remove
                                            class="text-white bg-[rgb(55,55,55)] focus:ring-4 hover:bg-[rgb(28,28,28)] focus:outline-none  font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                                            <div class="flex flex-row items-center gap-2">
                                                <p>
                                                    Apply
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
                                                        <animateTransform attributeType="xml"
                                                            attributeName="transform" type="rotate" from="0 25 25"
                                                            to="360 25 25" dur="0.6s" repeatCount="indefinite" />
                                                    </path>
                                                </svg>
                                            </div>

                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>

<x-livewire-alert::flash />
