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
        <div class="grid items-center grid-flow-col m-4">
            <div class="flex flex-row gap-2 text-nowrap">
                <p class="text-[1em] font-black uppercase">Report as of</p>
                <p>
                    {{ $fromDate . ' - ' . $toDate }}
                </p>
            </div>

            <div>
                <p class="text-[1.2em] font-bold text-right italic mr-10 uppercase">VOIDED TRANSACTIONS REPORT</p>
            </div>

            {{-- <div class="flex flex-col self-start justify-between px-4 mb-2">
                <div class="flex flex-row border border-black text-nowrap">
                    <p class="text-[1em] font-black border-r border-black uppercase">Total Sales Return </p>
                    {{ number_format($transaction_info['totalNet'], 2) }}
                </div>
            </div> --}}
        </div>

        <div>
            <div class="w-full my-4 border-b border-black"> </div>

            <ul class="grid items-center justify-between grid-flow-col grid-cols-7 mx-4">
                <li class="col-span-2 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">Transaction No.</p>
                    </div>
                </li>

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">Barcode</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">SKU</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Item Name</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Item Description</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Voided Qty</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-right font-bold">Voided Amount (₱)</p>
                    </div>
                </li>

            </ul>

            <div class="w-full my-4 border-b border-black"> </div>
            @if ($isTransactionEmpty)
            <p class="w-full my-8 text-center text-[2em] font-black opacity-30">NO TRANSACTIONS FOUND FOR THIS DATE</p>
            @endif
            @if ($voidTransactions)
            @foreach ($voidTransactions as $voidTransaction)
            <ul class="grid justify-between grid-flow-col grid-cols-8 mx-4">

                <li class="col-span-2 py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-left font-medium">
                            {{ $voidTransaction->void_number }}</p>
                    </div>
                </li>


                <li class="col-span-1 py-[3px]">
                    <div>
                        @foreach ($voidTransaction->voidTransactionDetailsJoin as $voidItem)
                        <p class="text-[0.8em] text-left font-medium">
                            {{ $voidItem->transactionDetailsJoin->itemJoin->barcode }}</p>
                        @endforeach

                    </div>
                </li>
                <li class="col-span-1 py-[3px]">
                    <div>
                        @foreach ($voidTransaction->voidTransactionDetailsJoin as $voidItem)
                        <p class="text-[0.8em] text-left font-medium">
                            {{ $voidItem->transactionDetailsJoin->itemJoin->sku_code }}</p>
                        @endforeach
                    </div>
                </li>
                <li class="col-span-1 text-center py-[3px]">
                    <div>
                        @foreach ($voidTransaction->voidTransactionDetailsJoin as $voidItem)
                        <p class="text-[0.8em] text-left font-medium">
                            {{ $voidItem->transactionDetailsJoin->itemJoin->item_name }}</p>
                        @endforeach
                    </div>
                </li>
                <li class="col-span-1 text-center py-[3px]">
                    <div>
                        @foreach ($voidTransaction->voidTransactionDetailsJoin as $voidItem)
                        <p class="text-[0.8em] text-left font-medium">
                            {{ $voidItem->transactionDetailsJoin->itemJoin->item_description }}</p>
                        @endforeach
                    </div>
                </li>
                <li class="col-span-1 text-center py-[3px]">
                    <div>
                        @foreach ($voidTransaction->voidTransactionDetailsJoin as $voidItem)
                        <p class="text-[0.8em] text-left font-medium">
                            {{ $voidItem->void_quantity }}</p>
                        @endforeach
                    </div>
                </li>
                <li class="col-span-1 text-center py-[3px]">
                    <div>
                        @foreach ($voidTransaction->voidTransactionDetailsJoin as $voidItem)
                        <p class="text-[0.8em] text-right font-medium">
                            {{ number_format($voidItem->item_void_amount, 2) }}</p>
                        @endforeach
                    </div>
                </li>
            </ul>
            @endforeach
            @endif

        </div>
        <div class="px-4 py-4 ">
            <div class="flex flex-row gap-2 text-nowrap">
                <p class="text-[1em] font-bold uppercase">Date & Time Created:</p>
                <p>
                    {{ $dateCreated }}
                </p>
            </div>
            <div class="flex flex-row gap-2 text-nowrap">
                <p class="text-[1em] font-bold uppercase">Prepared By:</p>
                <p>
                    {{ $createdBy }}
                </p>
            </div>
        </div>
    </div>
</div>
