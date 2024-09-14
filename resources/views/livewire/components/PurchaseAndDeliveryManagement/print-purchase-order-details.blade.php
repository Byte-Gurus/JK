<div x-cloak class="flex justify-center w-full h-full">
    <div class="w-full p-2">
        <div class="w-full border-2 h-fit">
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
            <div class="flex flex-col justify-between px-4 mb-2">
                <div class="flex flex-col ">
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[1em] font-bold uppercase">Purchase Order No.</p>
                        <p class="text-[1em] font-bold uppercase">{{$purchase->po_number ?? null}}</p>
                        {{-- {{ $receiptDetails['transaction_info']['transaction_date'] ?? null }} --}}
                        </p>
                    </div>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[1em] font-bold uppercase">Date & Time Created:</p>
                        <p class="text-[1em] font-bold uppercase"></p>
                        {{-- {{ $receiptDetails['transaction_info']['transaction_date'] ?? null }} --}}
                        </p>
                    </div>

                    <div class="flex flex-row text-nowrap">
                        <p class="text-[1em] font-bold uppercase">Supplier Name:</p>
                        <p class="text-[1em] font-bold uppercase"></p>
                        {{-- {{ $receiptDetails['payment']['payment_type'] ?? null }}</p> --}}
                    </div>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[1em] font-bold uppercase">Prepared By:</p>
                        <p class="text-[1em] font-bold uppercase"></p>
                        {{-- {{ $receiptDetails['payment']['payment_type'] ?? null }}</p> --}}
                    </div>
                </div>
            </div>

            <div>
                <div class="w-full my-4 border-b border-black"> </div>

                {{-- //* table header --}}
                <ul class="flex flex-row justify-between mx-8 ">
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
                            <p class="text-[1em] uppercase text-center font-bold">Purchase Quantity</p>
                        </div>
                    </li>

                </ul>

                <div class="w-full my-4 border-b border-black"> </div>

                {{-- @if (isset($receiptDetails['selectedItems']) && is_array($receiptDetails['selectedItems']))
                    @foreach ($receiptDetails['selectedItems'] as $item) --}}
                <ul class="flex flex-row justify-between mx-8">
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[1em] text-left font-medium">
                                barcode</p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[1em] text-left font-bold">
                                item name
                            </p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[1em] text-center fot-bold">
                                purchase quantity
                            </p>
                        </div>
                    </li>
                </ul>
                {{-- @endforeach
                @endif --}}
            </div>
        </div>
    </div>
</div>
