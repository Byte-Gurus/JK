<div>
    <div class="relative overflow-hidden bg-white h-[620px] border rounded-md border-[rgb(143,143,143)] mb-[18px]">

        {{-- //* filters --}}
        <div class="flex flex-row items-center justify-between px-4 py-4 ">

            {{-- //* search filter --}}
            <div class="relative w-1/2 ">

                {{ $transaction_number }}
                <br>
                {{ $transaction_date }}
                <br>
                {{ $return_date }}
                <br>
                {{ $orignal_amount }}
                <br>
                {{ $return_total_amount }}
                <br>
                {{ $current_amount }}
            </div>

            <div class="flex flex-row items-center justify-between gap-4">
                <div class="flex flex-col">
                    <div class="flex flex-col gap-1">

                        <label class="text-sm font-medium text-left text-gray-900 text-nowrap">Status:</label>

                        <select wire:model.live="statusFilter"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md  block p-3 ">
                            <option value="0">All</option>
                            <option value="Expired">Expired</option>
                            <option value="Damaged">Damaged</option>
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

                        {{-- //* employee name --}}
                        <th scope="col" class="px-4 py-3 text-center">Barcode</th>

                        {{-- //* employee name --}}
                        <th scope="col" class="px-4 py-3 text-center">SKU</th>

                        {{-- //* employee name --}}
                        <th scope="col" class="px-4 py-3 text-center">Item name</th>

                        {{-- //* employee name --}}
                        <th scope="col" class="px-4 py-3 text-center">Item description</th>

                        {{-- //* unit price --}}
                        <th scope="col" class="px-4 py-3 text-center">Unit Price</th>

                        {{-- //* employee name --}}
                        <th scope="col" class="px-4 py-3 text-center">return_quantity</th>

                        {{-- //* transaction no --}}
                        <th scope="col" class="px-4 py-3">item_return_amount</th>

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

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $return_detail->transactionDetailsJoin->inventoryJoin->selling_price }}
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
