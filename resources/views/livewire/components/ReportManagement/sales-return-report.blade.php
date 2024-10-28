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
        <div class="flex flex-row items-center justify-between px-4 mb-2">
            <div class="flex flex-col items-center">
                <div class="flex flex-row gap-2 text-nowrap">
                    <p class="text-[1em] font-black uppercase">Report as of</p>
                    <p>
                        {{ $fromDate . ' - ' . $toDate }}
                    </p>
                </div>
            </div>
            <div>
                <p class="text-[1.2em] font-bold text-right italic m-4 mr-10 uppercase">SALES RETURN REPORT</p>
            </div>
        </div>
        <div>
            <div class="w-full my-4 border-b border-black"> </div>

            <ul class="grid items-center justify-between grid-flow-col grid-cols-8 mx-2 ">
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.6em] uppercase text-center font-bold">Transaction No.</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.6em] px-2 uppercase text-left font-bold">Barcode</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.6em] uppercase text-center font-bold">Item Name</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.6em] uppercase text-center font-bold">Item Description</p>
                    </div>
                </li>

                <li class="col-span-1">
                    <div>
                        <p class="text-[0.6em] uppercase text-center font-bold">Operation</p>

                    </div>
                </li>

                <li class="col-span-1">
                    <div>
                        <p class="text-[0.6em] uppercase text-center font-bold">Description</p>

                    </div>
                </li>

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.6em] uppercase text-right font-bold">Return Qty</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.6em] uppercase text-right font-bold">Return Amount (₱)</p>
                    </div>
                </li>
            </ul>

            <div class="w-full my-4 border-b border-black"> </div>
            @if ($isTransactionEmpty)
                <p class="w-full my-8 text-center text-[2em] font-black opacity-30">NO TRANSACTIONS FOUND FOR THIS DATE</p>
            @endif
            @if ($returnItems)
                @foreach ($returnItems as $returnItem)
                    <ul class="grid justify-between grid-flow-col grid-cols-8 mx-2 ">

                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.6em] text-left font-medium">
                                    {{ $returnItem->returnJoin->transactionJoin->transaction_number }}</p>
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.6em] px-2 text-left font-medium">
                                    {{ $returnItem->transactionDetailsJoin->itemJoin->barcode }}</p>
                            </div>
                        </li>
                        <li class="col-span-1 text-center py-[3px]">
                            <div>
                                <p class="text-[0.6em] text-center font-medium">
                                    {{ $returnItem->transactionDetailsJoin->itemJoin->item_name }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 text-center py-[3px]">
                            <div>
                                <p class="text-[0.6em] text-center font-medium">
                                    {{ $returnItem->transactionDetailsJoin->itemJoin->item_description }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 text-center py-[3px]">
                            <div>
                                <p class="text-[0.6em] text-center font-medium">
                                    {{ $returnItem->operation }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 text-center py-[3px]">
                            <div>
                                <p class="text-[0.6em] text-center font-medium">
                                    {{ $returnItem->description }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.6em] text-right font-medium">
                                    {{ $returnItem->return_quantity }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.6em] text-right font-medium">
                                    {{ $returnItem->item_return_amount }}
                                </p>
                            </div>
                        </li>
                    </ul>
                @endforeach
            @endif
        </div>
        <div class="px-4 py-4">
            <div class="flex flex-row gap-2 text-nowrap">
                <p class="text-[0.8em] font-bold uppercase">Date & Time Created:</p>
                <p>{{ $dateCreated }}</p>
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
