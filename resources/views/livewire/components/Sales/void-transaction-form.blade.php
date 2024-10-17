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
            <div class="relative p-2 rounded-l-2xl bg-[rgb(37,13,48)]">
                <div class="flex flex-row items-center gap-2 text-white ">
                    <p class=" text-[1em] italic  font-medium">Void No.</p>
                    <p class=" text-[1.2em] font-black">{{ $void_number }}</p>
                </div>
            </div>

        </div>
        {{-- //* tablea area --}}
        <div class=" h-fit">

            <table class="w-full text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] top-0">

                    <tr class=" text-nowrap">

                        {{-- //* total --}}
                        <th scope="col" class="px-4 py-1 text-center">Total (₱)</th>
                        {{-- //* total --}}
                        <th scope="col" class="px-4 py-1 text-center">Discount Amount (₱)</th>

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
                        <th scope="row"
                            class="px-4 py-1 font-black text-center text-gray-900 text-md whitespace-nowrap ">
                            {{ number_format($total_amount, 2) }}
                        </th>
                        <th scope="row"
                            class="px-4 py-1 font-black text-center text-gray-900 text-md whitespace-nowrap ">
                            {{ number_format($discount_amount, 2) }}
                        </th>
                        <th scope="row"
                            class="px-4 py-1 font-black text-center text-gray-900 text-md whitespace-nowrap ">
                            {{ $transaction_type }}
                        </th>
                        <th scope="row"
                            class="px-4 py-1 font-black text-center text-gray-900 text-md whitespace-nowrap ">
                            {{ $payment_method }}
                        </th>
                        <th scope="row"
                            class="px-4 py-1 italic font-black text-center text-left-900 text-md whitespace-nowrap ">
                            {{ $reference_number }}
                        </th>
                        <th scope="row"
                            class="px-4 py-1 font-black text-center text-gray-900 text-md whitespace-nowrap ">
                            {{ \Carbon\Carbon::parse($transaction_date)->format(' M d Y h:i A') }}
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex flex-col">

        <div class="flex flex-row gap-4 justify-end w-full mb-[3vh]">
            <button type="button" wire:click="sendtransaction()" x-on:click='$wire.displayVoidTransactionFormModal()'
                class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,136,136)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,85,85)]">
                Void Whole Transaction
            </button>
            @if (!$toVoid_info || $this->allVoidNull())
                <button type="button" disable
                    class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(142,157,137)] text-[rgb(53,53,53)] border rounded-md ">
                    Void Selected Item/s
                </button>
            @else
                <button type="button" wire:click="voidSelectedItem()"
                    class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(158,255,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out"
                    wire:click="return">
                    Void Selected Item/s
                </button>
            @endif

        </div>
        <div class="overflow-x-auto overflow-y-scroll scroll no-scrollbar border border-[rgb(53,53,53)] h-[35vh]">

            <table class="w-full text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0">

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
                        <th scope="col" class="px-4 py-3 text-right">Unit Price (₱)</th>

                        {{-- //* quantity --}}
                        <th scope="col" class="px-4 py-3 text-center">Quantity</th>

                        {{-- //* wholesale --}}
                        <th scope="col" class="px-4 py-3 text-right">Wholesale Amount (₱)</th>

                        {{-- //* subtotal --}}
                        <th scope="col" class="px-4 py-3 text-right">Subtotal (₱)</th>

                        {{-- //* operation --}}
                        <th scope="col" class="px-4 py-3 text-center">Reason</th>

                        {{-- //* operation --}}
                        <th scope="col" class="px-4 py-3 text-center"></th>

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
                                class="px-4 py-4 font-medium text-right text-gray-900 whitespace-nowrap ">
                                {{ number_format($transactionDetail['item_price'], 2) }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $transactionDetail['item_quantity'] }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-right text-gray-900 text-md whitespace-nowrap ">
                                @if (isset($transactionDetail['discount_id']) && $transactionDetail['discount_id'] == 3)
                                    {{ number_format(
                                        $transactionDetail['item_price'] -
                                            $transactionDetail['item_price'] * ($transactionDetail['discountJoin']['percentage'] / 100),
                                        2,
                                    ) }}
                                @else
                                    0.00
                                @endif
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-right text-gray-900 text-md whitespace-nowrap ">
                                {{ number_format($transactionDetail['item_subtotal'], 2) }}
                            </th>

                            <th scope="row"
                                class="row-span-2 px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">

                                <select id="status" wire:model.live="reason.{{ $index }}"
                                    class=" bg-[rgb(245,245,245)] border border-[rgb(143,143,143)] text-gray-900 text-sm text-center rounded-md w-fit p-2.5 ">
                                    <option value="" selected>Set your Reason</option>
                                    <option value="Cashier Error">Cashier Error</option>
                                    <option value="System Error">System Error</option>
                                </select>

                                @error("reason.$index")
                                    <span
                                        class="mt-2 font-medium text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                                @enderror
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                @if (isset($reason[$index]) && $reason[$index])
                                    <input type="checkbox"
                                        class="w-6 h-6 text-red-300 ease-linear rounded-full transition-allduration-100 hover:bg-red-400 hover:text-red-600"
                                        wire:change="getCheckedItem($event.target.checked, {{ $index }}, {{ $transactionDetail->id }})">
                                    @error("checkedItem.$index")
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
            class="flex flex-col justify-around row-span-1 gap-1 px-4 py-2 bg-orange-100 border border-black text-wrap rounded-b-2xl">

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
                    <p class=" text-[1.2em] font-black">{{ number_format($void_total_amount, 2) }}</p>
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
    <div x-show="showVoidTransactionFormModal" x-data="{ showVoidTransactionFormModal: @entangle('showVoidTransactionFormModal') }">
        @livewire('components.Sales.void-transaction-form-modal')
    </div>
    <div x-show="showSalesAdminLoginForm" x-data="{ showSalesAdminLoginForm: @entangle('showSalesAdminLoginForm') }">
        @livewire('components.Sales.sales-admin-login-form')
    </div>
</div>
