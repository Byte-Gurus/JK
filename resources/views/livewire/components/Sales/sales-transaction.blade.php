<div class="grid grid-flow-col grid-cols-3 p-[28px]">
    <div class="flex flex-col col-span-2">
        <div class="flex flex-row justify-between gap-4 pb-[28px]">
            <div class="w-2/4">
                <div class="relative w-full">

                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black " fill="none"
                            viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
                            <path strokeLinecap="round" strokeLinejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>

                    <input wire:model.live.debounce.300ms='search' type="text" list="itemList"
                        class="w-full p-4 pl-10 hover:bg-[rgb(230,230,230)] outline-offset-2 hover:outline transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-[rgb(101,101,101)] text-[rgb(53,53,53)] rounded-sm cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Search by Item Name or Barcode" required="">
                </div>
                {{-- <img id="dimg_DGjVZrqyIPnd2roPzvzYmQc_249"
                    src="data:image/jpeg;base64,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" --}}
                @if (!empty($search))
                    <div class="absolute w-1/3 h-fit max-h-[400px] overflow-y-scroll bg-[rgb(248,248,248)]">
                        @foreach ($items as $item)
                            <ul wire:click="selectItem({{ $item->id }})"
                                class="w-full p-4 transition-all duration-100 ease-in-out border border-black cursor-pointer hover:bg-[rgb(208,208,208)] h-fit text-nowrap">
                                <li class="flex items-start justify-between">
                                    <!-- Item details on the left side -->
                                    <div class="flex flex-col items-start leading-1">
                                        <div class="text-[1.2em] font-bold">{{ $item->item_name }}</div>
                                        <div class="text-[0.8em]">{{ $item->item_description }}</div>
                                        <div class="text-[1em]">{{ $item->barcode }}</div>
                                    </div>

                                    <!-- Price on the right side -->
                                    <div class="flex flex-row items-center self-center justify-between gap-2 ">

                                        <p class="text-[1em] font-medium italic">PHP</p>
                                        <p class="text-[1.5em] font-bold ">
                                            {{ number_format($item->inventoryJoin->selling_price, 2) }}</p>
                                    </div>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="flex flex-row items-center gap-4 text-nowrap">
                <div>
                    <button
                        class="px-6 py-4 bg-[rgb(254,184,134)] border border-black hover:bg-[rgb(255,151,78)] ease-in-out duration-100 transition-all">Sales</button>
                </div>
                <div>
                    <button
                        class="px-6 py-4 bg-[rgb(166,254,134)] border border-black hover:bg-[rgb(152,255,78)] ease-in-out duration-100 transition-all">New
                        Sales</button>
                </div>
                <div>
                    <button x-on:click="$wire.displaySalesTransactionHistory()"
                        class="px-6 py-4 bg-[rgb(230,254,134)] border border-black hover:bg-[rgb(214,255,49)] ease-in-out duration-100 transition-all">Transaction
                        History</button>
                </div>
            </div>
        </div>
        <div class="border border-black">
            {{-- //* tablea area --}}
            <div class="overflow-x-auto overflow-y-scroll scroll h-[540px] ">

                <table class="w-full h-10 text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] top-0">

                        <tr class=" text-nowrap">

                            {{-- //* # count --}}
                            <th wire:click="sortByColumn('created_at')" scope="col"
                                class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                                <div class="flex items-center">

                                    <p>#</p>

                                </div>
                            </th>

                            {{-- //* item name --}}
                            <th scope="col" class="py-3 pl-4 pr-2 text-left">Item Name</th>

                            {{-- //* item descrition --}}
                            <th scope="col" class="px-4 py-3 text-center">Description</th>

                            {{-- //* quantity --}}
                            <th scope="col" class="px-4 py-3 text-center">Quantity</th>

                            {{-- //* price --}}
                            <th scope="col" class="px-4 py-3 text-center">Price(₱)</th>

                            {{-- //* discount --}}
                            <th scope="col" class="px-4 py-3 text-center">Wholesale(%)</th>

                            {{-- //* amount --}}
                            <th scope="col" class="px-4 py-3 text-center">Subtotal(₱)</th>

                        </tr>
                    </thead>

                    {{-- //* table body --}}

                    <tbody>
                        @foreach ($selectedItems as $index => $selectedItem)
                            <tr wire:click="getIndex({{ $index }}, true )" x-data="{ isSelected: false }"
                                x-on:click=" isSelected = !isSelected "
                                class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75 cursor-pointer">

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap"
                                    :class="isSelected && ' bg-gray-200'">
                                    {{ $index + 1 }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap "
                                    :class="isSelected && ' bg-gray-200'">
                                    <div class="flex flex-col ">
                                        <div class="text-xl font-black">{{ $selectedItem['item_name'] }}</div>
                                        <div class="flex flex-row gap-2 w-fit">
                                            <div class="text-sm italic font-medium text-[rgb(122,122,122)]">
                                                {{ $selectedItem['barcode'] }}</div>
                                            <div class="font-black text-[rgb(80,80,80)]">|</div>
                                            <div class="text-sm italic font-medium text-[rgb(122,122,122)]">
                                                {{ $selectedItem['sku_code'] }}</div>
                                        </div>
                                    </div>

                                </th>
                                <th scope="row"
                                    class="px-4 py-4 text-lg font-medium text-center text-gray-900 whitespace-nowrap"
                                    :class="isSelected && ' bg-gray-200'">
                                    {{ $selectedItem['item_description'] }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-4 text-lg font-medium text-center text-gray-900 whitespace-nowrap"
                                    :class="isSelected && ' bg-gray-200'">
                                    {{ $selectedItem['quantity'] }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-4 text-lg font-black text-center text-gray-900 whitespace-nowrap"
                                    :class="isSelected && ' bg-gray-200'">
                                    {{ number_format($selectedItem['selling_price'], 2) }}
                                </th>


                                <th scope="row"
                                    class="px-4 py-4 text-lg font-medium text-center text-gray-900 whitespace-nowrap"
                                    :class="isSelected && ' bg-gray-200'">
                                    {{ $selectedItem['discount'] }} %
                                </th>

                                <th scope="row"
                                    class="flex flex-col px-4 py-4 text-xl font-black text-center text-gray-900"
                                    :class="isSelected && ' bg-gray-200'">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="text-xl font-black">
                                            {{ number_format($selectedItem['total_amount'], 2) }}
                                        </div>
                                        <div>
                                            <div class="text-sm text-left italic font-medium text-[rgb(122,122,122)]">

                                                {{ number_format($selectedItem['original_total'], 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class=" pt-[28px]">
            <div class="grid grid-flow-col">
                <div class="flex flex-row gap-4">
                    <div class="flex flex-col gap-2">
                        <div
                            class="py-4 text-center font-bold bg-[rgb(251,143,242)] hover:bg-[rgb(255,111,231)] border border-black hover:shadow-md hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                            <button class="px-8 py-2 ">Return</button>
                        </div>
                        <div
                            class="py-4 text-center font-bold bg-[rgb(251,143,143)] hover:bg-[rgb(255,111,111)] border border-black hover:shadow-md hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                            <button wire:click="cancel" x-on:keydown.window.prevent.ctrl.1="$wire.call('cancel')"
                                class="px-8 py-2 ">
                                Cancel Transaction
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <div
                            class="py-4  px-8 text-center font-bold bg-[rgb(251,143,206)] hover:bg-[rgb(255,111,209)] border border-black hover:shadow-md hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                            @if (!empty($selectedItems))
                                <button class="px-8 py-2 "
                                    x-on:keydown.window.prevent.ctrl.4="$wire.call('displayDiscountForm')"
                                    x-on:click="$wire.displayDiscountForm()">
                                    Discount
                                </button>
                            @else
                                <button class="px-8 py-2 " disabled>
                                    Discount
                                </button>
                            @endif
                        </div>
                        <div
                            class="py-4 px-8 text-center font-bold bg-[rgb(154,143,251)] hover:bg-[rgb(128,111,255)] border border-black hover:shadow-md hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                            @if (!empty($selectedItems))
                                <button wire:click="removeItem"
                                    x-on:keydown.window.prevent.ctrl.3="$wire.call('removeItem')" class="px-8 py-2 ">
                                    Remove Item
                                </button>
                            @else
                                <button disabled wire:click="removeItem"
                                    x-on:keydown.window.prevent.ctrl.3="$wire.call('removeItem')" class="px-8 py-2 ">
                                    Remove Item
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <div
                            class="py-4 px-8 text-center font-bold bg-[rgb(143,244,251)] hover:bg-[rgb(100,228,231)] border border-black hover:shadow-md  hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">

                            @if (!empty($selectedItems))
                                <button wire:click="setQuantity" id="setQuantity"
                                    x-on:keydown.window.prevent.ctrl.2="$wire.call('setQuantity')" class="px-8 py-2 ">
                                    Quantity
                                </button>
                            @else
                                <button disabled class="px-8 py-2 ">
                                    Quantity
                                </button>
                            @endif
                        </div>
                        <div
                            class="py-4 px-8 font-bold text-center bg-[rgb(251,240,143)] hover:bg-[rgb(232,219,101)] border border-black hover:shadow-md hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                            @if (!empty($selectedItems))
                                <button class="px-8 py-2"
                                    x-on:keydown.window.prevent.ctrl.5="$wire.call('displayPaymentForm')"
                                    x-on:click="$wire.displayPaymentForm()">
                                    Pay
                                </button>
                            @else
                                <button class="px-8 py-2" disabled>
                                    Pay
                                </button>
                            @endif
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-center w-full font-black bg-green-400 border hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap hover:shadow-md border-black hover:bg-green-500">
                        @if (!empty($payment))
                            <div class="text-center text-nowrap">
                                <button type="button" class="px-8 py-2 "
                                    x-on:keydown.window.prevent.ctrl.enter="$wire.call('save')" wire:click="save">
                                    Save
                                </button>
                            </div>
                        @else
                            <div class="text-center text-nowrap">
                                <button disabled class="px-8 py-2">
                                    Save
                                </button>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-[rgba(241,203,162,0.32)] ml-[28px] border-2 border-[rgb(53,53,53)] text-nowrap rounded-md">
        <div class="flex flex-col ">
            {{-- date & time section --}}
            <div class="flex flex-row items-center justify-center gap-8 p-2">
                <div x-data="{ focusInput() { this.$refs.barcodeInput.focus(); } }">
                    <input type="text" x-ref="barcodeInput" wire.live="barcode" style="opacity: 0;" autofocus
                        x-on:keydown.window.prevent.ctrl.0="focusInput()" wire:model.live="barcode">
                </div>
                <div>
                    <p>Time</p>
                </div>
            </div>
            {{-- transaction number section --}}
            <div class="mb-2">
                <div class="border border-black "></div>
            </div>
            <div class="flex flex-col mx-6">
                <div>
                    <p class=" font-medium text-[1.6em]">Transaction No.</p>
                </div>
                <div class="flex justify-center font-black italic text-[2.2em]">
                    <p>{{ $transaction_number }}</p>
                </div>
            </div>
            {{-- discount section --}}
            <div class="flex flex-row items-center">
                <div class="w-full ">
                    <div class="border border-black "></div>
                </div>
                <div class="m-2">
                    <p class=" font-medium text-[2em]">Discount</p>
                </div>
                <div class="w-full">
                    <div class="border border-black "></div>
                </div>
            </div>
            <div class="flex flex-col gap-2 mx-6 mb-2">
                <div class="flex flex-row items-center gap-6">
                    <div class=" font-medium text-[1.6em]">Discount Type: {{ $discount_type }}</div>
                </div>
                <div class="flex flex-row items-center gap-6 ">
                    <div class=" font-medium text-[1.6em]">Customer Name: {{ $customer_name }}</div>

                </div>
                <div class="flex flex-row items-center gap-6 ">
                    <div class=" font-medium text-[1.6em]">ID No.: {{ $customer_discount_no }}</div>

                </div>
            </div>
            <div class="my-2">
                <div class="border border-black"></div>
            </div>
            {{-- ss --}}
            <div class="flex flex-col gap-2 mx-6">
                <div class="flex flex-row justify-between">
                    <div class=" font-medium text-[1.4em]">
                        <p>Tax Amount</p>
                    </div>
                    <div class=" font-black text-[1.4em]">₱ {{ number_format($totalVat, 2) }}</div>
                </div>

                <div class="w-full my-2">
                    <div class="border border-black"></div>
                </div>
                <div class="flex flex-row justify-between">
                    <div class=" font-black text-[2em]">
                        <p>Subtotal</p>
                    </div>
                    <div class=" font-black text-[2em]">₱ {{ number_format($subtotal, 2) }}</div>
                </div>
                <div class="flex flex-row justify-between">
                    <div class=" font-medium text-[1.4em]">
                        <p>Discount </p>
                    </div>

                    <div class=" font-black text-[1.4em]">%</div>
                </div>

                <div class="flex flex-row justify-between">
                    <div class=" font-medium text-[1.4em]">
                        <p>Senior & PWD </p>
                    </div>

                    <div class=" font-black text-[1.4em]">{{ $discount_percent }} %</div>
                </div>
                <div class="flex flex-row justify-between">
                    <div class=" font-medium text-[1.4em]">
                        <p>Discount Amount</p>
                    </div>
                    <div class=" font-black text-[1.4em]">₱ {{ number_format($discount_amount, 2) }}</div>
                </div>
                <div class="w-full my-2">
                    <div class="border border-black"></div>
                </div>
                <div class="flex flex-row justify-between">
                    <div class=" font-black text-[2em]">
                        <p>Total</p>
                    </div>
                    <div class=" font-black text-[2em]">₱ {{ number_format($grandTotal, 2) }}</div>
                </div>
                <div class="flex flex-row justify-between">
                    <div class=" font-medium text-[1.4em]">
                        <p>Tendered Amount</p>
                    </div>
                    <div class=" font-black text-[1.4em]">₱ {{ number_format($tendered_amount, 2) }}</div>
                </div>
                <div class="w-full">
                    <div class="border border-black"></div>
                </div>
                <div class="flex flex-row justify-between">
                    <div class=" font-black text-green-900 text-[2.2em]">
                        <p>Change</p>
                    </div>
                    <div class=" font-black text-[2em]">₱ {{ number_format($change, 2) }}</div>
                </div>
                <div wire:click='displaySalesReceipt()'>
                    DISPLAY RECEIPT
                </div>
            </div>
        </div>
    </div>
    <div x-show="showChangeQuantityForm" x-data="{ showChangeQuantityForm: @entangle('showChangeQuantityForm') }">
        @livewire('components.sales.change-quantity-form')
    </div>
    <div x-show="showAdminLoginForm" x-data="{ showAdminLoginForm: @entangle('showAdminLoginForm') }">
        @livewire('components.sales.admin-login-form')
    </div>
    <div x-show="showPaymentForm" x-data="{ showPaymentForm: @entangle('showPaymentForm') }">
        @livewire('components.sales.payment-form')
    </div>
    <div x-show="showDiscountForm" x-data="{ showDiscountForm: @entangle('showDiscountForm') }">
        @livewire('components.sales.discount-form')
    </div>
    <div x-show="showWholesaleForm" x-data="{ showWholesaleForm: @entangle('showWholesaleForm') }">
        @livewire('components.sales.wholesale-form')
    </div>
</div>