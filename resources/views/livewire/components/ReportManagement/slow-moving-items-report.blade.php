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
        @if ($slowmoving_info)
            <div class="grid items-center grid-flow-col grid-cols-2 ">
                <div class="flex flex-col justify-between col-span-1 px-4">
                    <div class="flex flex-col ">
                        <div class="flex flex-row gap-2 text-nowrap">
                            <p class="text-[1em] font-black uppercase">Specified Date:</p>
                            <p class="text-[1em] font-medium uppercase">{{ $date ?? ' ' }}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-[1.4em] font-bold text-right italic m-4 mr-10 uppercase">SLOW MOVING ITEMS REPORT</p>
                </div>
            </div>
        @endif
        <div>
            <div class="w-full my-4 border-b border-black"> </div>

            {{-- //* table header --}}
            <ul class="grid justify-between grid-flow-col grid-cols-6 mx-4 ">

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">Barcode</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">Item Name</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">Item Description</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">AVG Inventory of Item</p>
                    </div>
                </li>

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Total Sales of Item</p>
                    </div>
                </li>

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Turn Over Rate</p>
                    </div>
                </li>

            </ul>

            <div class="w-full my-4 border-b border-black"> </div>

            @if ($slowmoving_info)
                @foreach ($slowmoving_info as $index => $slowmoving_info)
                    <ul class="grid justify-between grid-flow-col grid-cols-6 mx-4 ">

                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-left font-medium">
                                    {{ $slowmoving_info['barcode'] }}</p>
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-left font-bold">
                                    {{ $slowmoving_info['item_name'] }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-left font-bold">
                                    {{ $slowmoving_info['item_description'] }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-center font-bold">

                                    {{ $slowmoving_info['aii'] }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-center font-bold">

                                    {{ $slowmoving_info['tsi'] }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-center font-bold">
                                    {{ number_format($slowmoving_info['fast_slow'], 2) }}
                                </p>
                            </div>
                        </li>
                    </ul>
                @endforeach
            @endif
        </div>
        @if ($slowmoving_info)
            <div class="px-4 py-4 ">
                <div class="flex flex-row gap-2 text-nowrap">
                    <p class="text-[1em] font-bold uppercase">Date & Time Created:</p>
                    <p>{{ $dateCreated }}</p>
                </div>
                <div class="flex flex-row gap-2 py-4 text-nowrap">
                    <p class="text-[1em] font-bold uppercase">Prepared By:</p>
                    <p>
                        {{ $createdBy }}
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
