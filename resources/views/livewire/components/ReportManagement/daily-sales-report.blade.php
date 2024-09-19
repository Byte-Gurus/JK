<div class="flex justify-center">

    <div class="  w-[816px] max-h-[1056px] h-full border border-black">
        <div class="flex flex-row justify-around my-8">
            <div>
                <img src="{{ asset('jk-logo-cropped.png') }}" alt="logo" class="w-[120px]">
            </div>
            <div class="flex flex-col justify-center mx-3 mb-6 text-center">
                <div class="font-black ">
                    <p class="text-[0.8em] uppercase">JK FROZEN PRODUCTS AND CONSUMER SUPPLIES STORE</p>
                </div>
                <div>
                    <p class="text-[0.8em] uppercase">Quezon Avenue St., Poblacion, Tacurong City, Sultan Kudarat</p>
                </div>
                <div>
                    <p class="text-[0.8em] uppercase">Non-VAT Reg TIN 936-196-461-0000</p>
                </div>
            </div>
        </div>
        <div>
            <p class="text-[2em] font-bold text-right italic m-4 mr-10 uppercase">DAILY SALES REPORT</p>

        </div>
        <div class="grid grid-flow-col grid-cols-2 ">
            <div class="flex flex-col justify-between col-span-1 px-4 mb-2">
                <div class="flex flex-col ">
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[1em] font-bold uppercase">Date & Time Created:</p>
                        {{-- <p class="text-[1em] font-bold uppercase">{{ $dateCreated }}</p> --}}
                        {{-- {{ $receiptDetails['transaction_info']['transaction_date'] ?? null }} --}}
                        </p>
                    </div>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[1em] font-bold uppercase">Prepared By:</p>
                        {{-- <p class="text-[1em] font-bold uppercase">{{ $createdBy }}</p> --}}
                        {{-- {{ $receiptDetails['payment']['payment_type'] ?? null }}</p> --}}
                    </div>
                </div>
                <div class="flex flex-row text-nowrap">
                    <p class="text-[1em] font-black uppercase">Selected Date:</p>
                    {{-- <p class="text-[1em] font-black uppercase">{{ $createdBy }}</p> --}}
                </div>
            </div>
            <div class="flex flex-col justify-between col-span-1 px-4 mb-2">
                <div class="flex flex-col ">
                    <div class="flex flex-row border border-black text-nowrap">
                        <p class="text-[1em] w-1/2 font-bold border-black  border-r uppercase">Gross Sales</p>
                        {{ $transaction_info['totalGross'] ?? ' ' }}
                        </p>
                    </div>
                    <div class="flex flex-row border border-black text-nowrap ">
                        <p class="text-[1em] font-bold w-1/2 border-r border-black uppercase">Tax Amount</p>

                        {{ $transaction_info['totalTax'] ?? ' ' }}

                    </div>
                </div>
                <div class="flex flex-row border border-black text-nowrap">
                    <p class="text-[1em] font-black border-r border-black w-1/2 uppercase">Net Sales </p>
                    {{-- <p class="text-[1em] font-black uppercase">{{ $createdBy }}</p> --}}
                </div>
            </div>
        </div>

        <div>
            <div class="w-full my-4 border-b border-black"> </div>

            {{-- //* table header --}}
            <ul class="grid justify-between grid-flow-col grid-cols-8 mx-4 ">

                <li class="col-span-2 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">Transaction No</p>
                    </div>
                </li>
                <li class="col-span-2 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">Transaction type</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">Time</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Gross Sales</p>
                    </div>
                </li>

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">SC/PWD(20%)</p>
                    </div>
                </li>



                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">VAT Amount</p>
                    </div>
                </li>

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Net Sales</p>
                    </div>
                </li>

            </ul>

            <div class="w-full my-4 border-b border-black"> </div>

            @foreach ($transactions as $transaction)
                <ul class="grid justify-between grid-flow-col grid-cols-8 mx-4 ">

                    <li class="col-span-2 py-[3px]">
                        <div>
                            <p class="text-[0.8em] text-left font-medium">
                                {{ $transaction->transaction_number }}</p>
                        </div>
                    </li>
                    <li class="col-span-2 py-[3px]">
                        <div>
                            <p class="text-[0.8em] text-left font-medium">
                                {{ $transaction->transaction_type }}</p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[0.8em] text-left font-bold">
                                {{ $transaction->created_at->format('H:i:s') }}
                            </p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[0.8em] text-center fot-bold">
                                {{ number_format($transaction->total_amount, 2) }}

                            </p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[0.8em] text-center fot-bold">
                                {{ number_format($transaction->total_discount_amount, 2) }}
                            </p>
                        </div>
                    </li>

                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[0.8em] text-center fot-bold">
                                {{ number_format($transaction->total_vat_amount, 2) }}
                            </p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[0.8em] text-center fot-bold">
                                aiah
                            </p>
                        </div>
                    </li>

                </ul>
            @endforeach
        </div>
    </div>
</div>
