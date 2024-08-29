<div>
    <div>
        @livewire('components.logout')
    </div>
    <div class="grid grid-flow-col grid-cols-3 p-[28px]">
        <div class="flex flex-col col-span-2">
            <div class="flex flex-row justify-between items-center gap-4 pb-[28px]">
                <div class="w-2/4">
                    <input wire:model.live.debounce.300ms='search' type="text" list="itemList"
                        class="px-4 py-4 border outline-none rounded-md border-[rgb(143,143,143)] w-full">

                    @if (!empty($search))
                        <div>
                            @foreach ($items as $item)
                                <ul wire:click="selectItem({{ $item->id }})" class="cursor-pointer">
                                    <span>{{ $item->item_name }} ({{ $item->barcode }})</span>
                                    <span>{{ $item->item_description }}</span>
                                </ul>
                            @endforeach


                        </div>
                    @endif
                </div>
                <div class="flex flex-row justify-end gap-4">
                    <div>
                        <button class="px-6 py-4 bg-blue-100">Sales</button>
                    </div>
                    <div>
                        <button class="px-6 py-4 bg-green-100">New Sales</button>
                    </div>
                    <div>
                        <button class="px-6 py-4 bg-yellow-100">Transaction History</button>
                    </div>
                </div>
            </div>
            <div class="border border-black ">
                {{-- //* tablea area --}}
                <div class="overflow-x-auto overflow-y-scroll scroll h-[550px] ">

                    <table class="w-full h-10 text-sm text-left scroll no-scrollbar">

                        {{-- //* table header --}}
                        <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                            <tr class=" text-nowrap">

                                {{-- //* # count --}}
                                <th wire:click="sortByColumn('created_at')" scope="col"
                                    class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                                    <div class="flex items-center">

                                        <p>#</p>

                                    </div>
                                </th>

                                {{-- //* item name --}}
                                <th scope="col" class="px-4 py-3 text-center">Item Name</th>

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
                        <tbody>
                            @foreach ($selectedItems as $index => $selectedItem)
                                <tr wire:click="getIndex({{ $index }})"
                                    class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">

                                    <th scope="row"
                                        class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                        {{ $index + 1 }}
                                    </th>

                                    <th scope="row"
                                        class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                        {{ $selectedItem['item_name'] }}
                                    </th>

                                    <th scope="row"
                                        class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                        {{ $selectedItem['vat'] }}
                                    </th>

                                    <th scope="row"
                                        class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                        {{ $selectedItem['quantity'] }}
                                    </th>

                                    <th scope="row"
                                        class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                        {{ $selectedItem['selling_price'] }}
                                    </th>

                                    <th scope="row"
                                        class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
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
                                <div class="py-4 text-center bg-slate-400 text-nowrap">
                                    <button wire:click="setQuantity" class="px-8 py-2 ">
                                        Quantity
                                    </button>
                                </div>
                                <div class="py-4 text-center bg-blue-400 text-nowrap">
                                    <button wire:click="removeItem" class="px-8 py-2 ">
                                        Remove Item
                                    </button>
                                </div>
                            </div>
                            <div class="w-full py-4 text-center bg-orange-400 text-nowrap">
                                <button class="px-8 py-2 ">
                                    Cancel Transaction
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 ">
                            <div class="py-4 text-center bg-indigo-400 text-nowrap">
                                <button class="px-8 py-2 ">Wholesale</button>
                            </div>
                            <div class="py-4 text-center bg-violet-400 text-nowrap">
                                <button class="px-8 py-2 ">
                                    Discount
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 ">
                            <div class="flex flex-row gap-4">
                                <div class="py-4 text-center bg-pink-400 text-nowrap">
                                    <button class="px-8 py-2 ">Return</button>
                                </div>
                                <div class="py-4 text-center bg-yellow-400 text-nowrap">
                                    <button class="px-8 py-2 ">Pay</button>
                                </div>
                            </div>
                            <div class="py-4 text-center bg-sky-400 text-nowrap">
                                <button class="px-8 py-2 ">
                                    Void Transaction
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center justify-center w-full font-black bg-green-400 p-auto">
                            <div class="text-center bg-green-400 text-nowrap">
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
                        <p>123412321312</p>
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
                        <div class=" font-black text-[2em]">₱ 0.00</div>
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
                        <div class=" font-black text-[2em]">₱ 0.00</div>
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
    </div>
</div>
