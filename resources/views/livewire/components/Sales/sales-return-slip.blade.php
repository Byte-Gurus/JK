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
                            {{ $dateCreated ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Return No.</p>
                        <p class="text-[0.6em] font-bold uppercase">{{ $return_number ?? 'N/A' }}</p>
                    </div>
                    <br>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Transaction No.</p>
                        <p class="text-[0.6em] font-bold uppercase">{{ $transaction_number ?? 'N/A' }}</p>
                    </div>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Date of Purchase</p>
                        <p class="text-[0.6em] font-bold uppercase">{{ $transaction_date ?? 'N/A' }}</p>
                    </div>

                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Prepared By:</p>
                        <p class="text-[0.6em] font-bold uppercase">{{ $user ?? 'N/A' }}</p>

                    </div>
                    <br>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Total Return Amount</p>
                        <p class="text-[0.6em] font-bold uppercase"> {{ $item_return_amount ?? 'N/A' }}</p>
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

                @if ($return_details)
                    @foreach ($return_details as $return_detail)
                        <ul class="grid justify-between grid-flow-col grid-cols-4">
                            <li class="col-span-1 py-[3px]">
                                <div>
                                    <p class="text-[0.6em] uppercase text-center font-medium">
                                        {{ $return_detail->return_quantity }}</p>
                                </div>
                            </li>
                            <li class="col-span-4 py-[3px]">
                                <div class="flex flex-col px-[3px] max-w-[90px] break-all leading-none">
                                    <div class=" text-wrap">
                                        <p class="text-[0.6em] uppercase text-center font-medium">
                                            {{ $return_detail->transactionDetailsJoin->itemJoin->item_name . ' ' . $return_detail->transactionDetailsJoin->itemJoin->description }}
                                        </p>
                                    </div>
                                    <div class="flex flex-col w-full justify-center gap-[3px]">
                                        <div class="flex flex-row justify-end gap-[5px]">
                                            <p class="text-[0.6em] uppercase text-center font-medium">
                                                {{ $return_detail->transactionDetailsJoin->inventoryJoin->selling_price }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</div>
