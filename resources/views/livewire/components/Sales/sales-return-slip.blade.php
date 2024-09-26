<div x-cloak class="flex justify-center w-full">
    <div class=" w-full max-w-[216px]">
        <div class="w-full border-2 h-fit">
            <div class="flex flex-col justify-center mx-3 mb-6 text-center">
                <div class="font-black ">
                    <p class="text-[0.6em] uppercase">JK FROZEN PRODUCTS AND CONSUMER SUPPLIES STORE</p>
                </div>
                <div>
                    <p class="text-[0.6em] uppercase">Quezon Avenue St., Poblacion, Tacurong City, Sultan Kudarat</p>
                </div>
                <div>
                    <p class="text-[0.6em] uppercase">Non-VAT Reg TIN 936-196-461-0000</p>
                </div>
            </div>
            <div class="flex flex-col justify-between px-4 mb-2">
                <div class="flex flex-col ">
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Date & Time:</p>
                        <p class="text-[0.6em] font-bold uppercase">
                            {{ $dateCreated ?? 'N/A'  }}
                        </p>
                    </div>

                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Return No.</p>
                        <p class="text-[0.6em] font-bold uppercase">{{ $return_number ?? 'N/A'  }}</p>
                    </div>
                    <br>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Transaction No.</p>
                        <p class="text-[0.6em] font-bold uppercase">{{ $transaction_number ?? 'N/A'  }}</p>
                    </div>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Date of Purchase</p>
                        <p class="text-[0.6em] font-bold uppercase">{{ $transaction_date ?? 'N/A' }}</p>
                    </div>

                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Prepared By:</p>
                        <p class="text-[0.6em] font-bold uppercase">{{ $user ?? 'N/A'  }}</p>

                    </div>
                    <br>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Total Return Amount</p>
                        <p class="text-[0.6em] font-bold uppercase">
                            {{ item_return_amount }}</p>
                    </div>
                </div>
            </div>
            <div class="mx-4">
                <span class="">------------------------</span>
                {{-- //* table header --}}
                <ul class="grid justify-between grid-flow-col grid-cols-4">
                    <li class="col-span-1 ">
                        <div>
                            <p class="text-[0.6em]  font-bold">Qty</p>
                        </div>
                    </li>
                    <li class="col-span-4 ">
                        <div>
                            <p class="text-[0.6em] font-bold">Description(s)</p>
                        </div>
                    </li>
                    <li class="col-span-1 ">
                        <div>
                            <p class="text-[0.6em] font-bold">Price</p>
                        </div>
                    </li>
                </ul>
                <span class="">------------------------</span>
                {{-- @if (isset($receiptDetails['selectedItems']) && is_array($receiptDetails['selectedItems']))
                    @foreach ($receiptDetails['selectedItems'] as $item) --}}
                <ul class="grid justify-between grid-flow-col grid-cols-4">
                    <li class="col-span-1 py-[3px]">
                        <div>
                            {{-- <p class="text-[0.6em] uppercase text-center font-medium">
                                        {{ $item['quantity'] }}</p> --}}
                        </div>
                    </li>
                    <li class="col-span-4 py-[3px]">
                        <div class="flex flex-col px-[3px] max-w-[90px] break-all leading-none">
                            <div class=" text-wrap">
                                {{-- <p class="text-[0.6em] flex uppercase text-justify font-bold">
                                            {{ $item['item_name'] }} {{ $item['item_description'] }}
                                        </p> --}}
                            </div>
                            <div class="flex flex-col w-full justify-center gap-[3px]">
                                <div class="flex flex-row justify-end gap-[5px]">
                                    <p class="text-[0.6em] uppercase text-justify italic font-bold">RP</p>
                                    {{-- <p class="text-[0.6em] uppercase text-justify italic font-bold">
                                                {{ number_format($item['selling_price'], 2) }}</p> --}}
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-span-1 py-[3px]">
                        <div>
                            {{-- <p class="text-[0.6em] text-right uppercase font-bold">
                                        {{ number_format($item['total_amount'], 2) }}
                                    </p> --}}
                        </div>
                    </li>
                </ul>
                {{-- @endforeach
                @endif --}}
            </div>
        </div>
    </div>
</div>
