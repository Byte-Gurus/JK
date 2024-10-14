<div x-cloak class=" h-[90vh] p-[3vh]">
    <div class=" flex flex-row justify-between mb-[3vh]">
        <div>
            <p class="text-[2em] font-black ">Transaction History</p>
        </div>
        <div class="flex flex-row justify-between gap-4 ">
            <div>
                <button x-on:click="$wire.displayVoidTransaction()"
                    class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(224,180,255)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(181,128,255)] transition-all duration-100 ease-in-out">Void
                    Transaction</button>
            </div>
            <div>
                <button x-on:click="$wire.returnToSalesTransaction()"
                    class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out">Back</button>
            </div>
        </div>
    </div>
    <div class="relative overflow-hidden bg-white mb-[3vh]">

        {{-- //* filters --}}
        <div class="flex flex-row items-center justify-between mb-[3vh]">

            {{-- //* search filter --}}
            <div class="relative w-1/2 ">

                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black " fill="none"
                        viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
                        <path strokeLinecap="round" strokeLinejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>

                <input type="text" wire:model.live.debounce.100ms="search"
                    class="w-2/3 p-4 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-[rgb(101,101,101)] text-[rgb(53,53,53)] rounded-sm cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Search by No." required="" />
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
        <div
            class=" flex-1 overflow-x-auto overflow-y-scroll border border-[rgb(143,143,143)] scroll no-scrollbar h-[28vh]">

            <table class="w-full text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0">

                    <tr class=" text-nowrap">

                        {{-- //* transaction no --}}
                        <th scope="col" class="px-4 py-3">Transaction No.</th>

                        <th scope="col" class="px-4 py-3 text-right">Total (₱)</th>

                        {{-- payment --}}
                        <th scope="col" class="px-4 py-3 text-center">Transaction type</th>
                        {{-- payment --}}
                        <th scope="col" class="px-4 py-3 text-center">Payment method</th>

                        {{-- //* gcash reference no. --}}
                        <th scope="col" class="px-4 py-3 text-center">GCash Reference No.</th>

                        <th scope="col" class="px-4 py-3 text-right">PWD/SC Discount Amount (₱)</th>
                        {{-- payment --}}
                        <th scope="col" class="px-4 py-3 text-right">Tax Amount (₱)</th>

                        <th wire:click="sortByColumn('created_at')" scope="col"
                            class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center justify-center">

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
                    </tr>
                </thead>

                {{-- //* table body --}}
                {{-- <tr x-data="{ isSelected: false }" :class="isSelected ? 'bg-gray-200' : ''"
                    class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75"
                    @click="isSelected = true; $dispatch('row-selected', {{ $sale->id }})"
                    @row-selected.window="isSelected = ($event.detail === {{ $sale->id }})"> --}}
                <tbody>

                    @foreach ($transactions as $index => $transaction)
                        <tr @if ($transaction->transaction_type == 'Sales') wire:click="getTransactionID({{ $transaction->transaction_id }},'Sales', true )"
                            @elseif ($transaction->transaction_type == 'Return')
                            wire:click="getTransactionID({{ $transaction->returns_id }},'Return', true
                            )"
                            @elseif ($transaction->transaction_type == 'Credit')
                            wire:click="getTransactionID({{ $transaction->creditJoin->transaction_id }},'Credit', true
                            )"
                            @elseif ($transaction->transaction_type == 'Void')
                            wire:click="getTransactionID({{ $transaction->void_transaction_id }},'Void',
                            true )" @endif
                            x-data="{ isSelected: false }" x-on:click=" isSelected = !isSelected "
                            :class="isSelected && ' bg-gray-200'" x-on:click.away="isSelected = false;"
                            class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in
                            duration-75">
                            <th scope="row"
                                class="px-4 py-4 font-bold text-left text-gray-900 text-md whitespace-nowrap ">
                                @if ($transaction->transaction_type == 'Sales')
                                    {{ $transaction['transactionJoin']['transaction_number'] }}
                                @elseif ($transaction->transaction_type == 'Return')
                                    {{ $transaction['returnsJoin']['return_number'] }}
                                @elseif ($transaction->transaction_type == 'Credit')
                                    {{ $transaction['creditJoin']['credit_number'] }}
                                @elseif ($transaction->transaction_type == 'Void')
                                    {{ $transaction['voidTransactionJoin']['void_number'] }}
                                @endif
                            </th>
                            <th scope="row"
                                class="px-4 py-4 font-medium text-right text-gray-900 text-md whitespace-nowrap ">
                                @if ($transaction->transaction_type == 'Sales')
                                    {{ number_format($transaction->transactionJoin->total_amount, 2) }}
                                @elseif ($transaction->transaction_type == 'Return')
                                    {{ number_format($transaction->returnsJoin->return_total_amount, 2) }}
                                @elseif ($transaction->transaction_type == 'Credit')
                                    {{ number_format($transaction->creditJoin->transactionJoin->total_amount, 2) }}
                                @elseif ($transaction->transaction_type == 'Void')
                                    {{ number_format($transaction->voidTransactionJoin->void_total_amount, 2) }}
                                @endif
                            </th>
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $transaction['transaction_type'] }}
                            </th>
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                @if ($transaction->transaction_type == 'Sales')
                                    {{ $transaction['transactionJoin']['paymentJoin']['payment_type'] ?? 'N/A' }}
                                @elseif ($transaction->transaction_type == 'Return')
                                    N/A
                                @elseif ($transaction->transaction_type == 'Credit')
                                    {{ $transaction['creditJoin']['transactionJoin']['paymentJoin']['payment_type'] ?? 'N/A' }}
                                @elseif ($transaction->transaction_type == 'Void')
                                    N/A
                                @endif
                            </th>
                            <th scope="row"
                                class="px-4 py-4 italic font-medium text-center text-left-900 text-md whitespace-nowrap ">
                                @if ($transaction->transaction_type == 'Sales')
                                    {{ $transaction['transactionJoin']['paymentJoin']['reference_number'] ?? 'N/A' }}
                                @elseif ($transaction->transaction_type == 'Return')
                                    {{ $transaction['returnsJoin']['transactionJoin']['paymentJoin']['reference_number'] ?? 'N/A' }}
                                @elseif ($transaction->transaction_type == 'Credit')
                                    {{ $transaction['creditJoin']['transactionJoin']['paymentJoin']['reference_number'] ?? 'N/A' }}
                                @elseif ($transaction->transaction_type == 'Void')
                                    {{ $transaction['voidTransactionJoin']['transactionJoin']['paymentJoin']['reference_number'] ?? 'N/A' }}
                                @endif
                            </th>

                            <th scope="row"
                                class="px-4 py-4 italic font-medium text-right text-left-900 text-md whitespace-nowrap ">
                                @if ($transaction->transaction_type == 'Sales')
                                    {{ number_format($transaction['transactionJoin']['total_discount_amount'], 2) ?? 'N/A' }}
                                @elseif ($transaction->transaction_type == 'Return')
                                    0.00
                                @elseif ($transaction->transaction_type == 'Credit')
                                    {{ number_format($transaction['creditJoin']['transactionJoin']['total_discount_amount'], 2) ?? 'N/A' }}
                                @elseif ($transaction->transaction_type == 'Void')
                                    0.00
                                @endif
                            </th>
                            <th scope="row"
                                class="px-4 py-4 italic font-medium text-right text-left-900 text-md whitespace-nowrap ">
                                @if ($transaction->transaction_type == 'Sales')
                                    {{ number_format($transaction['transactionJoin']['total_vat_amount'], 2) ?? 'N/A' }}
                                @elseif ($transaction->transaction_type == 'Return')
                                    {{ number_format($transaction['returnsJoin']['return_vat_amount'], 2) ?? 'N/A' }}
                                @elseif ($transaction->transaction_type == 'Credit')
                                    {{ number_format($transaction['creditJoin']['transactionJoin']['total_vat_amount'], 2) ?? 'N/A' }}
                                @elseif ($transaction->transaction_type == 'Void')
                                    {{ number_format($transaction['voidTransactionJoin']['void_vat_amount'], 2) ?? 'N/A' }}
                                @endif
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $transaction['created_at']->format(' M d Y h:i A ') }}
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex flex-row w-full h-[30vh] border border-black">
        @if (!$transactionDetails)
            <div class="flex items-center justify-center w-full bg-slate-50">
                <p class=" text-[2em] font-black opacity-30">SELECT A TRANSACTION TO VIEW TRANSACTION DETAILS</p>
            </div>
        @else
            <div class="grid w-1/3 grid-flow-row">
                <div class="row-span-2 border-b border-black ">
                    <div class="grid items-center grid-flow-row px-2">
                        <div>
                            <p>Transaction No</p>
                        </div>
                        <div class="self-center ">
                            <p class="text-[1.6em] text-center font-black">{{ $transaction_number }}</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-flow-row px-2 py-2 overflow-hidden row-span-10">
                    @if ($transaction_type == 'Sales' || $transaction_type == 'Credit')
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
                    @endif
                    @if ($transaction_type == 'Return')
                        <div class="flex flex-row justify-between">
                            <div>
                                <p class=" text-[1.2em] font-medium">Total</p>
                            </div>
                            <div>
                                <p class=" text-[1.2em] font-black">{{ number_format($return_original_amount, 2) }}
                                </p>
                            </div>
                        </div>
                    @elseif ($transaction_type == 'Void')
                        <div class="flex flex-row justify-between">
                            <div>
                                <p class=" text-[1.2em] font-medium">Total</p>
                            </div>
                            <div>
                                <p class=" text-[1.2em] font-black">{{ number_format($void_original_amount, 2) }}</p>
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
                    @if ($transaction_type == 'Sales')
                        <div class="flex flex-row justify-between">
                            <div>
                                <p class=" text-[1.2em] font-medium">Tendered Amount</p>
                            </div>
                            <div>
                                <p class=" text-[1.2em] font-black">{{ number_format($tendered_amount, 2) }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="bg-black border h-[2px] border-black "></div>
                    <div class="flex flex-row justify-between">
                        @if ($payment_type != 'GCash' && !is_null($payment_type) && $transaction_type == 'Sales')
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
                                <p class=" text-[1.2em] font-black">{{ number_format($return_original_amount, 2) }}
                                </p>
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
                    @if ($transaction_type == 'Void')
                        <div class="flex flex-row justify-between">
                            <div>
                                <p class=" text-[1.2em] font-medium">Original Amount</p>
                            </div>
                            <div>
                                <p class=" text-[1.2em] font-black">{{ number_format($void_original_amount, 2) }}</p>
                            </div>
                        </div>
                        <div class="flex flex-row justify-between">
                            <div>
                                <p class=" text-[1.2em] font-medium">Void Amount</p>
                            </div>
                            <div>
                                <p class=" text-[1.2em] font-black">{{ number_format($void_amount, 2) }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div
                class=" w-full overflow-x-scroll overflow-y-scroll border border-[rgb(143,143,143)] scroll no-scrollbar">

                <table class="w-full text-sm text-left h-fit scroll no-scrollbar">

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
                            <th scope="col" class="px-4 py-3 text-left">Item Name</th>

                            {{-- item name --}}
                            <th scope="col" class="px-4 py-3 text-left">Item Description</th>

                            {{-- item name --}}
                            @if ($transaction_type == 'Sales' || $transaction_type == 'Credit')
                                <th scope="col" class="px-4 py-3 text-left">Status</th>
                            @elseif($transaction_type == 'Return')
                                <th scope="col" class="px-4 py-3 text-left">Description</th>
                            @elseif($transaction_type == 'Void')
                                <th scope="col" class="px-4 py-3 text-left">Reason</th>
                            @endif

                            {{-- //* unit price --}}
                            <th scope="col" class="px-4 py-3 text-right">Unit Price (₱)</th>

                            {{-- //* quantity --}}
                            <th scope="col" class="px-4 py-3 text-center">Quantity</th>

                            {{-- //* wholesale --}}
                            <th scope="col" class="px-4 py-3 text-right">Wholesale (₱)</th>

                            {{-- //* amount --}}
                            <th scope="col" class="px-4 py-3 text-right">Subtotal (₱)</th>
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
                                    @if ($transaction_type == 'Sales' || $transaction_type == 'Credit')
                                        {{ $transactionDetail['inventoryJoin']['sku_code'] }}
                                    @elseif ($transaction_type == 'Return')
                                        {{ $transactionDetail['transactionDetailsJoin']['inventoryJoin']['sku_code'] }}
                                    @elseif ($transaction_type == 'Void')
                                        {{ $transactionDetail['transactionDetailsJoin']['inventoryJoin']['sku_code'] }}
                                    @endif
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap ">
                                    @if ($transaction_type == 'Sales' || $transaction_type == 'Credit')
                                        {{ $transactionDetail['itemJoin']['barcode'] }}
                                    @elseif ($transaction_type == 'Return')
                                        {{ $transactionDetail['transactionDetailsJoin']['inventoryJoin']['itemJoin']['barcode'] }}
                                    @elseif ($transaction_type == 'Void')
                                        {{ $transactionDetail['transactionDetailsJoin']['inventoryJoin']['itemJoin']['barcode'] }}
                                    @endif
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap ">
                                    @if ($transaction_type == 'Sales' || $transaction_type == 'Credit')
                                        {{ $transactionDetail['itemJoin']['item_name'] }}
                                    @elseif ($transaction_type == 'Return')
                                        {{ $transactionDetail['transactionDetailsJoin']['inventoryJoin']['itemJoin']['item_name'] }}
                                    @elseif ($transaction_type == 'Void')
                                        {{ $transactionDetail['transactionDetailsJoin']['inventoryJoin']['itemJoin']['item_name'] }}
                                    @endif
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap ">
                                    @if ($transaction_type == 'Sales' || $transaction_type == 'Credit')
                                        {{ $transactionDetail['itemJoin']['item_description'] }}
                                    @elseif ($transaction_type == 'Return')
                                        {{ $transactionDetail['transactionDetailsJoin']['inventoryJoin']['itemJoin']['item_description'] }}
                                    @elseif ($transaction_type == 'Void')
                                        {{ $transactionDetail['transactionDetailsJoin']['inventoryJoin']['itemJoin']['item_description'] }}
                                    @endif
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap ">
                                    @if ($transaction_type == 'Sales' || $transaction_type == 'Credit')
                                        {{ $transactionDetail['status'] }}
                                    @elseif ($transaction_type == 'Return')
                                        {{ $transactionDetail['description'] }}
                                    @elseif ($transaction_type == 'Void')
                                        {{ $transactionDetail['reason'] }}
                                    @endif
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-right text-gray-900 text-md whitespace-nowrap ">
                                    @if ($transaction_type == 'Sales' || $transaction_type == 'Credit')
                                        {{ number_format($transactionDetail['item_price'], 2) }}
                                    @elseif ($transaction_type == 'Return')
                                        {{ number_format($transactionDetail['transactionDetailsJoin']['item_price'], 2) }}
                                    @elseif ($transaction_type == 'Void')
                                        {{ number_format($transactionDetail['transactionDetailsJoin']['item_price'], 2) }}
                                    @endif
                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    @if ($transaction_type == 'Sales' || $transaction_type == 'Credit')
                                        {{ $transactionDetail['item_quantity'] }}
                                    @elseif ($transaction_type == 'Return')
                                        {{ $transactionDetail['return_quantity'] }}
                                    @elseif ($transaction_type == 'Void')
                                        {{ $transactionDetail['void_quantity'] }}
                                    @endif
                                </th>

                                <th scope="row"
                                    class="px-4 py-4 font-medium text-right text-gray-900 text-md whitespace-nowrap ">
                                    @if ($transaction_type == 'Sales' || $transaction_type == 'Credit')
                                        @if (isset($transactionDetail['discount_id']) && $transactionDetail['discount_id'] == 3)
                                            {{ number_format(
                                                $transactionDetail['item_price'] -
                                                    $transactionDetail['item_price'] * ($transactionDetail['discountJoin']['percentage'] / 100),
                                                2,
                                            ) }}
                                        @else
                                            0.00
                                        @endif
                                    @elseif ($transaction_type == 'Return')
                                        @if (isset($transactionDetail['transactionDetailsJoin']['discount_id']) &&
                                                $transactionDetail['transactionDetailsJoin']['discount_id'] == 3)
                                            {{ number_format(
                                                $transactionDetail['transactionDetailsJoin']['item_price'] -
                                                    $transactionDetail['transactionDetailsJoin']['item_price'] *
                                                        ($transactionDetail['transactionDetailsJoin']['discountJoin']['percentage'] / 100),
                                                2,
                                            ) }}
                                        @else
                                            0.00
                                        @endif
                                    @elseif ($transaction_type == 'Void')
                                        @if (isset($transactionDetail['transactionDetailsJoin']['discount_id']) &&
                                                $transactionDetail['transactionDetailsJoin']['discount_id'] == 3)
                                            {{ number_format(
                                                $transactionDetail['transactionDetailsJoin']['item_price'] -
                                                    $transactionDetail['transactionDetailsJoin']['item_price'] *
                                                        ($transactionDetail['transactionDetailsJoin']['discountJoin']['percentage'] / 100),
                                                2,
                                            ) }}
                                        @else
                                            0.00
                                        @endif
                                    @endif

                                </th>
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-right text-gray-900 text-md whitespace-nowrap ">
                                    @if ($transaction_type == 'Sales' || $transaction_type == 'Credit')
                                        {{ number_format($transactionDetail['item_subtotal'], 2) }}
                                    @elseif ($transaction_type == 'Return')
                                        {{ number_format($transactionDetail['item_return_amount'], 2) }}
                                    @elseif ($transaction_type == 'Void')
                                        {{ number_format($transactionDetail['item_void_amount'], 2) }}
                                    @endif
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
