<div x-cloak class=" h-[90vh] p-[3vh]">
    <div class=" flex flex-row justify-between mb-[3vh]">
        <div>
            <p class="text-[2em] font-black ">Transaction History</p>
        </div>
        <div>
            <button x-on:click="$wire.returnToSalesTransaction()"
                class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out">Return</button>
        </div>
    </div>
    <div class="relative overflow-hidden bg-white mb-[3vh]">

        {{-- //* filters --}}
        <div class="flex flex-row items-center justify-between mb-[3vh]">

            {{-- //* search filter --}}
            <div class="relative w-1/2 ">

                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black " fill="none" viewBox="0 0 24 24"
                        strokeWidth={1.5} stroke="currentColor" className="size-6">
                        <path strokeLinecap="round" strokeLinejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>

                <input type="text" wire:model.live.debounce.100ms="search"
                    class="w-2/3 p-4 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-[rgb(101,101,101)] text-[rgb(53,53,53)] rounded-sm cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Search by Transaction No. or Sales Invoice No." required="" />
            </div>

            <div class="flex flex-row items-center justify-between gap-4">
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
                <div class="flex flex-row items-center gap-4 mb-4">

                    <div class="flex flex-col gap-1">

                        <label class="text-sm font-medium text-left text-gray-900 text-nowrap">Transaction
                            Type:</label>

                        <select wire:model.live="transactionFilter"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md  block p-3 ">
                            <option value="0">All</option>
                            <option value="Sales">Sales</option>
                            <option value="Credit">Credit</option>
                            <option value="Return">Return</option>
                            <option value="Void">Void</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-row items-center gap-4 mb-4">

                    <div class="flex flex-col gap-1">

                        <label class="text-sm font-medium text-left text-gray-900 text-nowrap">Payment
                            Type:</label>

                        <select wire:model.live="paymentFilter"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md  block p-3 ">
                            <option value="0">All</option>
                            <option value="Cash">Cash</option>
                            <option value="GCash">GCash</option>


                        </select>
                    </div>
                </div>
            </div>
        </div>
        {{-- //* tablea area --}}
        <div class="flex-1 overflow-x-auto overflow-y-scroll h-[28vh] border border-black scroll">

            <table class="w-full text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white z-10 uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                    <tr class=" text-nowrap">

                        {{-- //* transaction no --}}
                        <th scope="col" class="px-4 py-3">Transaction No.</th>

                        <th wire:click="sortByColumn('total_amount')" scope="col"
                            class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center">

                                <p>Total (₱)</p>

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </span>

                            </div>
                        </th>

                        {{-- payment --}}
                        <th scope="col" class="px-4 py-3 text-center">Transaction type</th>
                        {{-- payment --}}
                        <th scope="col" class="px-4 py-3 text-center">Payment method</th>

                        {{-- //* gcash reference no. --}}
                        <th scope="col" class="px-4 py-3 text-center">GCash Reference No.</th>

                        {{-- payment --}}
                        <th scope="col" class="px-4 py-3 text-center">Tax Amount</th>

                        <th wire:click="sortByColumn('created_at')" scope="col"
                            class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center">

                                <p>Date & Time</p>

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </span>

                            </div>
                        </th>

                        {{-- payment --}}
                        <th scope="col" class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>

                {{-- //* table body --}}
                {{-- <tr x-data="{ isSelected: false }" :class="isSelected ? 'bg-gray-200' : ''"
                    class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75"
                    @click="isSelected = true; $dispatch('row-selected', {{ $sale->id }})"
                    @row-selected.window="isSelected = ($event.detail === {{ $sale->id }})"> --}}
                    <tbody>

                        @foreach ($transactions as $index => $transaction)
                        <tr wire:click="getTransactionID({{ $transaction->id }}, true )" x-data="{ isSelected: false }"
                            x-on:click=" isSelected = !isSelected " :class="isSelected && ' bg-gray-200'"
                            x-on:click.away="isSelected = false;"
                            class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">
                            <th scope="row"
                                class="px-4 py-4 font-bold text-left text-gray-900 text-md whitespace-nowrap ">
                                @if ($transaction->transaction_type == 'Sales')
                                {{ $transaction['transactionJoin']['transaction_number'] }}
                                @elseif ($transaction->transaction_type == 'Return')
                                {{ $transaction['returnsJoin']['transactionJoin']['transaction_number'] }}
                                @elseif ($transaction->transaction_type == 'Credit')
                                {{ $transaction['creditJoin']['credit_number'] }}
                                @elseif ($transaction->transaction_type == 'Void')
                                {{ $transaction['transactionJoin']['transaction_number'] }}
                                @endif

                               
                            </th>
                            {{-- <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                @if ($sale->transaction_type == 'Sales')
                                {{ number_format($sale->transactionJoin->total_amount, 2) }}
                                @elseif ($sale->transaction_type == 'Return')
                                {{ number_format($sale->returnsJoin->transactionJoin->total_amount, 2) }}
                                @elseif ($sale->transaction_type == 'Credit')
                                {{ number_format($sale->creditJoin->transactionJoin->total_amount, 2) }}
                                @elseif ($sale->transaction_type == 'Void')
                                {{ number_format($sale->transactionJoin->total_amount, 2) }}
                                @endif
                            </th>
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $sale['transaction_type'] }}
                            </th>
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                @if ($sale->transaction_type == 'Sales')
                                {{ $sale['transactionJoin']['paymentJoin']['payment_type'] ?? 'N/A' }}
                                @elseif ($sale->transaction_type == 'Return')
                                {{ $sale['returnsJoin']['transactionJoin']['paymentJoin']['payment_type'] ?? 'N/A' }}
                                @elseif ($sale->transaction_type == 'Credit')
                                'N/A'
                                @elseif ($sale->transaction_type == 'Void')
                                {{ $sale['transactionJoin']['paymentJoin']['payment_type'] ?? 'N/A' }}
                                @endif
                            </th>
                            <th scope="row"
                                class="px-4 py-4 italic font-medium text-center text-left-900 text-md whitespace-nowrap ">
                                @if ($sale->transaction_type == 'Sales')
                                {{ $sale['transactionJoin']['paymentJoin->reference_number'] ?? 'N/A' }}
                                @elseif ($sale->transaction_type == 'Return')
                                {{ $sale['returnsJoin']['transactionJoin']['paymentJoin->reference_number'] ?? 'N/A' }}
                                @elseif ($sale->transaction_type == 'Credit')
                                {{ $sale['creditJoin']['transactionJoin']['paymentJoin->reference_number'] ?? 'N/A' }}
                                @elseif ($sale->transaction_type == 'Void')
                                {{ $sale['transactionJoin']['paymentJoin->reference_number'] ?? 'N/A' }}
                                @endif
                            </th>

                            <th scope="row"
                                class="px-4 py-4 italic font-medium text-center text-left-900 text-md whitespace-nowrap ">
                                @if ($sale->transaction_type == 'Sales')
                                {{ number_format($sale['transactionJoin']['total_vat_amount'], 2) ?? 'N/A' }}
                                @elseif ($sale->transaction_type == 'Return')
                                {{ number_format($sale['returnsJoin']['transactionJoin']['total_vat_amount'], 2) ??
                                'N/A'}}
                                @elseif ($sale->transaction_type == 'Credit')
                                {{ number_format($sale['creditJoin']['transactionJoin']['total_vat_amount'], 2) ??
                                'N/A'}}
                                @elseif ($sale->transaction_type == 'Void')
                                {{ number_format($sale['transactionJoin']['total_vat_amount'], 2) ?? 'N/A' }}
                                @endif
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $sale['created_at']->format(' M d Y h:i A ') }}
                            </th>

                            @if ( $sale->transactionJoin->transaction_type == "Sales")
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-red-900 underline text-md whitespace-nowrap ">
                                <button wire:click="voidTransaction({{ $sale->transaction_id }})" type="button">Void
                                    Transaction</button>
                            </th>
                            @elseif ($sale->transaction_type == 'Return')
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-red-900 underline text-md whitespace-nowrap ">
                                <button wire:click="voidTransaction({{ $sale->returnsJoin->transactionJoin->id }})"
                                    type="button">Void
                                    Transaction</button>
                            </th>
                            @elseif ($sale->transaction_type == 'Credit')
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-red-900 underline text-md whitespace-nowrap ">
                                <button wire:click="voidTransaction({{ $sale->creditJoin->transactionJoin->id }})"
                                    type="button">Void
                                    Transaction</button>
                            </th>
                            @elseif ($sale->transaction_type == 'Void')
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-red-900 underline text-md whitespace-nowrap ">
                                <button wire:click="voidTransaction({{ $sale->transaction_id }})" type="button">Void
                                    Transaction</button>
                            </th>
                            @else
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-red-900 underline text-md whitespace-nowrap ">
                                <button type="button">Void
                                    Transaction</button>
                            </th>
                            @endif --}}



                        </tr>
                        @endforeach

                    </tbody>
            </table>
        </div>
    </div>
    <div class="flex flex-row w-full border border-black rounded-md">
        <div class="w-1/3 border-r border-black ">
            <div class="flex flex-col items-center justify-center px-2">
                <div>
                    <p>Transaction No</p>
                </div>
                <div>
                    <p class=" text-[2em] font-black">{{ $transaction_number }}</p>
                </div>
            </div>
            <div class="border border-black"></div>
            <div class="flex flex-col gap-2 px-6 py-2 overflow-hidden">
                <div class="flex flex-row justify-between">
                    <div>
                        <p class=" text-[1.2em] font-medium">Subtotal</p>
                    </div>
                    <div>
                        <p class=" text-[1.2em] font-black">{{ number_format($subtotal, 2) }}</p>
                    </div>
                </div>
                <div class="flex flex-row justify-between">
                    <div>
                        <p class=" text-[1.2em] font-medium">Discount (%)</p>
                    </div>
                    <div>
                        <p class=" text-[1.2em] font-black">{{ $discount_percent }}</p>
                    </div>
                </div>
                @if ($transaction_type == 'Return')
                <div class="flex flex-row justify-between">
                    <div>
                        <p class=" text-[1.2em] font-medium">Total</p>
                    </div>
                    <div>
                        <p class=" text-[1.2em] font-black">{{ number_format($original_amount, 2) }}</p>
                    </div>
                </div>
                @else
                <div class="flex flex-row justify-between">
                    <div>
                        <p class=" text-[1.2em] font-medium">Total</p>
                    </div>
                    <div>
                        <p class=" text-[1.2em] font-black">{{ number_format($grandTotal, 2) }}</p>
                    </div>
                </div>
                @endif
                <div class="flex flex-row justify-between">
                    <div>
                        <p class=" text-[1.2em] font-medium">Tendered Amount</p>
                    </div>
                    <div>
                        <p class=" text-[1.2em] font-black">{{ number_format($tendered_amount, 2) }}</p>
                    </div>
                </div>
                <div class="border border-black "></div>
                <div class="flex flex-row justify-between">
                    @if ($payment_type != 'GCash' && !is_null($payment_type))
                    <div>
                        <p class=" text-[1.6em] font-medium">Change</p>
                    </div>
                    <div>
                        <p class=" text-[1.6em] font-black">{{ number_format($change, 2) }}</p>
                    </div>
                    @endif
                </div>
                @if ($transaction_type == 'Return')
                <div class="flex flex-row justify-between">
                    <div>
                        <p class=" text-[1.2em] font-medium">Original Amount</p>
                    </div>
                    <div>
                        <p class=" text-[1.2em] font-black">{{ number_format($original_amount, 2) }}</p>
                    </div>
                </div>
                <div class="flex flex-row justify-between">
                    <div>
                        <p class=" text-[1.2em] font-medium">Return Amount</p>
                    </div>
                    <div>
                        <p class=" text-[1.2em] font-black">{{ number_format($return_amount, 2) }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="w-full h-[30vh] overflow-x-auto overflow-y-scroll scroll ">

            <table class="w-full text-sm text-left scroll no-scrollbar">

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
                        <th scope="col" class="px-4 py-3 text-left">Item Name</th>

                        {{-- item name --}}
                        <th scope="col" class="px-4 py-3 text-left">Item Description</th>

                        {{-- item name --}}
                        <th scope="col" class="px-4 py-3 text-left">Status</th>

                        {{-- //* unit price --}}
                        <th scope="col" class="px-4 py-3 text-center">Unit Price (₱)</th>

                        {{-- //* quantity --}}
                        <th scope="col" class="px-4 py-3 text-center">Quantity</th>

                        {{-- //* wholesale --}}
                        <th scope="col" class="px-4 py-3 text-center">Wholesale (₱)</th>

                        {{-- //* amount --}}
                        <th scope="col" class="px-4 py-3 text-center">Subtotal (₱)</th>

                        {{-- //* action --}}
                        <th scope="col" class="px-4 py-3 text-center">Actions</th>

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
                            class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap ">
                            {{ $transactionDetail['status'] }}
                        </th>
                        <th scope="row"
                            class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                            {{ number_format($transactionDetail['item_price'], 2) }}
                        </th>
                        <th scope="row"
                            class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                            {{ $transactionDetail['item_quantity'] }}
                        </th>

                        <th scope="row"
                            class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
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
                            class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                            {{ number_format($transactionDetail['item_subtotal'], 2) }}
                        </th>

                        @if ($transactionDetail->transactionJoin->transaction_type == 'Sales'
                        && $transactionDetail->status == 'Sales' )
                        <th scope="row"
                            class="px-4 py-4 font-medium text-center text-red-900 underline text-md whitespace-nowrap ">
                            <button wire:click="voidTransactionDetails({{ $transactionDetail->id }})"
                                type="button">Void</button>
                        </th>
                        @else
                        <th scope="row"
                            class="px-4 py-4 font-medium text-center text-red-900 underline text-md whitespace-nowrap ">
                            <button type="button">Void</button>
                        </th>
                        @endif

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <div x-show="showSalesAdminLoginForm" x-data="{ showSalesAdminLoginForm: @entangle('showSalesAdminLoginForm') }">
        @livewire('components.Sales.sales-admin-login-form')
    </div>
</div>
