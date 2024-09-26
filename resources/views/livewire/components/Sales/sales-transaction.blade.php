<div class="grid grid-flow-col grid-cols-3 h-[90vh] p-[3vh]">
    <div class="flex flex-col col-span-2">
        <div class="flex flex-row items-start justify-between flex-1 ">
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

                @if (!empty($search))
                    <div class="absolute w-1/3 h-fit max-h-[400px] overflow-y-scroll bg-[rgb(248,248,248)]">
                        @foreach ($items as $item)
                            <ul wire:click="selectItem({{ $item->id }})"
                                class="w-full p-4 transition-all duration-100 ease-in-out border border-black cursor-pointer hover:bg-[rgb(208,208,208)] h-fit text-nowrap">
                                <li class="flex items-start justify-between">
                                    <!-- Item details on the left side -->
                                    <div class="flex flex-col w-[200px] items-start leading-1">
                                        <div class="text-[1.2em] font-bold text-wrap">{{ $item->item_name }}</div>
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
                @if (empty($payment) && empty($credit_details))
                    <div>
                        <select id="transaction_type" wire:model.live='changeTransactionType'
                            class=" bg-[rgb(255,206,121)] px-8 py-4 border border-[rgb(143,143,143)] text-gray-900 text-md font-black rounded-sm block w-full ">
                            <option selected value="1">Sales</option>
                            <option value="2">Credit</option>
                            <option value="3">Return</option>
                        </select>
                    </div>
                @endif
                <div>
                    <button x-on:click="$wire.displaySalesTransactionHistory()"
                        class="px-6 py-4 bg-[rgb(230,254,134)] border border-black hover:bg-[rgb(214,255,49)] font-bold ease-in-out duration-100 transition-all">Transaction
                        History</button>
                </div>
            </div>
        </div>

        {{-- //* tablea area --}}
        <div class=" flex-3 overflow-x-auto overflow-y-scroll border border-black scroll h-[52vh]">

            <table class="w-full text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] top-0">

                    <tr class=" text-nowrap">

                        {{-- //* # count --}}
                        <th scope="col" class="py-3 pl-4 pr-2 text-left ">#</th>

                        {{-- //* item name --}}
                        <th scope="col" class="py-3 pl-4 pr-2 text-left ">Item Name</th>

                        {{-- //* item descrition --}}
                        <th scope="col" class="px-4 py-3 text-left">Description</th>

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
                            x-on:click=" isSelected = true;" x-on:click.away="isSelected = false;"
                            class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75 cursor-pointer">

                            <th scope="row"
                                class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap"
                                :class="isSelected && ' bg-gray-200'">
                                {{ $index + 1 }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 text-left text-gray-900 text-md whitespace-nowrap text-wrap"
                                :class="isSelected && ' bg-gray-200'">
                                <div class="flex flex-col break-all">
                                    <div class="text-xl font-bold">{{ $selectedItem['item_name'] }}</div>
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
                                class="px-4 py-4 text-lg font-medium text-left text-gray-900 break-all whitespace-nowrap text-wrap"
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
                                class="px-4 py-4 text-lg font-medium text-left text-gray-900 whitespace-nowrap text-wrap"
                                :class="isSelected && ' bg-gray-200'">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="text-xl font-black">
                                        {{ number_format($selectedItem['total_amount'], 2) }}
                                    </div>
                                    <div class="text-sm text-left italic font-medium text-[rgb(122,122,122)]">

                                        {{ number_format($selectedItem['original_total'], 2) }}
                                    </div>
                                </div>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex-1 pt-[28px]">
            <div class="grid grid-flow-col grid-cols-4 gap-4">
                <div class="flex flex-col gap-2">
                    <div wire:click="displaySalesReturn()"
                        class="py-4 text-center font-bold bg-[rgb(251,143,242)] hover:bg-[rgb(255,111,231)] border border-black hover:shadow-md hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                        <button class="py-2 text-center ">Return</button>
                    </div>
                    <div
                        class="py-4 text-center font-bold bg-[rgb(251,143,143)] hover:bg-[rgb(255,111,111)] border border-black hover:shadow-md hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                        <button wire:click="cancel" x-on:keydown.window.prevent.ctrl.1="$wire.call('cancel')"
                            class="py-2 text-center ">
                            Cancel Transaction
                        </button>
                    </div>
                </div>
                <div class="flex flex-col gap-2 ">
                    @if (!empty($selectedItems) && empty($payment) && $isSales)
                        <div x-on:keydown.window.prevent.ctrl.4="$wire.call('displayDiscountForm')"
                            x-on:click="$wire.displayDiscountForm()"
                            class="py-4 text-center font-bold bg-[rgb(251,143,206)] hover:bg-[rgb(255,111,209)] border border-black hover:shadow-md hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                            <button class="py-2 ">
                                Discount
                            </button>
                        </div>
                    @else
                        <div class="py-4 font-bold text-center bg-[rgb(201,201,201)] border border-black  text-nowrap">
                            <button class="py-2 " disabled>
                                Discount
                            </button>
                        </div>
                    @endif
                    @if (!empty($selectedItems) && empty($payment))
                        <div wire:click="removeItem" x-on:keydown.window.prevent.ctrl.3="$wire.call('removeItem')"
                            class="py-4 text-center font-bold bg-[rgb(154,143,251)] hover:bg-[rgb(128,111,255)] border border-black hover:shadow-md hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                            <button class="py-2 ">
                                Remove Item
                            </button>
                        </div>
                    @else
                        <div class="py-4 font-bold text-center bg-[rgb(201,201,201)] border border-black  text-nowrap">
                            <button disabled class="py-2 ">
                                Remove Item
                            </button>
                        </div>
                    @endif
                </div>
                <div class="flex flex-col gap-2 ">

                    @if (!empty($selectedItems) && empty($payment))
                        <div wire:click="setQuantity" id="setQuantity"
                            x-on:keydown.window.prevent.ctrl.2="$wire.call('setQuantity')"
                            class="py-4 text-center font-bold bg-[rgb(143,244,251)] hover:bg-[rgb(100,228,231)] border border-black hover:shadow-md  hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                            <button class="py-2 ">
                                Quantity
                            </button>
                        </div>
                    @else
                        <div class="py-4 font-bold text-center bg-[rgb(201,201,201)] border border-black  text-nowrap">
                            <button disabled class="py-2 ">
                                Quantity
                            </button>
                        </div>
                    @endif
                    @if (!empty($selectedItems) && $isSales)
                        <div x-on:keydown.window.prevent.ctrl.5="$wire.call('displayPaymentForm')"
                            x-on:click="$wire.displayPaymentForm()"
                            class="py-4 font-bold text-center bg-[rgb(251,240,143)] hover:bg-[rgb(232,219,101)] border border-black hover:shadow-md hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                            <button class="py-2">
                                Pay
                            </button>
                        </div>
                    @else
                        <div class="py-4 font-bold text-center bg-[rgb(201,201,201)] border border-black  text-nowrap">
                            <button class="py-2" disabled>
                                Pay
                            </button>
                        </div>
                    @endif
                </div>
                @if (!empty($payment) && $isSales)
                    <div
                        class="flex items-center justify-center w-full font-black bg-green-400 border hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap hover:shadow-md border-black hover:bg-green-500">
                        <button type="button" class="py-2 "
                            x-on:keydown.window.prevent.ctrl.enter="$wire.call('save')" wire:click="save">
                            Save
                        </button>
                    </div>
                @elseif (!$isSales && $credit_details && $selectedItems)
                    <div
                        class="flex items-center justify-center w-full font-black bg-green-400 border hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap hover:shadow-md border-black hover:bg-green-500">
                        <button type="button" class="py-2 "
                            x-on:keydown.window.prevent.ctrl.enter="$wire.call('save')" wire:click="save">
                            Save
                        </button>
                    </div>
                @else
                    <div
                        class="py-4 px-8 font-bold w-full items-center flex justify-center text-center bg-[rgb(201,201,201)] border border-black  text-nowrap">
                        <button type="button" class="y-2 ">
                            Save
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="bg-[rgba(245,214,162,0.58)] ml-[28px] border-2 border-[rgb(53,53,53)] text-nowrap rounded-md">
        @if ($changeTransactionType == 1)
            <div class="grid grid-flow-row">
                {{-- date & time section --}}
                <div class="flex flex-row items-center justify-center gap-8 p-2">
                    <div x-data="{ focusInput() { this.$refs.barcodeInput.focus(); } }">
                        <input type="text" x-ref="barcodeInput" wire.live="barcode" style="opacity: 0;" autofocus
                            x-on:keydown.window.prevent.ctrl.0="focusInput()" wire:model.live="barcode">
                    </div>
                    <div>
                        <p class="italic font-medium ">Time</p>
                    </div>
                </div>
                <div class="border border-black"></div>
                <div class="flex flex-col p-2">
                    <p class="text-[1.2em] font-bold">Transaction No.</p>
                    <p class="self-center text-[1.8em] italic font-black">{{ $transaction_number }}</p>
                </div>
                <div class="flex flex-row items-center">
                    <div class="w-full ">
                        <div class="border border-black "></div>
                    </div>
                    <div class="m-1">
                        <p class=" font-medium text-[1em]">Discount</p>
                    </div>
                    <div class="w-full">
                        <div class="border border-black "></div>
                    </div>
                </div>
                <div class="flex flex-col gap-2 p-2 mb-2">
                    <div class="flex flex-row items-center gap-6">
                        <div class=" font-medium text-[1.2em]">Discount Type: {{ $discount_type }}</div>
                    </div>
                    <div class="flex flex-row items-center gap-6 ">
                        <div class=" font-medium text-[1.2em]">Customer Name: {{ $customer_name }}</div>
                    </div>
                    <div class="flex flex-row items-center gap-6 ">
                        <div class=" font-medium text-[1.2em]">ID No.: {{ $senior_pwd_id }}</div>
                    </div>
                </div>
                <div class="border border-black "></div>
                <div class="flex flex-col h-full gap-2 p-2 justify-evenly">
                    <div class="flex flex-row justify-between">
                        <div class=" font-medium text-[1.2em]">
                            <p>Tax Amount</p>
                        </div>
                        <div class=" font-black text-[1.2em]">₱ {{ number_format($totalVat, 2) }}</div>
                    </div>
                    <div class="border border-black "></div>
                    <div class="flex flex-row justify-between">
                        <div class=" font-black text-[1.8em]">
                            <p>Subtotal</p>
                        </div>
                        <div class=" font-black text-[1.8em]">₱ {{ number_format($subtotal, 2) }}</div>
                    </div>
                    <div class="flex flex-row justify-between">
                        <div class=" font-medium text-[1.2em]">
                            <p>Senior & PWD </p>
                        </div>
                        <div class=" font-black text-[1.2em]">{{ $discount_percent }} %</div>
                    </div>
                    <div class="flex flex-row justify-between">
                        <div class=" font-medium text-[1.2em]">
                            <p>Discount Amount</p>
                        </div>
                        <div class=" font-black text-[1.2em]">₱ {{ number_format($PWD_Senior_discount_amount, 2) }}
                        </div>
                    </div>
                    <div class="border border-black "></div>
                    <div class="flex flex-row justify-between">
                        <div class=" font-black text-[1.8em]">
                            <p>Total</p>
                        </div>
                        <div class=" font-black text-[1.8em]">₱ {{ number_format($grandTotal, 2) }}</div>
                    </div>
                    <div class="flex flex-row justify-between">
                        <div class=" font-medium text-[1.2em]">
                            <p>Tendered Amount</p>
                        </div>
                        <div class=" font-black text-[1.2em]">₱ {{ number_format($tendered_amount, 2) }}</div>
                    </div>
                    <div class="border border-black "></div>
                    <div class="flex flex-row justify-between">
                        <div class=" font-black text-green-900 text-[2.4em]">
                            <p>Change</p>
                        </div>
                        <div class=" font-black text-[2em]">₱ {{ number_format($change, 2) }}</div>
                    </div>
                </div>
            </div>
        @elseif ($changeTransactionType == 2)
            {{-- credit details --}}
            <div class="grid grid-flow-row">
                {{-- date & time section --}}
                <div class="flex flex-row items-center justify-center gap-8 p-2">
                    <div x-data="{ focusInput() { this.$refs.barcodeInput.focus(); } }">
                        <input type="text" x-ref="barcodeInput" wire.live="barcode" id="barcode"
                            style="opacity: 0;" autofocus x-on:keydown.window.prevent.ctrl.0="focusInput()"
                            wire:model.live="barcode">
                    </div>
                    <div>
                        <p>Time</p>
                    </div>
                </div>
                {{-- transaction number section --}}
                <div class="border border-black"></div>
                <div class="flex flex-col p-2">
                    <p class="text-[1.2em] font-bold">Transaction No.</p>
                    <p class="self-center text-[1.8em] italic font-black">{{ $transaction_number }}</p>
                </div>
                {{-- credit section --}}
                <div class="flex flex-row items-center">
                    <div class="w-full ">
                        <div class="border border-black "></div>
                    </div>
                    <div class="m-1">
                        <p class=" font-medium text-[1em]">Credit</p>
                    </div>
                    <div class="w-full">
                        <div class="border border-black "></div>
                    </div>
                </div>
                <div class="flex flex-col p-2">
                    <div>

                        <label for="credit_id" class="block mb-1 font-medium text-[1.6em] text-gray-900 ">Customer
                            Name
                        </label>

                        @if (empty($credit_no))
                            <div class="relative w-1/2">

                                <input wire:model.live.debounce.300ms='searchCustomer' type="search" list="itemList"
                                    class="w-full p-2 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(143,143,143)] placeholder-[rgb(101,101,101)] text-[rgb(53,53,53)] rounded-md cursor-pointer text-sm bg-[rgb(242,242,242)]"
                                    placeholder="Search Customer" required="">

                            </div>
                            @if (!empty($searchCustomer))
                                <div
                                    class="fixed max-h-[400px] z-99 h-fit rounded-lg overflow-y-scroll bg-[rgb(75,75,75)]">
                                    @foreach ($credit_customers as $credit_customer)
                                        <ul wire:click="selectCustomer({{ $credit_customer->id }})"
                                            class="w-full px-4 py-2 transition-all  justify-between duration-100 ease-in-out text-white cursor-pointer hover:bg-[rgb(233,72,84)] h-fit">

                                            <li class="flex items-start justify-between">
                                                <!-- Item details on the left side -->
                                                <div
                                                    class="text-[0.8em] w-full gap-4 justify-between flex flex-row text-wrap">
                                                    <p class="font-medium">
                                                        {{ $credit_customer->firstname . ' ' . ($credit_customer->middlename ?? '') . ' ' . $credit_customer->lastname }}
                                                    </p>
                                                    @foreach ($credit_customer->creditJoin as $credit)
                                                        @if ($credit->status != 'Fully paid' && !$credit->transactionJoin)
                                                            <p class="italic font-thin">
                                                                {{ $credit->credit_number }}
                                                            </p>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="flex flex-col">
                                <div class="flex flex-row items-center justify-between">
                                    <div class="flex flex-col items-start">
                                        <p class=" font-black text-[1.2em]">{{ $creditor_name }}</p>
                                        <p class=" font-medium text-[1.2em] italic">{{ $credit_no }}</p>
                                        <div>
                                            <p>{{ $credit_limit }}</p>
                                        </div>
                                    </div>
                                    <div>
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
                            </div>
                        @endif
                    </div>
                    <div>
                        {{-- discount section --}}
                        <div class="flex flex-row items-center">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-1">
                                <p class=" font-medium text-[1em]">Discount</p>
                            </div>
                            <div class="w-full">
                                <div class="border border-black "></div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 mb-2">
                            <div class="flex flex-row items-center gap-6">
                                <div class=" font-medium text-[1.2em]">Discount Type: {{ $discount_type }}
                                </div>
                            </div>
                            <div class="flex flex-row items-center gap-6 ">
                                <div class=" font-medium text-[1.2em]">ID No.: {{ $senior_pwd_id }}</div>

                            </div>
                        </div>
                        <div class="my-2">
                            <div class="border border-black"></div>
                        </div>
                        {{-- ss --}}
                        <div class="flex flex-col gap-2 ">
                            <div class="flex flex-row justify-between">
                                <div class=" font-medium text-[1.2em]">
                                    <p>Tax Amount</p>
                                </div>
                                <div class=" font-black text-[1.2em]">₱ {{ number_format($totalVat, 2) }}
                                </div>
                            </div>

                            <div class="w-full my-2">
                                <div class="border border-black"></div>
                            </div>
                            <div class="flex flex-row justify-between">
                                <div class=" font-black text-[1.8em]">
                                    <p>Subtotal</p>
                                </div>
                                <div class=" font-black text-[1.8em]">₱ {{ number_format($subtotal, 2) }}
                                </div>
                            </div>
                            <div class="flex flex-row justify-between">
                                <div class=" font-medium text-[1.2em]">
                                    <p>Senior & PWD </p>
                                </div>

                                <div class=" font-black text-[1.2em]">{{ $discount_percent }} %</div>
                            </div>
                            <div class="flex flex-row justify-between">
                                <div class=" font-medium text-[1.2em]">
                                    <p>Discount Amount</p>
                                </div>
                                <div class=" font-black text-[1.2em]">₱
                                    {{ number_format($PWD_Senior_discount_amount, 2) }}
                                </div>
                            </div>
                            <div class="border border-black"></div>
                            <div class="flex flex-row justify-between">
                                <div class=" font-black text-[1.8em]">
                                    <p>Total</p>
                                </div>
                                <div class=" font-black text-[1.8em]">₱ {{ number_format($grandTotal, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($changeTransactionType === 3)
            {{-- credit details --}}
            <div class="grid grid-flow-row">
                {{-- date & time section --}}
                <div class="flex flex-row items-center justify-center gap-8 p-2">
                    <div x-data="{ focusInput() { this.$refs.barcodeInput.focus(); } }">
                        <input type="text" x-ref="barcodeInput" wire.live="barcode" id="barcode"
                            style="opacity: 0;" autofocus x-on:keydown.window.prevent.ctrl.0="focusInput()"
                            wire:model.live="barcode">
                    </div>
                    <div>
                        <p>Time</p>
                    </div>
                </div>
                {{-- transaction number section --}}
                <div class="border border-black"></div>

                <div class="flex flex-col p-2">
                    <div>

                        <label for="credit_id" class="block mb-1 font-medium text-[1.6em] text-gray-900 ">Return No.
                        </label>

                        {{-- @if (empty($returnNo)) --}}
                        <div class="relative w-1/2">

                            <input wire:model.live.debounce.300ms='searchReturnNo' type="search" list="returnList"
                                class="w-full p-2 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(143,143,143)] placeholder-[rgb(101,101,101)] text-[rgb(53,53,53)] rounded-md cursor-pointer text-sm bg-[rgb(242,242,242)]"
                                placeholder="Search Return No." required="">

                        </div>
                        {{-- @if (!empty($searchCustomer))
                                <div
                                    class="fixed max-h-[400px] z-99 h-fit rounded-lg overflow-y-scroll bg-[rgb(75,75,75)]">
                                    @foreach ($credit_customers as $credit_customer)
                                        <ul wire:click="selectCustomer({{ $credit_customer->id }})"
                                            class="w-full px-4 py-2 transition-all  justify-between duration-100 ease-in-out text-white cursor-pointer hover:bg-[rgb(233,72,84)] h-fit">

                                            <li class="flex items-start justify-between">
                                                <!-- Item details on the left side -->
                                                <div
                                                    class="text-[0.8em] w-full gap-4 justify-between flex flex-row text-wrap">
                                                    <p class="font-medium">
                                                        {{ $credit_customer->firstname . ' ' . ($credit_customer->middlename ?? '') . ' ' . $credit_customer->lastname }}
                                                    </p>
                                                    @foreach ($credit_customer->creditJoin as $credit)
                                                        @if ($credit->status != 'Fully paid' && !$credit->transactionJoin)
                                                            <p class="italic font-thin">
                                                                {{ $credit->credit_number }}
                                                            </p>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            @endif --}}
                        {{-- @endgitif --}}
                        <div class="flex flex-col">
                            <div class="flex flex-col gap-2 mb-2">
                                <div class="flex flex-row items-center gap-6 ">
                                    <div class=" font-medium text-[1.2em]">Return Credit:
                                        {{ $senior_pwd_id }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="grid grid-flow-row">
                {{-- date & time section --}}
                <div class="flex flex-row items-center justify-center gap-8 p-2">
                    <div x-data="{ focusInput() { this.$refs.barcodeInput.focus(); } }">
                        <input type="text" x-ref="barcodeInput" wire.live="barcode" style="opacity: 0;" autofocus
                            x-on:keydown.window.prevent.ctrl.0="focusInput()" wire:model.live="barcode">
                    </div>
                    <div>
                        <p class="italic font-medium ">Time</p>
                    </div>
                </div>
                <div class="border border-black"></div>
                <div class="flex flex-col p-2">
                    <p class="text-[1.2em] font-bold">Transaction No.</p>
                    <p class="self-center text-[1.8em] italic font-black">{{ $transaction_number }}</p>
                </div>
                <div class="flex flex-row items-center">
                    <div class="w-full ">
                        <div class="border border-black "></div>
                    </div>
                    <div class="m-1">
                        <p class=" font-medium text-[1em]">Discount</p>
                    </div>
                    <div class="w-full">
                        <div class="border border-black "></div>
                    </div>
                </div>
                <div class="flex flex-col gap-2 p-2 mb-2">
                    <div class="flex flex-row items-center gap-6">
                        <div class=" font-medium text-[1.2em]">Discount Type: {{ $discount_type }}</div>
                    </div>
                    <div class="flex flex-row items-center gap-6 ">
                        <div class=" font-medium text-[1.2em]">Customer Name: {{ $customer_name }}</div>
                    </div>
                    <div class="flex flex-row items-center gap-6 ">
                        <div class=" font-medium text-[1.2em]">ID No.: {{ $senior_pwd_id }}</div>
                    </div>
                </div>
                <div class="border border-black "></div>
                <div class="flex flex-col h-full gap-2 p-2 justify-evenly">
                    <div class="flex flex-row justify-between">
                        <div class=" font-medium text-[1.2em]">
                            <p>Tax Amount</p>
                        </div>
                        <div class=" font-black text-[1.2em]">₱ {{ number_format($totalVat, 2) }}</div>
                    </div>
                    <div class="border border-black "></div>
                    <div class="flex flex-row justify-between">
                        <div class=" font-black text-[1.8em]">
                            <p>Subtotal</p>
                        </div>
                        <div class=" font-black text-[1.8em]">₱ {{ number_format($subtotal, 2) }}</div>
                    </div>
                    <div class="flex flex-row justify-between">
                        <div class=" font-medium text-[1.2em]">
                            <p>Senior & PWD </p>
                        </div>
                        <div class=" font-black text-[1.2em]">{{ $discount_percent }} %</div>
                    </div>
                    <div class="flex flex-row justify-between">
                        <div class=" font-medium text-[1.2em]">
                            <p>Discount Amount</p>
                        </div>
                        <div class=" font-black text-[1.2em]">₱ {{ number_format($PWD_Senior_discount_amount, 2) }}
                        </div>
                    </div>
                    <div class="border border-black "></div>
                    <div class="flex flex-row justify-between">
                        <div class=" font-black text-[1.8em]">
                            <p>Total</p>
                        </div>
                        <div class=" font-black text-[1.8em]">₱ {{ number_format($grandTotal, 2) }}</div>
                    </div>
                    <div class="flex flex-row justify-between">
                        <div class=" font-medium text-[1.2em]">
                            <p>Tendered Amount</p>
                        </div>
                        <div class=" font-black text-[1.2em]">₱ {{ number_format($tendered_amount, 2) }}</div>
                    </div>
                    <div class="border border-black "></div>
                    <div class="flex flex-row justify-between">
                        <div class=" font-black text-green-900 text-[2.4em]">
                            <p>Change</p>
                        </div>
                        <div class=" font-black text-[2em]">₱ {{ number_format($change, 2) }}</div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div x-show="showChangeQuantityForm" x-data="{ showChangeQuantityForm: @entangle('showChangeQuantityForm') }">
        @livewire('components.sales.change-quantity-form')
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
@script
    <script>
        Livewire.on('barcode_focus', () => {
            document.getElementById('barcode').focus();
        });
    </script>
@endscript
