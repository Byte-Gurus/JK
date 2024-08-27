{{-- // --}}
<div class="relative">
    <div class="flex flex-col h-[655px] gap-4 ">
        <div class="flex flex-row items-center border border-[rgb(53,53,53)] justify-between gap-4 p-6 text-nowrap">
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
        <div class="relative w-full overflow-hidden border-[rgb(143,143,143)] border bg-white rounded-b-lg">

            {{-- //* tablea area --}}
            <div class="h-[680px] pb-[136px] overflow-x-auto overflow-y-scroll  no-scrollbar scroll">

                <table class="w-full overflow-auto text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                        <tr class=" text-nowrap">

                            {{-- //* date --}}
                            <th scope="col" class="px-4 py-3 text-left">Date</th>

                            {{-- //* remarks --}}
                            <th scope="col" class="py-3 text-left">Movements</th>

                            {{-- //* remarks --}}
                            <th scope="col" class="py-3 text-left">Operation</th>

                            {{-- //* in quantity --}}
                            <th scope="col" class="py-3 text-center text-nowrap">In Quantity</th>

                            {{-- //* value --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Value (₱)</th>

                            {{-- //* out quantity --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Out Quantity</th>

                            {{-- //* value --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Value (₱)</th>

                            {{-- //* quantity balance --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Quantity Balance</th>

                            {{-- //* value --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Value (₱)</th>
                        </tr>
                    </thead>

                    {{-- //* table body --}}

                    <tbody>

                        @php
                            $quantity_balance = 0;
                            $value = 0; // Initial balance, or retrieve the initial stock quantity if applicable
                        @endphp

                        @foreach ($stock_cards as $index => $stock_card)
                            @php
                                if ($stock_card->operation === 'Stock In') {
                                    // Increase balance for Stock In
                                    $quantity_balance += $stock_card->inventoryJoin->stock_in_quantity;
                                    $value = $quantity_balance * $stock_card->inventoryJoin->selling_price;
                                } elseif ($stock_card->operation === 'Add') {
                                    // Increase balance for Add
                                    $quantity_balance += $stock_card->adjustmentJoin->adjusted_quantity;
                                    $value =
                                        $quantity_balance * $stock_card->adjustmentJoin->inventoryJoin->selling_price;
                                } elseif ($stock_card->operation === 'Stock Out') {
                                    // Decrease balance for Stock Out
                                    $quantity_balance -= null;
                                } elseif ($stock_card->operation === 'Deduct') {
                                    // Decrease balance for Deduct
                                    $quantity_balance -= $stock_card->adjustmentJoin->adjusted_quantity;
                                    $value =
                                        $quantity_balance * $stock_card->adjustmentJoin->inventoryJoin->selling_price;
                                }

                            @endphp

                            <tr
                                class="border-b hover:bg-gray-100 border-[rgb(207,207,207)] transition ease-in duration-75 index:bg-red-400">

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($stock_card['created_at'])->format('d-m-y h:i A') }}
                                </th>

                                <th scope="row"
                                    class="py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                    {{ $stock_card->movement_type }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">

                                    {{ $stock_card->operation }}

                                </th>

                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                    @if ($stock_card->operation === 'Stock In')
                                        {{ $stock_card->inventoryJoin->stock_in_quantity }}
                                    @elseif ($stock_card->operation === 'Add')
                                        {{ $stock_card->adjustmentJoin->adjusted_quantity }}
                                    @endif
                                </th>

                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                    @if ($stock_card->operation === 'Stock In')
                                        {{ $stock_card->inventoryJoin->current_stock_quantity * $stock_card->inventoryJoin->selling_price }}
                                    @elseif ($stock_card->operation === 'Add')
                                        {{ $stock_card->adjustmentJoin->inventoryJoin->current_stock_quantity * $stock_card->adjustmentJoin->inventoryJoin->selling_price }}
                                    @endif
                                </th>

                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                    @if ($stock_card->operation === 'Stock Out')
                                        {{ $stock_card->inventoryJoin->current_stock_quantity }}
                                    @elseif ($stock_card->operation === 'Deduct')
                                        {{ $stock_card->adjustmentJoin->adjusted_quantity }}
                                    @endif
                                </th>


                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                    @if ($stock_card->operation === 'Stock Out')
                                        <p>SAle</p>
                                    @elseif ($stock_card->operation === 'Deduct')
                                        {{ $stock_card->adjustmentJoin->adjusted_quantity * $stock_card->adjustmentJoin->inventoryJoin->selling_price }}
                                    @endif
                                </th>

                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                    {{ $quantity_balance }}

                                </th>
                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                    {{ $value }}

                                </th>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
