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
        {{-- @if ($deliverylist_info) --}}
        <div class="grid items-center grid-flow-col grid-cols-2 ">
            <div class="flex flex-col justify-between col-span-1 px-4">
                <div class="flex flex-col ">
                    <div class="flex flex-row gap-2 text-nowrap">
                        <p class="text-[1em] font-black uppercase">Report as of</p>
                        <p class="text-[1em] font-medium uppercase">{{ $date ?? ' ' }}</p>
                    </div>
                </div>
            </div>
            <div>
                <p class="text-[1.4em] font-bold text-right italic m-4 mr-10 uppercase">DELIVERY LIST REPORT</p>
            </div>
        </div>
        {{-- @endif --}}

        <div>
            <div class="w-full my-4 border-b border-black"> </div>

            <ul class="grid justify-between grid-flow-col grid-cols-6 mx-4 ">

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[1em] uppercase text-left font-bold">PO Date</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[1em] uppercase text-left font-bold">PO #</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[1em] uppercase text-left font-bold">Delivery ID</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[1em] uppercase text-left font-bold">Delivery Receipt No.</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[1em] uppercase text-left font-bold">Status</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[1em] uppercase text-left font-bold">Date Delivered</p>
                    </div>
                </li>

            </ul>

            <div cwlass="w-full my-4 border-b border-black"> </div>
            @if (!$deliveries)
            <p class="w-full my-8 text-center text-[2em] font-black opacity-30">NO DELIVERY FOUND AVAILABLE</p>
            @else
            @foreach ($deliveries as $delivery)
            <ul class="grid justify-between grid-flow-col grid-cols-6 mx-4 ">
                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[1em] text-left font-medium">
                            {{ $delivery->created_at->format('M d Y') }}</p>
                    </div>
                </li>
                <li class="col-span-1 text-left py-[3px]">
                    <div>
                        <p class="text-[1em] text-left font-medium">
                            {{ $delivery->purchaseJoin->po_number }}
                        </p>
                    </div>
                </li>
                <li class="col-span-1 text-left py-[3px]">
                    <div>
                        <p class="text-[1em] text-center font-medium">
                            {{ $delivery->id }}
                        </p>
                    </div>
                </li>
                <li class="col-span-1 text-left py-[3px]">
                    <div>
                        <p class="text-[1em] text-left font-medium">
                            {{ $delivery->receipt_number ?? 'N/A' }}
                        </p>
                    </div>
                </li>
                <li class="col-span-1 text-left py-[3px]">
                    <div>
                        <p class="text-[1em] text-left font-medium">
                            {{ $delivery->status }}
                        </p>
                    </div>
                </li>
                <li class="col-span-1 text-left py-[3px]">
                    <div>
                        <p class="text-[1em] text-left font-medium">
                            @if ($delivery->date_delivered == 'N/A')
                            N/A
                            @else
                            {{ \Carbon\Carbon::parse($delivery->date_delivered)->format('M d Y') }}
                            @endif

                        </p>
                    </div>
                </li>

            </ul>
            @endforeach
            @endif
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
