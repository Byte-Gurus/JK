<div>
    <div class=" w-full max-w-[216px]">
        <div class="w-full bg-red-100 border-2 border-red-400 h-fit">
            <div class="flex flex-col justify-center mb-6 text-center">
                <div class="font-black ">
                    <p class="text-[0.2em]">JK FROZEN PRODUCTS AND CONSUMER SUPPLIES STORE</p>
                </div>
                <div>
                    <p class="text-[0.2em]">Quezon Avenue St., Poblacion, Tacurong City, Sultan Kudarat</p>
                </div>
                <div>
                    <p class="text-[0.2em]">Non-VAT Reg TIN 936-196-461-0000</p>
                </div>
            </div>
            <div class="flex flex-row justify-between px-2">
                <div class="flex flex-col ">
                    <div class="flex flex-row">
                        <p class="text-[0.2em]">Date:</p>
                        <p class="text-[0.2em]">{{ $receiptDetails['transaction_info']['transaction_date'] ?? null }}
                        </p>
                    </div>
                    <div class="flex flex-row">
                        <p class="text-[0.2em]">Time:</p>
                        <p class="text-[0.2em]">{{ $receiptDetails['transaction_info']['transaction_time'] ?? null }}
                        </p>
                    </div>
                    <div class="flex flex-row">
                        <p class="text-[0.2em]">Transaction No.</p>
                        <p class="text-[0.2em]">{{ $receiptDetails['transaction_info']['transaction_no'] ?? null }}</p>
                    </div>
                    <div class="flex flex-row">
                        <p class="text-[0.2em]">Payment Method:</p>
                        <p class="text-[0.2em]">{{ $receiptDetails['payment']['payment_type'] ?? null }}</p>
                    </div>
                    <div class="flex flex-row">
                        <p class="text-[0.2em]">Reference No.</p>
                        <p class="text-[0.2em]">{{ $receiptDetails['payment']['reference_no'] ?? null }}</p>
                    </div>
                </div>
                <div class="flex flex-row ">
                    <p class="text-[0.2em]">Sales Invoice No.</p>
                    <p class="text-[0.2em]">1234</p>
                </div>
            </div>
            <div class="m-2 ">
                <div class="border border-[rgb(143,143,143)] "></div>
            </div>
            <div class="mx-2">
                <table class="w-full h-10 text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead class="sticky top-0 text-black uppercase border-b-2 border-black cursor-default ">

                        <tr class="flex flex-row justify-between text-nowrap">

                            <th scope="col">
                                <p class="text-[0.6em]">Item</p>
                            </th>

                            {{-- //* status --}}
                            <th scope="col">
                                <p class="text-[0.6em]">Price</p>
                            </th>

                        </tr>
                    </thead>

                    <tbody class="border-b border-black">
                        @if (isset($receiptDetails['selectedItems']) && is_array($receiptDetails['selectedItems']))
                            @foreach ($receiptDetails['selectedItems'] as $item)
                                <tr>
                                    <th>{{ $item['item_name'] }}</th>
                                    <th>{{ number_format($item['selling_price'], 2) }}</th>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="flex flex-col gap-2 p-2 mx-2">
                <div class="flex flex-row justify-between">
                    <p class="text-[0.2em]">VATable</p>
                    <p class="text-[0.2em]">
                        {{ number_format($receiptDetails['tax_details']['vatable_amount'] ?? null, 2) }}</p>
                </div>
                <div class="flex flex-row justify-between">
                    <p class="text-[0.2em]">Non-Vatable Sale</p>
                    <p class="text-[0.2em]">
                        {{ number_format($receiptDetails['tax_details']['non_vatable_amount'] ?? null, 2) }}</p>
                </div>
                <div class="flex flex-row justify-between">
                    <p class="text-[0.2em]">VAT-Exempt Sale</p>
                    <p class="text-[0.2em]">0.00</p>
                </div>
                <div class="flex flex-row justify-between">
                    <p class="text-[0.2em]">VAT Zero-Rated Sale</p>
                    <p class="text-[0.2em]">0.00</p>
                </div>
            </div>
            <div class="m-2 ">
                <div class="border border-black "></div>
            </div>
            <div class="flex flex-col gap-2 p-2 mx-2">
                <div class="flex flex-row justify-between">

                    <p class="text-[0.2em]">Subtotal</p>
                    <p class="text-[0.2em]">
                        {{ number_format($receiptDetails['transaction_info']['subtotal'] ?? null, 2) }}</p>
                </div>
                <div class="flex flex-row justify-between">
                    <p class="text-[0.2em]">Discount - Senior Citizen / PWD (20%)</p>
                    <p class="text-[0.2em]">
                        {{ number_format($receiptDetails['tax_details']['PWD_Senior_discount_amount'] ?? null, 2) }}
                    </p>
                </div>
            </div>
            <div class="m-2 ">
                <div class="border border-black "></div>
            </div>
            <div class="flex flex-col gap-2 p-2 mx-2">
                <div class="flex flex-row justify-between">

                    <p class="text-[0.2em]">Total Amount</p>
                    <p class="text-[0.2em]">
                        {{ number_format($receiptDetails['transaction_info']['grandTotal'] ?? null, 2) }}</p>
                </div>
                <div class="flex flex-row justify-between">
                    <p class="text-[0.2em]">Tendered Amount</p>
                    <p class="text-[0.2em]">
                        {{ number_format($receiptDetails['payment']['tendered_amount'] ?? null, 2) }}</p>
                </div>
            </div>
            <div class="m-2 ">
                <div class="border border-black "></div>
            </div>
            <div class="flex flex-col gap-2 p-2 mx-2">
                <div class="flex flex-row justify-between">
                    <p class="text-[0.2em]">Change</p>
                    <p class="text-[0.2em]">
                        {{ number_format($receiptDetails['payment']['change'] ?? null, 2) }}</p>
                </div>
            </div>
            <div class="m-2 ">
                <div class="border border-black "></div>
            </div>
            <div class="flex flex-col gap-2 p-2 mx-2">
                <div class="flex flex-row justify-between">
                    <p class="text-[0.2em]">Customer Name</p>

                    @if (isset($receiptDetails['customerDetails']['customer']))
                        <p class="text-[0.2em]">
                            {{ $receiptDetails['customerDetails']['customer']['firstname'] ?? null }}
                            {{ $receiptDetails['customerDetails']['customer']['middlename'] ?? null }}
                            {{ $receiptDetails['customerDetails']['customer']['lastname'] ?? null }}
                        </p>
                    @else
                        <p class="text-[0.2em]">
                            {{ $receiptDetails['customerDetails']['firstname'] ?? null }}
                            {{ $receiptDetails['customerDetails']['middlename'] ?? null }}
                            {{ $receiptDetails['customerDetails']['lastname'] ?? null }}
                        </p>
                    @endif

                </div>
                <div class="flex flex-row justify-between">
                    <p class="text-[0.2em]">Customer Signature</p>
                    <p class="text-[0.2em]">_______________________</p>
                </div>
            </div>
        </div>
    </div>
</div>
