<div x-cloak class="flex justify-center h-fit">

    <div class="  w-[816px] border border-black">
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
            <p class="text-[2em] font-bold text-right italic m-4 mr-10 uppercase">DAILY SALES REPORT</p>
        </div>
        {{-- @if ($transaction_info && $hasTransactions) --}}
            <div class="grid grid-flow-col grid-cols-2 ">
                <div class="flex flex-col items-start justify-end col-span-1 px-4 mb-2 ">
                    <div class="flex flex-col ">
                        <div class="flex flex-row gap-2 text-nowrap">
                            <p class="text-[1em] font-black uppercase">Report as of</p>
                            <p>
                                {{-- {{ $transaction_info['date'] }} --}}
                            </p>
                        </div>
                    </div>
                </div>
                {{-- <div class="flex flex-col justify-between col-span-1 px-4 mb-2">
                    <div class="grid grid-flow-row ">
                        <div class="grid grid-flow-col grid-cols-12 border-b border-black text-nowrap">
                            <p class=" col-span-8 w-1/2 text-[1em] font-bold uppercase">Gross Sales</p>
                            <p class=" col-span-3 text[1em] text-right">
                                {{ number_format($transaction_info['totalGross'], 2) }}</p>
                        </div>
                        <div class="grid grid-flow-col grid-cols-12 border-b border-black text-nowrap">
                            <p class=" col-span-8 w-1/2 text-[1em] font-bold uppercase">Discount Amount</p>
                            <p class=" col-span-3 text[1em] text-right">
                                {{ number_format($transaction_info['totalDiscount'], 2) }}</p>
                        </div>
                        <div class="grid grid-flow-col grid-cols-12 border-b border-black text-nowrap">
                            <p class=" col-span-8 w-1/2 text-[1em] font-bold uppercase">Tax Amount</p>
                            <p class=" col-span-3 text[1em] text-right">
                                {{ number_format($transaction_info['totalTax'], 2) }}</p>
                        </div>
                        <div class="grid items-center justify-between grid-flow-col border-black text-nowrap">
                            <p class="text-[1.4em] font-black uppercase pr-2">Net Sales </p>
                            <p class="text-[1.4em] font-black text-right">
                               123,123,123,123.00</p>
                        </div>
                    </div>
                </div> --}}
            </div>
        {{-- @endif --}}
    </div>
</div>
