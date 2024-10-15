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
        <div class="grid grid-flow-col ">
            <div>
                <p class="text-[1.4em] self-end font-bold text-right italic m-4 mr-10 uppercase">STOCK-ON-HAND REPORT
                </p>
            </div>
        </div>

        <div>
            <div class="w-full my-4 border-b border-black"> </div>

            <ul class="grid justify-between grid-flow-col grid-cols-4 mx-4 ">

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[1em] uppercase text-left font-bold">Barcode</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[1em] uppercase text-left font-bold">Item Name</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[1em] uppercase text-left font-bold">Item Description</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[1em] uppercase text-right font-bold">Item Quantity</p>
                    </div>
                </li>
            </ul>

            <div class="w-full my-4 border-b border-black"> </div>
            @if ($isTransactionEmpty)
                <p class="w-full my-8 text-center text-[2em] font-black opacity-30">NO DATA IN THIS DATE</p>
            @endif
            @foreach ($inventories as $inventory)
                <ul class="grid justify-between grid-flow-col grid-cols-4 mx-4 ">

                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[1em] text-left font-medium">
                                {{ $inventory->itemJoin->barcode }}</p>
                        </div>
                    </li>
                    <li class="col-span-1 text-left py-[3px]">
                        <div>
                            <p class="text-[1em] text-left font-medium">
                                {{ $inventory->itemJoin->item_name }}
                            </p>
                        </div>
                    </li>
                    <li class="col-span-1 text-left py-[3px]">
                        <div>
                            <p class="text-[1em] text-left font-medium">
                                {{ $inventory->itemJoin->item_description }}
                            </p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[1em] text-right font-medium">
                                {{ $inventory->current_stock_quantity }}
                            </p>
                        </div>
                    </li>
                </ul>
            @endforeach
        </div>
        <div class="px-4 py-4">
            <div class="flex flex-row gap-2 text-nowrap">
                <p class="text-[1em] font-bold uppercase">Date & Time Created:</p>
                <p>{{ $dateCreated }}</p>
                </p>
            </div>
            <div class="flex flex-row gap-2 py-4 text-nowrap">
                <p class="text-[1em] font-bold uppercase">Prepared By:</p>
                <p>
                    {{ $createdBy }}
                </p>
            </div>
        </div>
    </div>
</div>
