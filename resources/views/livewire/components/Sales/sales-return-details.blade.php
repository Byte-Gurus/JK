<div x-cloak>
    <div class="flex flex-col">

        <div class="relative overflow-hidden bg-white border rounded-md border-[rgb(143,143,143)] mb-[18px]">

            {{-- //* filters --}}
            <div class="flex flex-row items-center justify-between px-4 py-4 ">

                {{-- //* search filter --}}
                <div class="relative w-1/2 ">

                    <p>transaction no.</p>
                </div>
            </div>
            {{-- //* tablea area --}}
            <div class="overflow-x-auto overflow-y-scroll scroll h-fit">

                <table class="w-full text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead class="text-xs text-white z-10 uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                        <tr class=" text-nowrap">

                            {{-- //* transaction no --}}
                            <th scope="col" class="px-4 py-3">Transaction No.</th>

                            {{-- //* total --}}
                            <th scope="col" class="px-4 py-3 text-center">Total (₱)</th>

                            {{-- transaction type --}}
                            <th scope="col" class="px-4 py-3 text-center">Transaction type</th>

                            {{-- payment methods --}}
                            <th scope="col" class="px-4 py-3 text-center">Payment method</th>

                            {{-- //* gcash reference no. --}}
                            <th scope="col" class="px-4 py-3 text-left">GCash Reference No.</th>

                            {{-- //* date --}}
                            <th scope="col" class="px-4 py-3 text-center">Date</th>

                        </tr>
                    </thead>

                    {{-- //* table body --}}
                    <tbody>


                        <tr
                            class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">
                            <th
                                scope="row"class="px-4 py-4 font-bold text-left text-gray-900 text-md whitespace-nowrap ">
                                {{ $transaction_number }}
                            </th>
                            <th
                                scope="row"class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $total_amount }}
                            </th>
                            <th
                                scope="row"class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $transaction_type }}
                            </th>
                            <th
                                scope="row"class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $payment_method }}
                            </th>
                            <th
                                scope="row"class="px-4 py-4 italic font-medium text-center text-left-900 text-md whitespace-nowrap ">
                                {{ $reference_number }}
                            </th>
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $transaction_date }}
                            </th>


                        </tr>


                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex flex-row w-full border border-black rounded-md">
            <div class="w-1/3 border-r border-black ">

                <div class="border border-black"></div>
                <div class="flex flex-col h-full gap-2 px-6 py-2 text-wrap justify-evenly">
                    <div class="flex flex-row justify-between">
                        <div>
                            <p class=" text-[1.2em] font-medium">Current Total Amount</p>
                        </div>
                        <div>
                            {{ $total_amount }}
                        </div>
                    </div>


                    <div class="flex flex-row justify-between">
                        <div>
                            <p class=" text-[1.2em] font-medium">Refund Amount</p>
                        </div>
                        <div>
                            {{-- <p class=" text-[1.2em] font-black">{{ $tendered_amount }}</p> --}}
                        </div>
                    </div>
                    <div class="border border-black "></div>
                    <div class="flex flex-row justify-between">
                        <div>
                            <p class=" text-[1.6em] font-medium">New Total Amount</p>
                        </div>
                        <div>
                            {{-- <p class=" text-[1.6em] font-black">{{ $change }}</p> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full h-[500px] overflow-x-auto overflow-y-scroll scroll ">

                <table class="w-full h-10 text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead class="text-xs text-white z-10 uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                        <tr class=" text-nowrap">

                            {{-- //* transaction no --}}
                            <th scope="col" class="px-4 py-3">#</th>

                            {{-- //* sku --}}
                            <th scope="col" class="px-4 py-3 text-center">SKU</th>

                            {{-- //* barcode --}}
                            <th scope="col" class="px-4 py-3 text-center">Barcode</th>

                            {{-- item name --}}
                            <th scope="col" class="px-4 py-3 text-center">Item Name</th>

                            {{-- item name --}}
                            <th scope="col" class="px-4 py-3 text-center">Item Description</th>

                            {{-- //* unit price --}}
                            <th scope="col" class="px-4 py-3 text-center">Unit Price (₱)</th>

                            {{-- //* quantity --}}
                            <th scope="col" class="px-4 py-3 text-center">Quantity</th>

                            {{-- //* amount --}}
                            <th scope="col" class="px-4 py-3 text-center">Wholesale (₱)</th>

                            {{-- //* amount --}}
                            <th scope="col" class="px-4 py-3 text-center">Subtotal (₱)</th>

                            {{-- //* actionn --}}
                            <th scope="col" class="px-4 py-3 text-center">Action</th>

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
                                    class="px-4 py-4 font-medium text-center text-gray-900 whitespace-nowrap ">
                                    {{ $transactionDetail['inventoryJoin']['selling_price'] }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    {{ $transactionDetail['item_quantity'] }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    {{ $transactionDetail['item_discount_amount'] }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    {{ $transactionDetail['item_subtotal'] }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                    <div
                                        class="flex items-center justify-center px-1 py-1 font-medium text-blue-600 rounded-sm hover:bg-blue-100 ">

                                        <button x-on:click="$wire.displaySalesReturnForm()">

                                            <div class="flex items-center">

                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </span>

                                                <div>
                                                    <p>Return</p>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div>
        <div class="m-[28px]" x-show="showSalesReturnForm" x-data="{ showSalesReturnForm: @entangle('showSalesReturnForm') }">
            @livewire('components.sales.sales-return-form')
        </div>
    </div>
</div>
