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
                                {{ number_format($total_amount, 2) }}
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
                                {{ \Carbon\Carbon::parse($transaction_date)->format(' M d Y h:i A') }}
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
                            {{number_format( $total_amount, 2) }}
                        </div>
                    </div>


                    <div class="flex flex-row justify-between">
                        <div>
                            <p class=" text-[1.2em] font-medium">Refund Amount</p>
                        </div>
                        <div>
                            <p class=" text-[1.2em] font-black">{{ number_format($return_total_amount, 2) }}</p>
                        </div>
                    </div>
                    <div class="border border-black "></div>
                    <div class="flex flex-row justify-between">
                        <div>
                            <p class=" text-[1.6em] font-medium">New Total Amount</p>
                        </div>
                        <div>
                            <p class=" text-[1.6em] font-black">{{ number_format($new_total, 2) }}</p>
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
                            <th scope="col" class="px-4 py-3 text-center">Return quantity</th>

                            {{-- //* actionn --}}
                            <th scope="col" class="px-4 py-3 text-center">Description</th>

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

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    <input type="number" wire:model.live="returnQuantity.{{ $index }}">
                                    @error("returnQuantity.$index")
                                        <span
                                            class="mt-2 font-medium text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                                    @enderror
                                </th>

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    @if (isset($returnQuantity[$index]) && !is_null($returnQuantity[$index]) && $returnQuantity[$index] > 0)
                                        <select id="status" wire:model.live="description.{{ $index }}"
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm rounded-md block w-full p-2.5 ">
                                            <option value="" selected>Set your status</option>
                                            <option value="Damaged">Damaged</option>
                                            <option value="Expired">Expired</option>
                                        </select>

                                        @error("description.$index")
                                            <span
                                                class="mt-2 font-medium text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                                        @enderror
                                    @else
                                        <!-- Content to display if returnQuantity at the given index is not greater than 0 -->
                                    @endif

                                </th>


                            </tr>
                        @endforeach
                    </tbody>
                    <button type="button" wire:click="return">
                        Confirm
                    </button>
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
