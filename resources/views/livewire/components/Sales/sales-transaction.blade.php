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
                        class="w-full p-4 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-[rgb(101,101,101)] text-[rgb(53,53,53)] rounded-sm cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Search by Item Name or Barcode" required="">
                </div>

                @if (!empty($search))
                    <div class="absolute w-1/3 overflow-y-scroll bg-[rgb(248,248,248)]">
                        @foreach ($items as $item)
                            <ul wire:click="selectItem({{ $item->id }})"
                                class=" w-full p-4 transition-all duration-100 ease-in-out border border-black cursor-pointer hover:bg-[rgb(208,208,208)] h-fit text-nowrap ">
                                <li class="flex flex-row items-center justify-between">
                                    <div class="flex flex-row items-center gap-2">
                                        <div class=" text-[1.2em] font-bold">{{ $item->item_name }}</div>
                                        <div class="font-black text-[1em]">-</div>
                                        <div>{{ $item->item_description }}</div>
                                    </div>
                                    <div class="italic font-black text-[1.2em]">({{ $item->barcode }})</div>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="flex flex-row items-center gap-4 text-nowrap">
                <div>
                    <button class="px-6 py-4 bg-[rgb(254,184,134)] border border-black hover:bg-[rgb(255,151,78)] ease-in-out duration-100 transition-all">Sales</button>
                </div>
                <div>
                    <button class="px-6 py-4 bg-[rgb(166,254,134)] border border-black hover:bg-[rgb(152,255,78)] ease-in-out duration-100 transition-all">New Sales</button>
                </div>
                <div>
                    <button x-on:click="$wire.displaySalesTransactionHistory()"
                        class="px-6 py-4 bg-[rgb(230,254,134)] border border-black hover:bg-[rgb(214,255,49)] ease-in-out duration-100 transition-all">Transaction History</button>
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
<<<<<<< Updated upstream
                            <th scope="col" class="px-4 py-3 text-center">Barcode</th>
                            {{-- //* item name --}}
                            <th scope="col" class="px-4 py-3 text-center">SKU</th>
                            {{-- //* item name --}}
                            <th scope="col" class="px-4 py-3 text-center">Item Name</th>
                            {{-- //* item name --}}
=======
                            <th scope="col" class="py-3 pl-4 pr-2 text-left">Item Name</th>

                            {{-- //* item descrition --}}
>>>>>>> Stashed changes
                            <th scope="col" class="px-4 py-3 text-center">Description</th>

                            {{-- //* vat --}}
                            <th scope="col" class="px-4 py-3 text-center">VAT(₱)</th>

                            {{-- //* quantity --}}
                            <th scope="col" class="px-4 py-3 text-center">Quantity</th>

                            {{-- //* price --}}
                            <th scope="col" class="px-4 py-3 text-center">Price(₱)</th>

                            {{-- //* amount --}}
                            <th scope="col" class="px-4 py-3 text-center">Amount(₱)</th>

                        </tr>
                    </thead>

                    {{-- //* table body --}}
                    <tbody x-data="{ isSelected: false   }">
                        @foreach ($selectedItems as $index => $selectedItem)
                            <tr wire:click="getIndex({{ $index }}, true )"
                                class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">

                                <th scope="row" class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap"
                                    x-on:click=" isSelected = !isSelected " :class="isSelected && ' bg-gray-200'">
                                    {{ $index + 1 }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap "
                                    x-on:click=" isSelected = !isSelected " :class="isSelected && ' bg-gray-200'">
                                    {{ $selectedItem['barcode'] }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap "
                                    x-on:click=" isSelected = !isSelected " :class="isSelected && ' bg-gray-200'">
                                    {{ $selectedItem['sku_code'] }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap "
                                    x-on:click=" isSelected = !isSelected " :class="isSelected && ' bg-gray-200'">
                                    <div class="flex flex-col ">
                                        <div class="text-xl font-black">{{ $selectedItem['item_name'] }}</div>
                                        <div class="flex flex-row gap-2 w-fit">
                                            <div class="text-sm italic font-medium text-[rgb(122,122,122)]">{{ $selectedItem['barcode'] }}</div>
                                            <div class="font-black text-[rgb(80,80,80)]">|</div>
                                            <div class="text-sm italic font-medium text-[rgb(122,122,122)]">{{ $selectedItem['sku_code'] }}</div>
                                        </div>
                                    </div>

                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap"
                                    x-on:click=" isSelected = !isSelected " :class="isSelected && ' bg-gray-200'">
                                    {{ $selectedItem['item_description'] }}
                                </th>
                                <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap "
                                x-on:click=" isSelected = !isSelected " :class="isSelected && ' bg-gray-200'">
                                {{ $selectedItem['item_description'] }}
                            </th>

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap"
                                    x-on:click=" isSelected = !isSelected " :class="isSelected && ' bg-gray-200'">
                                    {{ $selectedItem['vat'] }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap"
                                    x-on:click=" isSelected = !isSelected " :class="isSelected && ' bg-gray-200'">
                                    {{ $selectedItem['quantity'] }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap"
                                    x-on:click=" isSelected = !isSelected " :class="isSelected && ' bg-gray-200'">
                                    {{ $selectedItem['selling_price'] }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap"
                                    x-on:click=" isSelected = !isSelected " :class="isSelected && ' bg-gray-200'">
                                    {{ $selectedItem['total_amount'] }}
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
                        <div class="flex flex-row items-center gap-2">
                            <div class="py-4 text-center bg-[rgb(143,244,251)] hover:bg-[rgb(111,253,255)] border border-black hover:shadow-2xl hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                                <button wire:click="setQuantity" class="px-8 py-2 ">
                                    Quantity
                                </button>
                            </div>
                            <div class="py-4 text-center bg-[rgb(154,143,251)] hover:bg-[rgb(128,111,255)] border border-black hover:shadow-2xl hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                                <button wire:click="removeItem" class="px-8 py-2 ">
                                    Remove Item
                                </button>
                            </div>
                        </div>
                        <div class="py-4 text-center bg-[rgb(251,143,143)] hover:bg-[rgb(255,111,111)] border border-black hover:shadow-2xl hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                            <button class="px-8 py-2 ">
                                Cancel Transaction
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <div class="py-4 text-center bg-[rgb(190,143,251)] hover:bg-[rgb(190,111,255)] border border-black hover:shadow-2xl hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                            <button class="px-8 py-2 ">Wholesale</button>
                        </div>
                        <div class="py-4 text-center bg-[rgb(251,143,206)] hover:bg-[rgb(255,111,209)] border border-black hover:shadow-2xl hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                            <button class="px-8 py-2 ">
                                Discount
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <div class="flex flex-row gap-4">
                            <div class="py-4 text-center bg-[rgb(251,143,242)] hover:bg-[rgb(255,111,231)] border border-black hover:shadow-2xl hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                                <button class="px-8 py-2 ">Return</button>
                            </div>
                            <div class="py-4 text-center bg-[rgb(251,240,143)] hover:bg-[rgb(255,241,111)] border border-black hover:shadow-2xl hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                                <button class="px-8 py-2 ">Pay</button>
                            </div>
                        </div>
                        <div class="py-4 text-center bg-[rgb(38,38,38)] text-white hover:bg-[rgb(0,0,0)] border border-black hover:shadow-2xl hover:translate-y-[-2px] ease-in-out duration-100 transition-all text-nowrap">
                            <button class="px-8 py-2 ">
                                Void Transaction
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center justify-center w-full font-black transition-all duration-100 ease-in-out bg-green-400 border border-black hover:bg-green-500">
                        <div class="text-center text-nowrap">
                            <button>
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-[rgba(241,203,162,0.32)] ml-[28px] border-2 border-[rgb(53,53,53)] text-nowrap rounded-md">
        <div class="flex flex-col ">
            {{-- date & time section --}}
            <div class="flex flex-row items-center justify-center gap-8 p-2">
                <div>
                    <p>Date</p>
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
                    <div class=" font-medium text-[1.6em]">Discount Type</div>
                    <div>icon</div>
                </div>
                <div class="flex flex-row items-center gap-6 ">
                    <div class=" font-medium text-[1.6em]">Customer Name</div>
                    <div>icon</div>
                </div>
                <div class="flex flex-row items-center gap-6 ">
                    <div class=" font-medium text-[1.6em]">ID No.</div>
                    <div>icon</div>
                </div>
            </div>
            <div class="my-2">
                <div class="border border-black"></div>
            </div>
            {{-- ss --}}
            <div class="flex flex-col gap-2 mx-6">
                <div class="flex flex-row justify-between">
                    <div class=" font-medium text-[1.4em]">
                        <p>Vatable Item Price</p>
                    </div>
                    <div class=" font-black text-[1.4em]">₱ 0.00</div>
                </div>
                <div class="flex flex-row justify-between">
                    <div class=" font-medium text-[1.4em]">
                        <p>Non-Vatable Item Price</p>
                    </div>
                    <div class=" font-black text-[1.4em]">₱ 0.00</div>
                </div>
                <div class="w-full my-2">
                    <div class="border border-black"></div>
                </div>
                <div class="flex flex-row justify-between">
                    <div class=" font-black text-[2em]">
                        <p>Subtotal</p>
                    </div>
                    <div class=" font-black text-[2em]">₱ {{ $subtotal }}</div>
                </div>
                <div class="flex flex-row justify-between">
                    <div class=" font-medium text-[1.4em]">
                        <p>Discount (%)</p>
                    </div>
                    <div class=" font-black text-[1.4em]">0</div>
                </div>
                <div class="flex flex-row justify-between">
                    <div class=" font-medium text-[1.4em]">
                        <p>Discount Amount</p>
                    </div>
                    <div class=" font-black text-[1.4em]">₱ 0.00</div>
                </div>
                <div class="w-full my-2">
                    <div class="border border-black"></div>
                </div>
                <div class="flex flex-row justify-between">
                    <div class=" font-black text-[2em]">
                        <p>Total</p>
                    </div>
                    <div class=" font-black text-[2em]">₱ {{ $grandTotal }}</div>
                </div>
                <div class="flex flex-row justify-between">
                    <div class=" font-medium text-[1.4em]">
                        <p>Tendered Amount</p>
                    </div>
                    <div class=" font-black text-[1.4em]">₱ 0.00</div>
                </div>
                <div class="w-full">
                    <div class="border border-black"></div>
                </div>
                <div class="flex flex-row justify-between">
                    <div class=" font-black text-green-900 text-[2.2em]">
                        <p>Change</p>
                    </div>
                    <div class=" font-black text-[2em]">₱ 0.00</div>
                </div>
            </div>
        </div>
    </div>
    <div x-show="showChangeQuantityForm" x-data="{ showChangeQuantityForm: @entangle('showChangeQuantityForm') }">
        @livewire('components.sales.change-quantity-form')
    </div>
</div>
