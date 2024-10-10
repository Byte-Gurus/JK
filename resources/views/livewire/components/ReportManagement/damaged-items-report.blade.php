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
        <div class="grid grid-flow-col grid-cols-2 ">

            <div class="flex flex-row text-nowrap">
                <p class="text-[1em] font-black uppercase">Specified Date:</p>
                {{ $fromDate . ' - ' . $toDate}}

            </div>

            <div>
                <p class="text-[1.4em] font-bold text-right italic m-4 mr-10 uppercase">DAMAGED ITEM LIST REPORT</p>
            </div>

        </div>
        <div>
            <div class="w-full my-4 border-b border-black"> </div>
            <ul class="grid justify-between grid-flow-col grid-cols-3 mx-4 ">

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[1em] uppercase text-left font-bold">Barcode</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[1em] uppercase text-center font-bold">Item Name</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[1em] uppercase text-center font-bold">Item Description</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[1em] uppercase text-center font-bold">Item Quantity</p>
                    </div>
                </li>
            </ul>

            <div class="w-full my-4 border-b border-black"> </div>
            @if ($damagedItems)
                @foreach ($damagedItems as $damagedItem)
                    <ul class="grid justify-between grid-flow-col grid-cols-3 mx-4 ">

                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[1em] text-left font-medium">
                                    {{ $damagedItem->transactionDetailsJoin->itemJoin->barcode }}</p>
                            </div>
                        </li>
                        <li class="col-span-1 text-center py-[3px]">
                            <div>
                                <p class="text-[1em] text-center font-bold">
                                    {{ $damagedItem->transactionDetailsJoin->itemJoin->item_name }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 text-center py-[3px]">
                            <div>
                                <p class="text-[1em] text-center font-bold">
                                    {{ $damagedItem - transactionDetailsJoin->itemJoin->item_description }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[1em] text-center fot-bold">
                                    {{ $damagedItem->item_return_amount }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[1em] text-center fot-bold">
                                    {{ $damagedItem->created_at }}
                                </p>
                            </div>
                        </li>
                    </ul>
                @endforeach
            @endif
        </div>
        <div class="px-4 py-4 ">
            <div class="flex flex-row text-nowrap">
                <p class="text-[1em] font-bold uppercase">Date & Time Created:</p>
                {{ $dateCreated }}
            </div>
            <div class="flex flex-row py-4 text-nowrap">
                <p class="text-[1em] font-bold uppercase">Prepared By:</p>
                {{ $createdBy }}
            </div>
        </div>
    </div>
</div>
