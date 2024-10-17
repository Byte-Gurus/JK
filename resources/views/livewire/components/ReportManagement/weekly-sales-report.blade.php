<div x-cloak class="flex justify-center ">
    <div class="w-[816px] max-h-[1056px] h-full border border-black">
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
                    <p class="text-[0.8em] uppercase">VAT Reg TIN 936-196-461-0000</p>
                </div>
            </div>
        </div>
        <div>
            <p class="text-[2em] font-bold text-right italic m-4 mr-10 uppercase">WEEKLY SALES REPORT</p>
        </div>
        @if ($transaction_info)
            <div class="grid grid-flow-col grid-cols-2 ">
                <div class="flex flex-col items-start justify-end col-span-1 px-4 mb-2 ">
                    <div class="flex flex-col ">
                        <div class="flex flex-row gap-2 text-nowrap">
                            <p class="text-[1em] font-black uppercase">Specified Week:</p>
                            <p>
                                {{ $transaction_info['date'] }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col justify-between col-span-1 px-4 mb-2">
                    <div class="grid grid-flow-row border border-black">
                        <div class="grid grid-flow-col grid-cols-12 border border-black text-nowrap">
                            <p class=" col-span-8 w-1/2 text-[1em] font-bold uppercase">Gross Sales</p>
                            <p class="col-span-1 ">|</p>
                            <p class=" col-span-3 text[1em] text-right">
                                {{ number_format($transaction_info['totalGross'], 2) }}</p>
                        </div>
                        <div class="grid grid-flow-col grid-cols-12 border border-black text-nowrap">
                            <p class=" col-span-8 w-1/2 text-[1em] font-bold uppercase">Tax Amount</p>
                            <p class="col-span-1 ">|</p>
                            <p class=" col-span-3 text[1em] text-right">
                                {{ number_format($transaction_info['totalTax'], 2) }}</p>
                        </div>
                        <div class="grid grid-flow-col grid-cols-12 border border-black text-nowrap">
                            <p class=" col-span-8 w-1/2 text-[1em] font-bold uppercase">Net Sales </p>
                            <p class="col-span-1 ">|</p>
                            <p class=" col-span-3 text[1em] text-right">
                                {{ number_format($transaction_info['totalNet'], 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div>
            <div class="w-full my-4 border-b border-black"> </div>

            {{-- //* table header --}}
            <ul class="grid items-center justify-between grid-flow-col grid-cols-4 mx-4 ">

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">Date</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-right font-bold">Gross Sales (₱)</p>
                    </div>
                </li>
                {{-- <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Voided Amount(₱)</p>
                    </div>
                </li> --}}
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-right font-bold">VAT Amount (₱)</p>
                    </div>
                </li>
                {{-- <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Voided VAT Amount(₱)</p>
                    </div>
                </li> --}}
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-right font-bold">Net Sales (₱)</p>
                    </div>
                </li>
            </ul>

            <div class="w-full my-4 border-b border-black"> </div>
            @if (!$hasTransactions)
                <p class="w-full my-8 text-center text-[2em] font-black opacity-30">NO TRANSACTIONS FOUND FOR THIS DATE</p>
            @endif
            @if ($transaction_info)
                @foreach ($transaction_info['weeklySummaries'] as $date => $summary)
                    <ul class="grid justify-between grid-flow-col grid-cols-4 mx-4">
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-left font-medium">
                                    {{ $date }}
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-right font-bold">
                                    {{ number_format($summary['totalGross'], 2) }}</p>
                            </div>
                        </li>
                        {{-- <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-center font-bold">
                            {{ number_format($summary['totalVoidAmount'] * -1, 2) }}</p>
                    </div>
                </li> --}}
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-right font-bold">
                                    {{ number_format($summary['totalTax'], 2) }}</p>
                            </div>
                        </li>
                        {{-- <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-center font-bold">
                            {{ number_format($summary['totalVoidVatAmount'] * -1, 2) }}</p>
                    </div>
                </li> --}}
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-right font-bold">
                                    {{ number_format($summary['totalNet'], 2) }}
                                </p>
                            </div>
                        </li>
                    </ul>
                @endforeach
                <ul class="grid justify-between grid-flow-col grid-cols-4 mx-4 border-black border-y ">
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[1em] text-left font-bold">Total</p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[1em] text-right font-bold">
                                {{ number_format($transaction_info['totalGross'], 2) }}</p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[1em] text-right font-bold">
                                {{ number_format($transaction_info['totalTax'], 2) }}</p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[1em] text-right font-bold">
                                {{ number_format($transaction_info['totalNet'], 2) }}</p>
                        </div>
                    </li>
                </ul>
            @endif
        </div>
        @if ($transaction_info)
            <div class="px-4 py-4">
                <div class="flex flex-row gap-2 text-nowrap">
                    <p class="text-[1em] font-bold uppercase">Date & Time Created:</p>
                    <p>
                        {{ $transaction_info['dateCreated'] }}
                    </p>
                </div>
                <div class="flex flex-row gap-2 py-4 text-nowrap">
                    <p class="text-[1em] font-bold uppercase">Prepared By:</p>
                    <p>
                        {{ $transaction_info['createdBy'] }}
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
