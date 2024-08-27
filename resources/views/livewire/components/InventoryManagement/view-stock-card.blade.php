{{-- // --}}
<div class="relative">
    <div class="flex flex-col h-[655px] ">
        <div class="flex flex-row items-center border border-[rgb(53,53,53)] justify-between gap-4 p-6 text-nowrap mb-4">
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
            <div class="flex flex-row gap-6">
                <div>
                    <h1 class="text-[2em]">{{ $item_name }}</h1>
                    <h2 class="text-[1em] font-black text-center w-full">{{ $item_description }}</h2>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="supplier"
                        class="text-[1.2em]">{{ \Carbon\Carbon::parse($expiration_date)->format('d-m-y') }}</label>
                    <p></p>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="supplier" class="text-[1.2em]">{{ $supplier }}</label>
                    <p></p>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="supplier" class="text-[1.2em]">{{ $barcode }}</label>
                    <p></p>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="supplier" class="text-[1.2em]">{{ $selling_price }}</label>
                    <p></p>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="supplier" class="text-[1.2em]">Date Range</label>
                    <p></p>
                </div>
            </div>
        </div>
        <div class="relative w-full overflow-hidden border-[rgb(143,143,143)] border bg-white">

            {{-- //* tablea area --}}
            <div class="overflow-x-auto overflow-y-scroll h-[520px] no-scrollbar scroll">

                <table class="w-full mb-[56.2px] overflow-auto text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                        <tr class=" text-nowrap">

                            {{-- //* date --}}
                            <th scope="col" class="px-4 py-3 text-left border-r-2 border-black">Date</th>

                            {{-- //* remarks --}}
                            <th scope="col" class="px-4 py-3 text-left border-r-2 border-black">Movements</th>

                            {{-- //* remarks --}}
                            <th scope="col" class="px-4 py-3 text-left border-r-4 border-black textext-nowrap">
                                Operation</th>

                            {{-- //* in quantity --}}
                            <th scope="col" class="px-4 py-3 text-center border-r-2 border-black text-nowrap">In
                                Quantity</th>

                            {{-- //* value --}}
                            <th scope="col" class="px-4 py-3 text-center border-r-4 border-black textext-nowrap">
                                Value (₱)</th>

                            {{-- //* out quantity --}}
                            <th scope="col" class="px-4 py-3 text-center border-r-2 border-black text-nowrap">Out
                                Quantity</th>

                            {{-- //* value --}}
                            <th scope="col"
                                class="px-4 py-3 text-center border-r-4 border-black text-nowrap textext-nowrap">Value
                                (₱)</th>

                            {{-- //* quantity balance --}}
                            <th scope="col" class="px-4 py-3 text-center border-r-2 border-black text-nowrap">
                                Quantity Balance</th>

                            {{-- //* value --}}
                            <th scope="col" class="px-4 py-3 text-center text-nowrap">Value (₱)</th>
                        </tr>
                    </thead>

                    {{-- //* table body --}}

                    <tbody>

                        @foreach ($stock_cards as $stock_card)
                            <tr
                                class="border-b hover:bg-gray-100 border-[rgb(207,207,207)] transition ease-in duration-75 index:bg-red-400">
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 border-r-2 text-md whitespace-nowrap">
                                    {{ $stock_card['created_at'] }}
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
                                    {{ $stock_card['in_value'] }}
                                </th>

                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 border-r-2 text-md whitespace-nowrap">
                                    {{ $stock_card['out_quantity'] }}
                                </th>

                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 border-r-4 border-black text-md whitespace-nowrap">
                                    {{ $stock_card['out_value'] }}
                                </th>

                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 border-r-2 text-md whitespace-nowrap">
                                    {{ $stock_card['quantity_balance'] }}
                                </th>

                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                    {{ $stock_card['value'] }}
                                </th>
                            </tr>
                        @endforeach

                    </tbody>


                </table>
            </div>
        </div>
        <div class="absolute bottom-0 w-full ">
            <table class="w-full text-sm text-left">
                <thead>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row"
                            class=" w-[178.06px] py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                        </th>
                        <th scope="row"
                            class=" w-[120.09px] py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                        </th>
                        <th scope="row"
                            class=" w-[113.47px] font-black text-[1.2em] py-4 text-center text-gray-900 border-black border-r-4 text-md whitespace-nowrap">
                        </th>
                        <th scope="row"
                            class=" w-[123.13px] font-black py-4 bg-orange-50 text-center border-t border-r text-gray-900 border-b border-black text-md whitespace-nowrap">
                            {{ $total_in_quantity }}
                        </th>
                        <th scope="row"
                            class="w-[102.83px]  py-4 font-black text-center bg-orange-50 border-t text-gray-900 border-r-4 border-b border-black text-md whitespace-nowrap">
                            {{ $total_in_value }}
                        </th>
                        <th scope="row"
                            class=" w-[137.63px]  py-4 font-black bg-orange-50 border-r border-t text-center text-gray-900 border-black border-b text-md whitespace-nowrap">
                            {{ $total_out_quantity }}
                        </th>
                        <th scope="row"
                            class=" w-[102.83px] py-4 font-black text-center bg-orange-50 border-t text-gray-900 border-r-4 border-black border-b text-md whitespace-nowrap">
                            {{ $total_out_value }}
                        </th>
                        <th scope="row"
                            class=" w-[172.17px] py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                        </th>
                        <th scope="row"
                            class=" w-[100.72px] py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
