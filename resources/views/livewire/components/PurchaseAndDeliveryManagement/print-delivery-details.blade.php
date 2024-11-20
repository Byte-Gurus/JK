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
        <div class="flex flex-row justify-between px-4 mb-2">
            <div class="flex flex-col ">
                <div class="flex flex-row text-nowrap">
                    <p class="text-[1em] font-bold uppercase">Purchase Order No.</p>
                    {{-- <p class="text-[1em] font-bold uppercase">{{ $po_number }}</p> --}}
                    </p>
                </div>
                <div class="flex flex-row text-nowrap">
                    <p class="text-[1em] font-bold uppercase">Purchase Order Date</p>
                    {{-- <p class="text-[1em] font-bold uppercase">{{ $supplier }}</p> --}}
                </div>
            </div>
            <div class="flex flex-col ">
                <div class="flex flex-row text-nowrap">
                    <p class="text-[1em] font-bold uppercase">Date Delivered</p>
                    {{-- <p class="text-[1em] font-bold uppercase">{{ $po_number }}</p> --}}
                    </p>
                </div>
            </div>
        </div>

        <div>
            <div class="w-full my-4 border-b border-black"> </div>

            {{-- //* table header --}}
            <ul class="grid justify-between grid-flow-col grid-cols-8 mx-4 ">

                <li class="col-span-1 ">
                    <div>
                        <p class="font-bold text-left uppercase text-md">SKU</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="font-bold text-left uppercase text-md">Item Name</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="font-bold text-left uppercase text-md">Desc</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="font-bold text-left uppercase text-md">Unit</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="font-bold text-left uppercase text-md">Item Cost</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="font-bold text-left uppercase text-md">Restock Qty</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="font-bold text-left uppercase text-md">Exp Date</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="font-bold text-left uppercase text-md">Purchase Qty</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="font-bold text-left uppercase text-md">Backorder Qty</p>
                    </div>
                </li>
            </ul>

            <div class="w-full my-4 border-b border-black"> </div>

            @foreach ($inventories as $inventory)
            <ul class="grid justify-between grid-flow-col grid-cols-3 mx-4 ">

                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[1em] text-left font-medium">
                            {{ $inventory->sku_code }}</p>
                    </div>
                </li>
                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[1em] text-left font-bold">
                            {{ $inventory->itemJoin->item_name }}
                        </p>
                    </div>
                </li>
                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[1em] text-left font-bold">
                            {{ $inventory->itemJoin->item_description }}
                        </p>
                    </div>
                </li>
                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[1em] text-left font-bold">
                            {{ $inventory->itemJoin->item_unit }}
                        </p>
                    </div>
                </li>
                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[1em] text-center fot-bold">
                            {{ $inventory->cost }}
                        </p>
                    </div>
                </li>
                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[1em] text-center fot-bold">
                            {{ $inventory->stock_in_quantity }}
                        </p>
                    </div>
                </li>
                <div>
                    <p class="text-[1em] text-center fot-bold">
                        {{ $inventory->expiration_date ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <p class="text-[1em] text-center fot-bold">
                        {{ $inventory->deliveryJoin->purchaseJoin->purchaseDetailsJoin->purchase_quantity ?? 'N/A'}}
                    </p>
                </div>
                <div>
                    <p class="text-[1em] text-center fot-bold">
                        {{ $inventory->deliveryJoin->purchaseJoin->purchaseDetailsJoin->purchase_quantity -
                        $inventory->stock_in_quantity ?? 'N/A'}}
                    </p>
                </div>
                </li>

            </ul>
            @endforeach
        </div>
        <div class="px-4 py-4 ">
            <div class="flex flex-row gap-2 text-nowrap">
                <p class="text-[1em] font-bold uppercase">Date & Time Created:</p>
                {{-- <p>{{ $dateCreated }}</p> --}}
            </div>
            <div class="flex flex-row gap-2 text-nowrap">
                <p class="text-[1em] font-bold uppercase">Prepared By:</p>
                {{-- <p>{{ $createdBy }}</p> --}}
            </div>
        </div>
    </div>
</div>
