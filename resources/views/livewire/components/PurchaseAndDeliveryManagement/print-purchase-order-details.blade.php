<div x-cloak class="flex justify-center h-fit">

    <div class="w-[816px] max-h-[1056px] h-full border border-black">
        <div class="flex flex-row justify-around my-8">
            <div>
                <img src="{{ asset('jk-logo-cropped.png') }}" alt="logo" class="w-[120px]">
            </div>
            <div class="flex flex-col justify-center mx-3 mb-6 text-center">
                <div class="font-black ">
                    <p class="text-[1em] uppercase">JK FROZEN PRODUCTS AND CONSUMER SUPPLIES STORE</p>
                </div>
                <div>
                    <p class="text-[1em] uppercase">Quezon Avenue St., Poblacion, Tacurong City, Sultan Kudarat</p>
                </div>
                <div>
                    <p class="text-[1em] uppercase">VAT Reg TIN 936-196-461-0000</p>
                </div>
            </div>
        </div>
        <div class="flex flex-col justify-between px-4 mb-2">
            <div class="flex flex-col ">
                <div class="flex flex-row text-nowrap">
                    <p class="text-[1em] font-bold uppercase">Purchase Order No.</p>
                    <p class="text-[1em] font-bold uppercase">{{ $po_number }}</p>
                    {{-- {{ $receiptDetails['transaction_info']['transaction_date'] ?? null }} --}}
                    </p>
                </div>
                <div class="flex flex-row text-nowrap">
                    <p class="text-[1em] font-bold uppercase">Supplier Name:</p>
                    <p class="text-[1em] font-bold uppercase">{{ $supplier }}</p>
                    {{-- {{ $receiptDetails['payment']['payment_type'] ?? null }}</p> --}}
                </div>
            </div>
        </div>

        <div>
            <div class="w-full my-4 border-b border-black"> </div>

            {{-- //* table header --}}
            <ul class="grid justify-between grid-flow-col grid-cols-3 mx-4 ">

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
            @foreach ($purchaseDetails as $purchaseDetail)
                <ul class="grid justify-between grid-flow-col grid-cols-3 mx-4 ">

                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[1em] text-left font-medium">
                                {{ $purchaseDetail->itemsJoin->barcode }}</p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[1em] text-left font-bold">
                                {{ $purchaseDetail->itemsJoin->item_name }}
                            </p>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            <p class="text-[1em] text-center fot-bold">
                                {{ $purchaseDetail->purchase_quantity }}
                            </p>
                        </div>
                    </li>

                </ul>
            @endforeach
            {{-- @endforeach
                @endif --}}
        </div>
        <div class="px-4 py-4 ">
            <div class="flex flex-row gap-2 text-nowrap">
                <p class="text-[1em] font-bold uppercase">Date & Time Created:</p>
                <p>{{ $dateCreated }}</p>
                </p>
            </div>
            <div class="flex flex-row gap-2 text-nowrap">
                <p class="text-[1em] font-bold uppercase">Prepared By:</p>
                <p>{{ $createdBy }}</p>
            </div>
        </div>
    </div>
</div>
