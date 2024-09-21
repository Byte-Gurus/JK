<div x-cloak class="flex justify-center w-full">
    <div class=" w-full max-w-[216px]">
        <div class="w-full border-2 h-fit">
            <div class="flex flex-col justify-center mx-3 mb-6 text-center">
                <div class="font-black ">
                    <p class="text-[0.6em] uppercase">JK FROZEN PRODUCTS AND CONSUMER SUPPLIES STORE</p>
                </div>
                <div>
                    <p class="text-[0.6em] uppercase">Quezon Avenue St., Poblacion, Tacurong City, Sultan Kudarat</p>
                </div>
                <div>
                    <p class="text-[0.6em] uppercase">Non-VAT Reg TIN 936-196-461-0000</p>
                </div>
            </div>
            <div class="flex flex-col justify-between px-4 mb-2">
                <div class="flex flex-col ">
                    <div class="flex flex-row self-end mb-4 mr-2 text-nowrap">
                        <p class="text-[0.6em] font-black uppercase">Sales Invoice No.</p>
                        <p class="text-[0.6em] font-black uppercase">1234</p>
                    </div>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Date:</p>
                        <p class="text-[0.6em] font-bold uppercase">
                            {{ $receiptDetails['transaction_info']['transaction_date'] ?? null }}
                        </p>
                    </div>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Time:</p>
                        <p class="text-[0.6em] font-bold uppercase">
                            {{ $receiptDetails['transaction_info']['transaction_time'] ?? null }}
                        </p>
                    </div>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Transaction No.</p>
                        <p class="text-[0.6em] font-bold uppercase">
                            {{ $receiptDetails['transaction_info']['transaction_number'] ?? null }}</p>
                    </div>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Payment Method:</p>
                        <p class="text-[0.6em] font-bold uppercase">
                            {{ $receiptDetails['payment']['payment_type'] ?? null }}</p>
                    </div>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Reference No.</p>
                        <p class="text-[0.6em] font-bold uppercase">
                            {{ $receiptDetails['payment']['reference_no'] ?? null }}</p>
                    </div>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Prepared By:</p>
                        <p class="text-[0.6em] font-bold uppercase">
                            {{ $receiptDetails['transaction_info']['user'] ?? null }}</p>
                    </div>
                </div>
            </div>

            <div class="mx-4">
                <span class="">------------------------</span>

                {{-- //* table header --}}
                <ul class="grid justify-between grid-flow-col grid-cols-4">
                    <li class="col-span-1 ">
                        <div>
                            <p class="text-[0.6em]  font-bold">Qty</p>
                        </div>
                    </li>
                    <li class="col-span-4 ">
                        <div>
                            <p class="text-[0.6em] font-bold">Description(s)</p>
                        </div>
                    </li>
                    <li class="col-span-1 ">
                        <div>
                            <p class="text-[0.6em] font-bold">Price</p>
                        </div>
                    </li>
                </ul>

                <span class="">------------------------</span>


                @if (isset($receiptDetails['selectedItems']) && is_array($receiptDetails['selectedItems']))
                    @foreach ($receiptDetails['selectedItems'] as $item)
                        <ul class="grid justify-between grid-flow-col grid-cols-4">
                            <li class="col-span-1 py-[3px]">
                                <div>
                                    <p class="text-[0.6em] uppercase text-center font-medium">
                                        {{ $item['quantity'] }}</p>
                                </div>
                            </li>
                            <li class="col-span-4 py-[3px]">
                                <div class="flex flex-col px-[3px] max-w-[90px] break-all leading-none">
                                    <div class=" text-wrap">
                                        <p class="text-[0.6em] flex uppercase text-justify font-bold">
                                            {{ $item['item_name'] }} {{ $item['item_description'] }}
                                        </p>
                                    </div>
                                    <div class="flex flex-col w-full justify-center gap-[3px]">
                                        <div class="flex flex-row justify-end gap-[5px]">
                                            <p class="text-[0.6em] uppercase text-justify italic font-bold">RP</p>
                                            <p class="text-[0.6em] uppercase text-justify italic font-bold">
                                                {{ number_format($item['selling_price'], 2) }}</p>
                                        </div>
                                        <div class="flex flex-row justify-end gap-[3px]">
                                            <p class="text-[0.6em] uppercase text-justify italic font-bold">WS</p>
                                            <p class="text-[0.6em] uppercase text-justify italic font-bold">
                                                {{ $item['discount'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="col-span-1 py-[3px]">
                                <div>
                                    <p class="text-[0.6em] text-right uppercase font-bold">
                                        {{ number_format($item['total_amount'], 2) }}
                                    </p>
                                </div>
                            </li>
                        </ul>
                    @endforeach
                @endif

                <span class="">------------------------</span>
            </div>

            <div class="flex flex-col px-2 mx-2">
                <div class="flex flex-row justify-between">
                    <p class="text-[0.6em] font-bold uppercase">VATable</p>
                    <p class="text-[0.6em] font-bold uppercase">
                        {{ number_format($receiptDetails['tax_details']['vatable_amount'] ?? null, 2) }}</p>
                </div>
                <div class="flex flex-row justify-between">
                    <p class="text-[0.6em] font-bold uppercase">Non-Vatable Sale</p>
                    <p class="text-[0.6em] font-bold uppercase">
                        {{ number_format($receiptDetails['tax_details']['non_vatable_amount'] ?? null, 2) }}</p>
                </div>
                <div class="flex flex-row justify-between">
                    <p class="text-[0.6em] font-bold uppercase">VAT-Exempt Sale</p>
                    <p class="text-[0.6em] font-bold uppercase">0.00</p>
                </div>
                <div class="flex flex-row justify-between">
                    <p class="text-[0.6em] font-bold uppercase">VAT Zero-Rated Sale</p>
                    <p class="text-[0.6em] font-bold uppercase">0.00</p>
                </div>
            </div>
            <div class="mx-4 ">
                <span class="">------------------------</span>
            </div>
            <div class="flex flex-col gap-1 px-2 mx-2">
                <div class="flex flex-row justify-between">

                    <p class="text-[0.6em] font-bold uppercase">Subtotal</p>
                    <p class="text-[0.6em] font-bold uppercase">
                        {{ number_format($receiptDetails['transaction_info']['subtotal'] ?? null, 2) }}</p>
                </div>
                <div class="flex flex-row justify-between">
                    <p class="text-[0.6em] font-bold uppercase">Discount - SC/PWD (20%)</p>
                    <p class="text-[0.6em] font-bold uppercase">
                        {{ number_format($receiptDetails['tax_details']['PWD_Senior_discount_amount'] ?? null, 2) }}
                    </p>
                </div>
            </div>
            <div class="mx-4 ">
                <span class="">------------------------</span>
            </div>
            <div class="flex flex-col gap-1 px-3 m-1">
                <div class="flex flex-row justify-between">

                    <p class="text-[0.6em] font-bold uppercase">Total Amount</p>
                    <p class="text-[0.6em] font-bold uppercase">
                        {{ number_format($receiptDetails['transaction_info']['grandTotal'] ?? null, 2) }}</p>
                </div>
                <div class="flex flex-row justify-between">
                    <p class="text-[0.6em] font-bold uppercase">Tendered Amount</p>
                    <p class="text-[0.6em] font-bold uppercase">
                        {{ number_format($receiptDetails['payment']['tendered_amount'] ?? null, 2) }}</p>
                </div>
            </div>
            <div class="mx-4 ">
                <span class="">------------------------</span>
            </div>
            <div class="flex flex-col gap-2 px-3 mx-1">
                <div class="flex flex-row justify-between">
                    <p class="text-[0.6em] font-bold uppercase">Change</p>
                    <p class="text-[0.6em] font-bold uppercase">
                        {{ number_format($receiptDetails['payment']['change'] ?? null, 2) }}</p>
                </div>
            </div>
            <div class="mx-4 ">
                <span class="">------------------------</span>
            </div>
            <div class="flex flex-col gap-2 px-2 mx-2 pb-[34px] mt-2p">
                <div class="flex flex-col justify-between">
                    <p class="text-[0.6em] font-bold uppercase">Customer Name</p>

                    @if (isset($receiptDetails['customerDetails']['customer']))
                        <p class="text-[0.6em] font-bold uppercase">
                            {{ $receiptDetails['customerDetails']['customer']['firstname'] ?? null }}
                            {{ $receiptDetails['customerDetails']['customer']['middlename'] ?? null }}
                            {{ $receiptDetails['customerDetails']['customer']['lastname'] ?? null }}
                        </p>
                    @else
                        <p class="text-[0.6em] font-bold uppercase">
                            {{ $receiptDetails['customerDetails']['firstname'] ?? null }}
                            {{ $receiptDetails['customerDetails']['middlename'] ?? null }}
                            {{ $receiptDetails['customerDetails']['lastname'] ?? null }}
                        </p>
                    @endif

                    @if (isset($receiptDetails['credit_details']['creditor_name']))
                        <p class="text-[0.6em] font-bold uppercase">
                            {{ $receiptDetails['credit_details']['creditor_name'] ?? null }}
                        </p>
                    @endif


                </div>
                <div class="flex flex-col justify-between font-bold">
                    <p class="text-[0.6em] font-bold uppercase">Customer Signature</p>
                    <p class="text-[0.6em] font-bold">_______________________</p>
                </div>
            </div>
        </div>
    </div>
</div>
