<div x-cloak class="flex items-center justify-center h-fit ">
    <div class="flex items-center justify-center border border-black">
        <div class="flex flex-col p-4 bg-white ">
            <div class="flex flex-col mb-6 text-center">
                <div class=" text-[1.2em] font-black">
                    <p>JK FROZEN PRODUCTS AND CONSUMER SUPPLIES STORE</p>
                </div>
                <div>
                    <p>Quezon Avenue St., Poblacion, Tacurong City, Sultan Kudarat</p>
                </div>
                <div class=" text-[1em] font-medium italic">
                    <p>Non-VAT Reg TIN 936-196-461-0000</p>
                </div>
            </div>
            <div class="flex flex-row justify-between px-4">
                <div class="flex flex-col ">
                    <div class="flex flex-row gap-1 ">
                        <p>Date:</p>
                        <p>{{ $receiptDetails['transaction_info']['transaction_date'] ?? null }}</p>
                    </div>
                    <div class="flex flex-row gap-1 ">
                        <p>Time:</p>
                        <p>{{ $receiptDetails['transaction_info']['transaction_time'] ?? null }}</p>
                    </div>
                    <div class="flex flex-row gap-1 ">
                        <p>Transaction No.</p>
                        <p>{{ $receiptDetails['transaction_info']['transaction_no'] ?? null }}</p>
                    </div>
                    <div class="flex flex-row gap-1 ">
                        <p>Payment Method:</p>
                        <p>{{ $receiptDetails['payment']['payment_type'] ?? null }}</p>
                    </div>
                    <div class="flex flex-row gap-1 ">
                        <p>Reference No.</p>
                        <p>{{ $receiptDetails['payment']['reference_no'] ?? null }}</p>
                    </div>
                </div>
                <div class="flex flex-row ">
                    <p>Sales Invoice No.</p>
                    <p>1234</p>
                </div>
            </div>
            <div class="m-2 ">
                <div class="border border-black "></div>
            </div>
            <div class="mx-2">
                <table class="w-full h-10 text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead
                        class="sticky top-0 m-2 text-[0.8em] text-black uppercase border-b-2 border-black cursor-default ">

                        <tr class=" text-nowrap">

                            <th scope="col" class="px-2 py-3">Item</th>

                            {{-- //* contact number --}}
                            <th scope="col" class="px-2 py-3">Description</th>

                            {{-- //* role --}}
                            <th scope="col" class="px-2 py-3">Quantity</th>

                            {{-- //* status --}}
                            <th scope="col" class="px-2 py-3 text-center">Price</th>

                            {{-- //* username --}}
                            <th scope="col" class="px-2 py-3">Wholesale (%)</th>

                            {{-- //* username --}}
                            <th scope="col" class="px-2 py-3">Subtotal</th>

                        </tr>
                    </thead>


                    <tbody class="border-b border-black">
                        @if (isset($receiptDetails['selectedItems']) && is_array($receiptDetails['selectedItems']))
                            @foreach ($receiptDetails['selectedItems'] as $item)
                                <tr>
                                    <th>{{ $item['item_name'] }}</th>
                                    <th>{{ $item['item_description'] }}</th>
                                    <th>{{ $item['quantity'] }}</th>
                                    <th>{{ number_format($item['selling_price'], 2) }}</th>
                                    <th>{{ $item['discount'] }}</th>
                                    <th>{{ number_format($item['total_amount'], 2) }}</td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
            <div class="flex flex-col gap-2 p-2 mx-2">
                <div class="flex flex-row justify-between">
                    <p>VATable</p>
                    <p>{{ number_format($receiptDetails['tax_details']['vatable_amount'] ?? null, 2) }}</p>
                </div>
                <div class="flex flex-row justify-between">
                    <p>Non-Vatable Sale</p>
                    <p>{{ number_format($receiptDetails['tax_details']['non_vatable_amount'] ?? null, 2) }}</p>
                </div>
                <div class="flex flex-row justify-between">
                    <p>VAT-Exempt Sale</p>
                    <p>0.00</p>
                </div>
                <div class="flex flex-row justify-between">
                    <p>VAT Zero-Rated Sale</p>
                    <p>0.00</p>
                </div>
            </div>
            <div class="m-2 ">
                <div class="border border-black "></div>
            </div>
            <div class="flex flex-col gap-2 p-2 mx-2">
                <div class="flex flex-row justify-between">

                    <p class=" text-[1.4em] font-bold">Subtotal</p>
                    <p class=" text-[1.4em] font-bold">
                        {{ number_format($receiptDetails['transaction_info']['subtotal'] ?? null, 2) }}</p>
                </div>
                <div class="flex flex-row justify-between">
                    <p>Discount - Senior Citizen / PWD (20%)</p>
                    <p>{{ number_format($receiptDetails['tax_details']['PWD_Senior_discount_amount'] ?? null, 2) }}</p>
                </div>
            </div>
            <div class="m-2 ">
                <div class="border border-black "></div>
            </div>
            <div class="flex flex-col gap-2 p-2 mx-2">
                <div class="flex flex-row justify-between">

                    <p class=" text-[1.4em] font-bold">Total Amount</p>
                    <p class=" text-[1.4em] font-bold">
                        {{ number_format($receiptDetails['transaction_info']['grandTotal'] ?? null, 2) }}</p>
                </div>
                <div class="flex flex-row justify-between">
                    <p>Tendered Amount</p>
                    <p>{{ number_format($receiptDetails['payment']['tendered_amount'] ?? null, 2) }}</p>
                </div>
            </div>
            <div class="m-2 ">
                <div class="border border-black "></div>
            </div>
            <div class="flex flex-col gap-2 p-2 mx-2">
                <div class="flex flex-row justify-between">
                    <p class=" text-[1.4em] font-bold">Change</p>
                    <p class=" text-[1.4em] font-bold">
                        {{ number_format($receiptDetails['payment']['change'] ?? null, 2) }}</p>
                </div>
            </div>
            <div class="m-2 ">
                <div class="border border-black "></div>
            </div>
            <div class="flex flex-col gap-2 p-2 mx-2">
                <div class="flex flex-row justify-between">
                    <p>Customer Name</p>

                    @if (isset($receiptDetails['customerDetails']['customer']))
                        <p>
                            {{ $receiptDetails['customerDetails']['customer']['firstname'] ?? null }}
                            {{ $receiptDetails['customerDetails']['customer']['middlename'] ?? null }}
                            {{ $receiptDetails['customerDetails']['customer']['lastname'] ?? null }}
                        </p>
                    @else
                        <p>
                            {{ $receiptDetails['customerDetails']['firstname'] ?? null }}
                            {{ $receiptDetails['customerDetails']['middlename'] ?? null }}
                            {{ $receiptDetails['customerDetails']['lastname'] ?? null }}
                        </p>
                    @endif

                </div>
                <div class="flex flex-row justify-between">
                    <p>Customer Signature</p>
                    <p>_______________________</p>
                </div>
            </div>
        </div>
    </div>
</div>
