<div x-cloak class="flex flex-col">

    <div class="relative overflow-hidden bg-white border rounded-md border-[rgb(143,143,143)] mb-[18px]">

        {{-- //* filters --}}
        <div class="flex flex-row items-center justify-between py-2 ">

            {{-- //* search filter --}}
            <div class="relative p-2 rounded-r-2xl bg-[rgb(53,53,53)]">
                <div class="flex flex-row items-center gap-2 text-white ">
                    <p class=" text-[1em] italic  font-medium">Transaction No.</p>
                    <p class=" text-[1.2em] font-black">{{ $transaction_number }}</p>
                </div>
            </div>
            <div class="relative p-2 rounded-r-2xl bg-[rgb(53,53,53)]">
                <div class="flex flex-row items-center gap-2 text-white ">
                    <p class=" text-[1em] italic  font-medium">Return No.</p>
                    <p class=" text-[1.2em] font-black">{{ $return_number }}</p>
                </div>
            </div>

        </div>
        {{-- //* tablea area --}}
        <div class="overflow-x-auto overflow-y-scroll scroll h-fit">

            <table class="w-full text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white z-10 uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                    <tr class=" text-nowrap">

                        {{-- //* total --}}
                        <th scope="col" class="px-4 py-3 text-center">Total (₱)</th>

                        {{-- transaction type --}}
                        <th scope="col" class="px-4 py-3 text-center">Transaction type</th>

                        {{-- payment methods --}}
                        <th scope="col" class="px-4 py-3 text-center">Payment method</th>

                        {{-- //* gcash reference no. --}}
                        <th scope="col" class="px-4 py-3 text-center">GCash Reference No.</th>

                        {{-- //* date --}}
                        <th scope="col" class="px-4 py-3 text-center">Date</th>

                    </tr>
                </thead>

                {{-- //* table body --}}
                <tbody>


                    <tr
                        class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">
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
    <div class="flex flex-col">
        <div class="flex justify-end w-full mb-[3vh]">
            <button type="button"
                class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(158,255,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out"
                wire:click="return">
                Confirm
            </button>
        </div>
        <div class="w-full h-[24vh] mb-[3vh] overflow-x-auto overflow-y-scroll border border-black scroll ">

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
                        <th scope="col" class="px-4 py-3 text-center">Item Name</th>

                        {{-- item name --}}
                        <th scope="col" class="px-4 py-3 text-center">Item Description</th>

                        {{-- //* unit price --}}
                        <th scope="col" class="px-4 py-3 text-center">Unit Price (₱)</th>

                        {{-- //* quantity --}}
                        <th scope="col" class="px-4 py-3 text-center">Quantity</th>

                        {{-- //* wholesale --}}
                        <th scope="col" class="px-4 py-3 text-center">Wholesale Amount (₱)</th>

                        {{-- //* subtotal --}}
                        <th scope="col" class="px-4 py-3 text-center">Subtotal (₱)</th>

                        {{-- //* operation --}}
                        <th scope="col" class="px-4 py-3 text-center">Operation</th>

                        {{-- //* description --}}
                        <th scope="col" class="px-4 py-3 text-center">Description</th>

                        {{-- //* return quantity --}}
                        <th scope="col" class="px-4 py-3 text-center">Return quantity</th>
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
                        <th scope="row" class="px-4 py-4 font-medium text-center text-gray-900 whitespace-nowrap ">
                            {{ number_format($transactionDetail['item_price'], 2) }}
                        </th>
                        <th scope="row"
                            class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                            {{ $transactionDetail['item_quantity'] }}
                        </th>


                        <th scope="row"
                            class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                            @if (isset($transactionDetail['discount_id']) && $transactionDetail['discount_id'] == 3)
                                {{ number_format($transactionDetail['item_price'] - $transactionDetail['item_price'] * ($transactionDetail['discountJoin']['percentage'] / 100), 2) }}
                            @else
                                0.00
                            @endif
                        </th>
                        <th scope="row"
                            class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                            {{ number_format($transactionDetail['item_subtotal'], 2) }}
                        </th>

                        <th scope="row"
                            class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">

                            <select id="status" wire:model.live="operation.{{ $index }}"
                                class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm text-center rounded-md block w-full p-2.5 ">
                                <option value="" selected>Set your operation</option>
                                <option value="Refund">Refund</option>
                                <option value="Exchange">Exchange</option>
                            </select>

                            @error("description.$index")
                                <span
                                    class="mt-2 font-medium text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                            @enderror


                        </th>

                        <th scope="row"
                            class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">

                            <select id="status" wire:model.live="description.{{ $index }}"
                                class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-center text-sm rounded-md block w-full p-2.5 ">
                                <option value="" selected>Set your description</option>
                                <option value="Damaged">Damaged</option>
                                <option value="Expired">Expired</option>
                            </select>

                            @error("description.$index")
                                <span
                                    class="mt-2 font-medium text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                            @enderror

                            <!-- Content to display if returnQuantity at the given index is not greater than 0 -->


                        </th>

                        <th scope="row"
                            class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">

                            @if (isset($operation[$index]) && isset($description[$index]) && $operation[$index] && $description[$index])
                                <input type="number"
                                    class=" bg-[rgb(245,245,245)] [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none border border-[rgb(143,143,143)] text-center text-gray-900 text-sm rounded-md block w-full p-2.5"
                                    wire:model.live.debounce.300ms="returnQuantity.{{ $index }}">
                                @error("returnQuantity.$index")
                                    <span
                                        class="mt-2 font-medium text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                                @enderror
                            @endif

                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div
            class="flex flex-col justify-around row-span-1 gap-1 px-4 py-2 bg-orange-200 border border-black text-wrap rounded-b-2xl">

            <div class="flex flex-row justify-between">
                <div>
                    <p class=" text-[1.2em] font-medium">Current Total Amount</p>
                </div>
                <div>
                    {{ number_format($total_amount, 2) }}
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
            <div class="flex flex-row justify-between">
                <div>
                    <p class=" text-[1.6em] font-medium">Current Tax Amount</p>
                </div>
                <div>
                    <p class=" text-[1.6em] font-black">{{ number_format($current_tax_amount, 2) }}</p>
                </div>
            </div>
            <div class="flex flex-row justify-between">
                <div>
                    <p class=" text-[1.6em] font-medium">Retuned Tax Amount</p>
                </div>
                <div>
                    <p class=" text-[1.6em] font-black">{{ number_format($return_vat_amount, 2) }}</p>
                </div>
            </div>
            <div class="flex flex-row justify-between">
                <div>
                    <p class=" text-[1.6em] font-medium">New Tax Amount</p>
                </div>
                <div>
                    <p class=" text-[1.6em] font-black">
                        {{ number_format($current_tax_amount - $return_vat_amount, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div x-show="showSalesAdminLoginForm" x-data="{ showSalesAdminLoginForm: @entangle('showSalesAdminLoginForm') }">
        @livewire('components.Sales.sales-admin-login-form')
    </div>
</div>
