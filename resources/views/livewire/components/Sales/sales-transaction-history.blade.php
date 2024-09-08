<div x-cloak>
    <div class="flex flex-col m-[28px]">
        <div class="flex flex-row justify-between mb-[28px]">
            <div>
                <p class="text-[2em] font-black ">Transaction History</p>
            </div>
            <div>
                <button x-on:click="$wire.returnToSalesTransaction()"
                    class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out">Return</button>
            </div>
        </div>
        <div class="relative overflow-hidden bg-white border rounded-md border-[rgb(143,143,143)] mb-[18px]">

            {{-- //* filters --}}
            <div class="flex flex-row items-center justify-between px-4 py-4 ">

                {{-- //* search filter --}}
                <div class="relative w-1/2 ">

                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black " fill="none"
                            viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
                            <path strokeLinecap="round" strokeLinejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>

                    <input type="text" wire:model.live.debounce.100ms = "search"
                        class="w-2/3 p-4 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-[rgb(101,101,101)] text-[rgb(53,53,53)] rounded-sm cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Search by Transaction No. or Sales Invoice No." required="" />
                </div>

                <div class="flex flex-row items-center justify-between gap-4">
                    <div class="flex flex-col">
                        <div class="flex flex-row ">
                            <div class="flex flex-col gap-1">
                                <label class="text-sm font-medium text-gray-900 text-nowrap">Start Date:</label>
                                <input type="date" wire:model.live="startDate"
                                    class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-l-md block p-2.5" />
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-sm font-medium text-gray-900 text-nowrap">End Date:</label>
                                <input type="date" wire:model.live="endDate"
                                    class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-r-md block p-2.5" />
                            </div>
                        </div>
                        <p class="text-[12px] font-light text-center text-gray-600 ">Date Range</p>
                    </div>
                    <div class="flex flex-row items-center gap-4 mb-4">

                        <div class="flex flex-col gap-1">

                            <label class="text-sm font-medium text-left text-gray-900 text-nowrap">Transaction
                                Type:</label>

                            <select wire:model.live="transactionTypeFilter"
                                class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md  block p-3 ">
                                <option value="0">All</option>
                                <option value="Sales">Sales</option>
                                <option value="Credit">Credit</option>
                                <option value="Return">Return</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
            {{-- //* tablea area --}}
            <div class="overflow-x-auto overflow-y-scroll scroll h-[300px]">

                <table class="w-full text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead class="text-xs text-white z-10 uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                        <tr class=" text-nowrap">

                            {{-- //* transaction no --}}
                            <th scope="col" class="px-4 py-3">Transaction No.</th>

                            {{-- //* total --}}
                            <th scope="col" class="px-4 py-3 text-center">Total (₱)</th>

                            {{-- payment --}}
                            <th scope="col" class="px-4 py-3 text-center">Transaction type</th>
                            {{-- payment --}}
                            <th scope="col" class="px-4 py-3 text-center">Payment method</th>

                            {{-- //* gcash reference no. --}}
                            <th scope="col" class="px-4 py-3 text-center">GCash Reference No.</th>

                            {{-- //* date --}}
                            <th scope="col" class="px-4 py-3 text-center">Date</th>

                            {{-- //* time --}}
                            <th scope="col" class="px-4 py-3 text-center">Time</th>


                        </tr>
                    </thead>

                    {{-- //* table body --}}
                    <tbody>

                        @foreach ($sales as $index => $sale)
                            <tr wire:click="getTransactionID({{ $sale->id }}, true )" x-data="{ isSelected: false }"
                                x-on:click=" isSelected = !isSelected " :class="isSelected && ' bg-gray-200'"
                                class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">
                                <th
                                    scope="row"class="px-4 py-4 font-bold text-left text-gray-900 text-md whitespace-nowrap ">
                                    {{ $sale['transaction_number'] }}
                                </th>
                                <th
                                    scope="row"class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    {{ number_format($sale->total_amount, 2) }}
                                </th>
                                <th
                                    scope="row"class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    {{ $sale['transaction_type'] }}
                                </th>
                                <th
                                    scope="row"class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    {{ $sale['paymentJoin']['payment_type'] ?? 'N/A' }}
                                </th>
                                <th
                                    scope="row"class="px-4 py-4 italic font-medium text-center text-left-900 text-md whitespace-nowrap ">
                                    {{ $sale['paymentJoin->reference_number'] ?? 'N/A' }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    {{ $sale['created_at']->format(' M d Y ') }}
                                </th>

                                {{-- //* updated at --}}
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    {{ $sale['created_at']->format('h:i A') }}
                                </th>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex flex-row w-full border border-black rounded-md">
            <div class="w-1/3 border-r border-black ">
                <div class="flex flex-col items-center justify-center px-2">
                    <div>
                        <p>Transaction No</p>
                    </div>
                    <div>
                        <p class=" text-[2em] font-black">{{ $transaction_number }}</p>
                    </div>
                </div>
                <div class="border border-black"></div>
                <div class="flex flex-col gap-2 px-6 py-2 overflow-hidden">
                    <div class="flex flex-row justify-between">
                        <div>
                            <p class=" text-[1.2em] font-medium">Subtotal</p>
                        </div>
                        <div>
                            <p class=" text-[1.2em] font-black">{{ number_format($subtotal, 2) }}</p>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between">
                        <div>
                            <p class=" text-[1.2em] font-medium">Discount (%)</p>
                        </div>
                        <div>
                            <p class=" text-[1.2em] font-black">{{ $discount_percent }}</p>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between">
                        <div>
                            <p class=" text-[1.2em] font-medium">Total</p>
                        </div>
                        <div>
                            <p class=" text-[1.2em] font-black">{{ number_format($grandTotal, 2) }}</p>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between">
                        <div>
                            <p class=" text-[1.2em] font-medium">Tendered Amount</p>
                        </div>
                        <div>
                            <p class=" text-[1.2em] font-black">{{ number_format($tendered_amount, 2) }}</p>
                        </div>
                    </div>
                    <div class="border border-black "></div>
                    <div class="flex flex-row justify-between">
                        @if ($transaction_type != 'Credit')
                            <div>
                                <p class=" text-[1.6em] font-medium">Change</p>
                            </div>
                            <div>
                                <p class=" text-[1.6em] font-black">{{ number_format($change, 2) }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="w-full h-[260px] overflow-x-auto overflow-y-scroll scroll ">

                <table class="w-full h-10 text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead class="text-xs text-white z-10 uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                        <tr class=" text-nowrap">

                            {{-- //* transaction no --}}
                            <th scope="col" class="px-4 py-3">#</th>

                            {{-- //* sku --}}
                            <th scope="col" class="px-4 py-3 text-left">SKU</th>

                            {{-- //* barcode --}}
                            <th scope="col" class="px-4 py-3 text-left">Barcode</th>

                            {{-- item name --}}
                            <th scope="col" class="px-4 py-3 text-left">Item Name</th>

                            {{-- item name --}}
                            <th scope="col" class="px-4 py-3 text-left">Item Description</th>

                            {{-- //* unit price --}}
                            <th scope="col" class="px-4 py-3 text-center">Unit Price (₱)</th>

                            {{-- //* quantity --}}
                            <th scope="col" class="px-4 py-3 text-center">Quantity</th>

                            {{-- //* amount --}}
                            <th scope="col" class="px-4 py-3 text-center">Wholesale (₱)</th>

                            {{-- //* amount --}}
                            <th scope="col" class="px-4 py-3 text-center">Subtotal (₱)</th>

                        </tr>
                    </thead>

                    {{-- //* table body --}}
                    <tbody>

                        @foreach ($transactionDetails as $index => $transactionDetail)
                            <tr
                                class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    {{ $index + 1 }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap ">
                                    {{ $transactionDetail['inventoryJoin']['sku_code'] }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap ">
                                    {{ $transactionDetail['itemJoin']['barcode'] }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap ">
                                    {{ $transactionDetail['itemJoin']['item_name'] }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap ">
                                    {{ $transactionDetail['itemJoin']['item_description'] }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    {{ number_format($transactionDetail['inventoryJoin']['selling_price'], 2) }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    {{ $transactionDetail['item_quantity'] }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    {{ number_format($transactionDetail['item_discount_amount'], 2) }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    {{ number_format($transactionDetail['item_subtotal'], 2) }}
                                </th>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
