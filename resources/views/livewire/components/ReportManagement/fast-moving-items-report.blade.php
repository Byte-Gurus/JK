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
                    <p class="text-[0.8em] uppercase">Non-VAT Reg TIN 936-196-461-0000</p>
                </div>
            </div>
        </div>
    </div>
    @if ($fastmoving_info)
        <div class="flex flex-col justify-between col-span-1 px-4 mb-2">
            <div class="flex flex-col ">
                <div class="flex flex-row text-nowrap">
                    <p class="text-[1em] font-bold uppercase">Date & Time Created:</p>
                    {{ $fastmoving_info['dateCreated'] }}


                    </p>
                </div>
                <div class="flex flex-row text-nowrap">
                    <p class="text-[1em] font-bold uppercase">Prepared By:</p>
                    {{ $fastmoving_info['createdBy'] }}

                </div>
                <div class="flex flex-row text-nowrap">
                    <p class="text-[1em] font-black uppercase">Selected Date:</p>
                    {{ $fastmoving_info['date'] }}
                </div>
            </div>

        </div>
    @endif

    <div>
        <div class="w-full my-4 border-b border-black"> </div>

        {{-- //* table header --}}
        <ul class="grid justify-between grid-flow-col grid-cols-5 mx-4 ">

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

        @if ($fastmoving_info)
            @foreach ($fastmoving_info as $index => $fastmoving_info)
                <ul class="grid justify-between grid-flow-col grid-cols-5 mx-4 ">

                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[0.8em] text-left font-medium">
                                {{ $fastmoving_info['barcodee'] }}</p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[0.8em] text-left font-bold">
                                {{ $fastmoving_info['item_name'] }}
                            </p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[0.8em] text-center fot-bold">
                                {{ $fastmoving_info['item_description'] }}
                            </p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[0.8em] text-center fot-bold">

                                {{ $fastmoving_info['aii'] }}
                            </p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[0.8em] text-center fot-bold">

                                {{ $fastmoving_info['tsi'] }}
                            </p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[0.8em] text-center fot-bold">
                                {{ $fastmoving_info['fast_slow'] }}
                            </p>
                        </div>
                    </li>
                </ul>
            @endforeach
        @endif

    </div>

</div>
