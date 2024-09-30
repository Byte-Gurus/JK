<div>
    <div class="relative overflow-hidden bg-white h-[620px] border rounded-md border-[rgb(143,143,143)] mb-[18px]">

        {{-- //* filters --}}
        <div class="flex flex-row items-center justify-between py-4 pr-4 ">

            <div class="flex flex-col gap-4 py-2 pr-4 my-2 text-nowrap">

                <div
                class="flex flex-row items-center gap-6 w-fit p-2 pr-4 bg-[rgb(0,0,0)] shadow-md shadow-[rgb(206,187,255)] text-white rounded-r-full">
                <div>
                    <p class="text-[0.8em] font-thin text-center w-full">Return Number</p>
                </div>
                <div class="flex flex-col gap-2">
                    <p class="text-[1em] font-black">{{ $return_number }}</p>
                </div>
            </div>

                <div
                    class="flex flex-row items-center gap-6 w-fit p-2 pr-4 bg-[rgb(40,23,83)] shadow-md shadow-[rgb(206,187,255)] text-white rounded-r-full">
                    <div>
                        <p class="text-[1em] font-thin text-center w-full">Transaction No.</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <p class="text-[1.2em] font-black">{{ $transaction_number }}</p>
                    </div>
                </div>

                <div class="grid grid-flow-row grid-rows-4 gap-1">

                    <div
                        class="flex flex-row items-center gap-6 w-fit p-2 pr-4 bg-[rgb(0,0,0)] shadow-md shadow-[rgb(206,187,255)] text-white rounded-r-full">
                        <div>
                            <p class="text-[0.8em] font-thin text-center w-full">Transaction Date</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="text-[1em] font-black">{{ $transaction_date }}</p>
                        </div>
                    </div>

                    <div
                        class="flex flex-row items-center gap-6 w-fit p-2 pr-4 bg-[rgb(0,0,0)] shadow-md shadow-[rgb(206,187,255)] text-white rounded-r-full">
                        <div>
                            <p class="text-[0.8em] font-thin text-center w-full">Return Date</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="text-[1em] font-black">{{ $return_date }}</p>
                        </div>
                    </div>
                    <div
                        class="flex flex-row items-center gap-6 w-fit p-2 pr-4 bg-[rgb(0,0,0)] shadow-md shadow-[rgb(206,187,255)] text-white rounded-r-full">
                        <div>
                            <p class="text-[0.8em] font-thin text-center w-full">Original Amount</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="text-[1em] font-black">{{ $orignal_amount }}</p>
                        </div>
                    </div>
                    <div
                        class="flex flex-row items-center gap-6 w-fit p-2 pr-4 bg-[rgb(0,0,0)] shadow-md shadow-[rgb(206,187,255)] text-white rounded-r-full">
                        <div>
                            <p class="text-[0.8em] font-thin text-center w-full">Return Total Amount</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="text-[1em] font-black">{{ $return_total_amount }}</p>
                        </div>
                    </div>
                    <div
                        class="flex flex-row items-center gap-6 w-fit p-2 pr-4 bg-[rgb(0,0,0)] shadow-md shadow-[rgb(206,187,255)] text-white rounded-r-full">
                        <div>
                            <p class="text-[0.8em] font-thin text-center w-full">Current Amount</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="text-[1em] font-black">{{ $current_amount }}</p>
                        </div>
                    </div>
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
        {{-- //* tablea area --}}
        <div class="overflow-x-auto overflow-y-scroll scroll h-[300px]">

            <table class="w-full text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white z-10 uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

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
                        <th scope="col" class="px-4 py-3 text-center">Unit Price</th>

                        {{-- //* employee name --}}
                        <th scope="col" class="px-4 py-3 text-center">return_quantity</th>

                        {{-- //* transaction no --}}
                        <th scope="col" class="px-4 py-3 text-center">item_return_amount</th>

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

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $return_detail->transactionDetailsJoin->item_price }}
                            </th>

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $return_detail->return_quantity }}
                            </th>

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $return_detail->item_return_amount }}
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
