<div x-cloak class="flex justify-center ">
    <div class="w-[816px] max-h-[1056px] h-full border border-black">
        <div class="flex flex-col justify-center mx-3 mb-6 text-center">
            <div class="font-black ">
                <p class="text-[1em] uppercase">JK FROZEN PRODUCTS AND CONSUMER SUPPLIES STORE</p>
            </div>
            <div>
                <p class="text-[1em] uppercase">Quezon Avenue St., Poblacion, Tacurong City, Sultan Kudarat</p>
            </div>
            <div>
                <p class="text-[1em] uppercase">Non-VAT Reg TIN 936-196-461-0000</p>
            </div>
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
            </div>
            <div>
                <p class="text-[1.4em] font-bold text-right italic m-4 mr-10 uppercase">EXPIRED ITEMS LIST REPORT</p>
            </div>
        </div>

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
                        <p class="text-[0.8em] uppercase text-left font-bold">SKU</p>
                    </div>
                </li>

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">Item Description</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Item Quantity</p>
                    </div>
                </li>

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Date</p>
                    </div>
                </li>

            </ul>

            <div class="w-full my-4 border-b border-black"> </div>

            {{-- @foreach ($purchaseDetails as $purchaseDetail) --}}
            <ul class="grid justify-between grid-flow-col grid-cols-5 mx-4 ">

                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-left font-medium">
                            hiii</p>
                    </div>
                </li>
                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-left font-bold">
                            hello
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
                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-center fot-bold">
                            aiah
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
            {{-- @endforeach --}}
        </div>
    </div>
</div>
