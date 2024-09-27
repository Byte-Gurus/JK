{{-- // --}}
<div class="relative my-[3vh] rounded-lg" x-cloak>

    <div class="flex flex-col ">
        <div
            class="flex flex-row items-center border leading-none border-[rgb(53,53,53)] justify-between gap-4 p-4 text-nowrap mb-4">

            <div class="flex flex-col w-full gap-6">
                <div class="flex flex-row items-center justify-center w-full gap-16">

                    <div class="flex flex-col gap-1">
                        <div>
                            <p>
                                Item Name</p>
                        </div>
                        <div class="flex flex-row items-center gap-2">
                            <h1 class="text-[1.6em] font-black text-center">{{ $item_name }}</h1>
                            <div class="text-[1em]">-</div>
                            <h2 class="text-[1.6em] text-center">{{ $item_description }}</h2>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <div>
                            <p>
                                Selling Price (₱)</p>
                        </div>
                        <div class="flex flex-row items-center justify-center gap-2">
                            <h1 class="text-[1.6em] font-black text-center">{{ $selling_price }}</h1>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row justify-between mx-8">

                    <div class="flex flex-col gap-1">
                        <div>
                            <p>
                                Expiration Date</p>
                        </div>
                        <div class="flex flex-row items-center gap-2">
                            <h1 class="text-[1.2em] font-black text-center">
                                @if ($expiration_date)
                                    {{ \Carbon\Carbon::parse($expiration_date)->format(' M d Y ') }}
                                @else
                                    N/A
                                @endif
                            </h1>

                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <div>
                            <p>
                                Barcode</p>
                        </div>
                        <div class="flex flex-row items-center gap-2">
                            <h1 class="text-[1.2em] font-black text-center">{{ $barcode }}</h1>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <div>
                            <p>
                                SKU</p>
                        </div>
                        <div class="flex flex-row items-center gap-2">
                            <h1 class="text-[1.2em] font-black text-center">{{ $item_name }}</h1>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1 text-left text-wrap">
                        <div>
                            <p>
                                Supplier</p>
                        </div>
                        <div class="flex flex-row items-center gap-2">
                            <h1 class="text-[1.2em] font-black text-left">{{ $supplier }}</h1>
                        </div>
                    </div>

                </div>
            </div>

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
        </div>
        <div class="relative w-full overflow-hidden border-[rgb(143,143,143)] border bg-white">

            {{-- //* tablea area --}}
            <div class="overflow-x-auto overflow-y-scroll h-[52vh] no-scrollbar scroll">

                <table class="w-full h-10 mb-[108px] overflow-auto text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                        <tr class=" text-nowrap">

                            {{-- //* date --}}
                            <th scope="col" class="px-4 py-3 text-left ">Date & Time</th>

                            {{-- //* remarks --}}
                            <th scope="col" class="px-4 py-3 text-left ">Movements</th>

                            {{-- //* remarks --}}
                            <th scope="col" class="px-4 py-3 text-left textext-nowrap">
                                Operation</th>

                            {{-- //* in quantity --}}
                            <th scope="col" class="px-4 py-3 text-center text-nowrap">In
                                Quantity</th>

                            {{-- //* value --}}
                            <th scope="col" class="px-4 py-3 text-center textext-nowrap">
                                Value (₱)</th>

                            {{-- //* out quantity --}}
                            <th scope="col" class="px-4 py-3 text-center text-nowrap">Out
                                Quantity</th>

                            {{-- //* value --}}
                            <th scope="col" class="px-4 py-3 text-center text-nowrap textext-nowrap">Value
                                (₱)</th>

                            {{-- //* quantity balance --}}
                            <th scope="col" class="px-4 py-3 text-center text-nowrap">
                                Quantity Balance</th>

                            {{-- //* value --}}
                            <th scope="col" class="px-4 py-3 text-center text-nowrap">Value (₱)</th>
                        </tr>
                    </thead>

                    {{-- //* table body --}}

                    <tbody>

                        @foreach ($stock_cards as $stock_card)
                            <tr class="transition duration-75 ease-in border-b hover:bg-gray-100 index:bg-red-400">
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 border-r-2 text-md whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($stock_card['created_at'])->format(' M d Y h:i A') }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 border-r-2 text-md whitespace-nowrap">
                                    {{ $stock_card['movement_type'] }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 border-r-4 border-black text-md whitespace-nowrap">
                                    {{ $stock_card['operation'] }}
                                </th>

                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 border-r-2 text-md whitespace-nowrap">
                                    {{ $stock_card['in_quantity'] }}
                                </th>

                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 border-r-4 border-black text-md whitespace-nowrap">
                                    {{ number_format($stock_card['in_value'], 2) }}
                                </th>

                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 border-r-2 text-md whitespace-nowrap">
                                    {{ $stock_card['out_quantity'] }}
                                </th>

                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 border-r-4 border-black text-md whitespace-nowrap">
                                    {{ number_format($stock_card['out_value'], 2) }}
                                </th>

                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 border-r-2 text-md whitespace-nowrap">
                                    {{ $stock_card['quantity_balance'] }}
                                </th>

                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                    {{ number_format($stock_card['value'], 2) }}
                                </th>
                            </tr>
                        @endforeach

                    </tbody>


                </table>
            </div>
        </div>
        <div class="absolute bottom-0 w-full">
            <table class="w-full text-sm text-left">
                <thead>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row"
                            class=" w-[180px] rounded-tl-full bg-[rgb(53,53,53)] py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                        </th>
                        <th scope="row"
                            class=" w-[124px] bg-[rgb(53,53,53)] py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                        </th>
                        <th scope="row"
                            class=" w-[110px] bg-[rgb(53,53,53)] font-black text-[1.2em] py-4 text-center text-white border-black border-r-4 text-md whitespace-nowrap">
                            T o t a l
                        </th>
                        <th scope="row"
                            class=" w-[122px] font-black py-4 bg-orange-50 text-center border-t border-r text-gray-900 border-b border-black text-md whitespace-nowrap">
                            {{ $total_in_quantity }}
                        </th>
                        <th scope="row"
                            class="w-[100px]  py-4 font-black text-center bg-orange-50 border-t text-gray-900 border-r-4 border-b border-black text-md whitespace-nowrap">
                            {{ number_format($total_in_value, 2) }}
                        </th>
                        <th scope="row"
                            class=" w-[137.63px]  py-4 font-black bg-orange-50 border-r border-t text-center text-gray-900 border-black border-b text-md whitespace-nowrap">
                            {{ $total_out_quantity }}
                        </th>
                        <th scope="row"
                            class=" w-[99.5px] py-4 font-black text-center bg-orange-50 border-t text-gray-900 border-r-4 border-black border-b text-md whitespace-nowrap">
                            {{ number_format($total_out_value, 2) }}
                        </th>
                        <th scope="row"
                            class=" w-[172.17px] bg-[rgb(53,53,53)] py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                        </th>
                        <th scope="row"
                            class=" w-[100.72px] rounded-tr-full bg-[rgb(53,53,53)] py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
