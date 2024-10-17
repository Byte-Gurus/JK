<div>
    <div class="relative overflow-hidden bg-white h-[70vh] border rounded-md border-[rgb(143,143,143)] mb-[18px]">

        {{-- //* filters --}}
        <div class="flex flex-row items-center justify-between py-4 pr-4 ">

            <div class="grid items-center justify-start grid-flow-col grid-rows-2 gap-2 grid-col-3 text-nowrap">

                <div class="flex flex-col gap-1 p-2 pr-4 text-black rounded-r-full">
                    <p class="text-[1em] font-thin text-left w-full">Return Number</p>
                    <p class="text-[1.2em] font-black">{{ $return_number }}</p>
                </div>

                <div class="flex flex-col gap-1 p-2 pr-4 text-black ">
                    <p class="text-[1em] font-thin text-left w-full">Transaction No.</p>
                    <p class="text-[1.2em] font-black">{{ $transaction_number }}</p>
                </div>


                <div class="flex flex-col gap-1 p-2 pr-4 text-black">
                    <p class="text-[1em] font-thin text-left w-full">Transaction Date</p>
                    <p class="text-[1.2em] font-black">{{ $transaction_date }}</p>
                </div>

                <div class="flex flex-col gap-1 p-2 pr-4 text-black">
                    <p class="text-[1em] font-thin text-left w-full">Return Date</p>
                    <p class="text-[1.2em] font-black">{{ $return_date }}</p>
                </div>
                <div class="flex flex-col gap-1 p-2 pr-4 text-black">
                    <p class="text-[1em] font-thin text-left w-full">Original Amount (₱)</p>
                    <p class="text-[1.2em] font-black">{{ number_format($original_amount, 2) }}</p>
                </div>
                <div class="flex flex-col gap-1 p-2 pr-4 text-black">
                    <p class="text-[1em] font-thin text-left w-full">Refund Amount (₱)</p>
                    <p class="text-[1.2em] font-black">{{ number_format($refund_amount, 2) }}</p>
                </div>
                <div class="flex flex-col gap-1 p-2 pr-4 text-black">
                    <p class="text-[1em] font-thin text-left w-full">Exchange Amount (₱)</p>
                    <p class="text-[1.2em] font-black">{{ number_format($exchange_amount, 2) }}</p>
                </div>

                <div class="flex flex-col gap-1 p-2 pr-4 text-black">
                    <p class="text-[1em] font-thin text-left w-full">Return Total Amount (₱)</p>
                    <p class="text-[1.2em] font-black">{{ number_format($return_total_amount, 2) }}</p>
                </div>
                <div class="flex flex-col gap-1 p-2 pr-4 text-black">
                    <p class="text-[1em] font-thin text-left w-full">Current Amount (₱)</p>
                    <p class="text-[1.2em] font-black">{{ number_format($current_amount, 2) }}</p>
                </div>
                <div class="flex flex-col gap-1 p-2 pr-4 text-black">
                    <p class="text-[1em] font-thin text-left w-full">Cashier:</p>
                    <p class="text-[1.2em] font-black">{{ $returnedBy }}</p>
                </div>
                <div class="flex flex-col gap-1 p-2 pr-4 text-black">
                    <p class="text-[1em] font-thin text-left w-full">Approved by:</p>
                    <p class="text-[1.2em] font-black">{{ $approvedBy }}</p>
                </div>
            </div>

            <div class="flex flex-row gap-4">
                <div class="flex flex-row items-center justify-between gap-4">
                    <div class="flex flex-col">
                        <div class="flex flex-col gap-1">

                            <label class="text-sm font-medium text-left text-gray-900 text-nowrap">Description:</label>

                            <select wire:model.live="statusFilter"
                                class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md  block p-3 ">
                                <option value="0">All</option>
                                <option value="Expired">Expired</option>
                                <option value="Damaged">Damaged</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-between gap-4">
                    <div class="flex flex-col">
                        <div class="flex flex-col gap-1">

                            <label class="text-sm font-medium text-left text-gray-900 text-nowrap">Operation:</label>

                            <select wire:model.live="operationFilter"
                                class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md  block p-3 ">
                                <option value="0">All</option>
                                <option value="Refund">Refund</option>
                                <option value="Exchange">Exchange</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto overflow-y-scroll scroll no-scrollbar border border-[rgb(53,53,53)]">

            <table class="w-full text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0">

                    <tr class=" text-nowrap">

                        {{-- //* employee name --}}
                        <th scope="col" class="px-4 py-3 text-left">Barcode</th>

                        {{-- //* employee name --}}
                        <th scope="col" class="px-4 py-3 text-left">SKU</th>

                        {{-- //* employee name --}}
                        <th scope="col" class="px-4 py-3 text-left">Item name</th>

                        {{-- //* employee name --}}
                        <th scope="col" class="px-4 py-3 text-left">Item description</th>

                        {{-- //* employee name --}}
                        <th scope="col" class="px-4 py-3 text-center">Operation</th>

                        {{-- //* unit price --}}
                        <th scope="col" class="px-4 py-3 text-right">Unit Price (₱)</th>
                        {{-- //* unit price --}}
                        <th scope="col" class="px-4 py-3 text-right">Wholesale Price (₱)</th>

                        {{-- //* employee name --}}
                        <th scope="col" class="px-4 py-3 text-center">Return Qty</th>

                        {{-- //* transaction no --}}
                        <th scope="col" class="px-4 py-3 text-right">Item Return Amount (₱)</th>

                        {{-- //* sku --}}
                        <th scope="col" class="px-4 py-3 text-center">description</th>

                    </tr>
                </thead>

                {{-- //* table body --}}
                <tbody>

                    @foreach ($return_details as $return_detail)
                    <tr
                        class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">

                        <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $return_detail->transactionDetailsJoin->itemJoin->barcode }}
                        </th>


                        <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $return_detail->transactionDetailsJoin->inventoryJoin->sku_code }}
                        </th>

                        <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $return_detail->transactionDetailsJoin->itemJoin->item_name }}
                        </th>

                        <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $return_detail->transactionDetailsJoin->itemJoin->item_description }}
                        </th>
                        <th scope="row"
                            class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                            {{ $return_detail->operation }}
                        </th>

                        <th scope="row"
                            class="px-4 py-4 font-medium text-right text-gray-900 text-md whitespace-nowrap ">
                            {{ $return_detail->transactionDetailsJoin->item_price }}
                        </th>

                        <th scope="row"
                            class="px-4 py-4 font-medium text-right text-gray-900 text-md whitespace-nowrap ">
                            @if ($return_detail->transactionDetailsJoin->discount_id == 3)
                            {{ number_format(
                            $return_detail->transactionDetailsJoin->item_price -
                            ($return_detail->transactionDetailsJoin->item_price *
                            $return_detail->transactionDetailsJoin->discountJoin->percentage) /
                            100,
                            2,
                            ) }}
                            @else
                            0.00
                            @endif
                        </th>


                        <th scope="row"
                            class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                            {{ $return_detail->return_quantity }}
                        </th>

                        <th scope="row"
                            class="px-4 py-4 font-medium text-right text-gray-900 text-md whitespace-nowrap ">
                            {{ number_format($return_detail->item_return_amount, 2) }}
                        </th>

                        <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $return_detail->description }}
                        </th>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
