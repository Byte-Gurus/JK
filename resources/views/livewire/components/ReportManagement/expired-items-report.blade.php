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
        <div class="grid items-center grid-flow-col m-4 ">

            <div class="flex flex-row gap-2 text-nowrap">
                <p class="text-[1em] font-black uppercase">Report as of</p>
                <p>
                    {{ $fromDate . ' - ' . $toDate }}
                </p>
            </div>

            <div>
                <p class="text-[1.4em] font-bold text-right italic mr-10 uppercase">EXPIRED ITEM LIST REPORT</p>
            </div>

        </div>

        <div>
            <div class="w-full my-4 border-b border-black"> </div>

            <ul class="grid items-center justify-between grid-flow-col grid-cols-6 mx-4 ">
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">Expiration Date</p>
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
                        <p class="text-[0.8em] uppercase text-right font-bold">Item Quantity</p>
                    </div>
                </li>
            </ul>

            <div class="w-full my-4 border-b border-black"> </div>
            @if ($isTransactionEmpty)
            <p class="w-full my-8 text-center text-[2em] font-black opacity-30">NO EXPIRED ITEMS FOUND FOR THIS DATE</p>
            @endif
            @if ($expiredItems)
            @foreach ($expiredItems as $expiredItem)
            <ul class="grid justify-between grid-flow-col grid-cols-6 mx-4 ">
                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-left font-medium">
                            {{ $expiredItem->date->format('M d Y') }}
                        </p>
                    </div>
                </li>
                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-left font-medium">
                            {{ $expiredItem->barcode }}</p>
                    </div>
                </li>
                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-left font-medium">
                            {{ $expiredItem->sku_code }}</p>
                    </div>
                </li>
                <li class="col-span-1 text-center py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-center font-medium">
                            {{ $expiredItem->item_name }}
                        </p>
                    </div>
                </li>
                <li class="col-span-1 text-center py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-center font-medium">
                            {{ $expiredItem->item_description }}
                        </p>
                    </div>
                </li>
                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-right font-medium">
                            {{ $expiredItem->quantity }}
                        </p>
                    </div>
                </li>

            </ul>
            @endforeach
            @endif
        </div>
        @if (!$isTransactionEmpty)
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
        @endif
    </div>
</div>
