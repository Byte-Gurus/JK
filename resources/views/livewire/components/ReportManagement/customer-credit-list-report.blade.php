<div x-cloak class="flex justify-center">

    <div class="  w-[816px] max-h-[1056px] h-full border border-black">
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
        {{-- @if ($transaction_info) --}}
        <div class="grid items-center grid-flow-col m-4 ">

            <div class="flex flex-row gap-2 text-nowrap">
                <p class="text-[1em] font-black uppercase">Specified Date:</p>
                <p>
                    {{ $fromDate . ' - ' . $toDate }}
                </p>
            </div>

            <div>
                <p class="text-[1.4em] font-bold text-right italic m-4 mr-10 uppercase">CUSTOMER CREDIT REPORT</p>
            </div>

        </div>
        {{-- @endif --}}

        <div>
            <div class="w-full my-4 border-b border-black"> </div>

            {{-- //* table header --}}
            <ul class="grid justify-between grid-flow-col grid-cols-9 mx-4 ">
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">ID</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">Name</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Contact No.</p>
                    </div>
                </li>

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Date of Credit</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Due date</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-right font-bold">Credit Amount</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-right font-bold">Remaining Balance</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Status</p>
                    </div>
                </li>

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-right font-bold">Credit Limit</p>
                    </div>
                </li>
            </ul>

            <div class="w-full my-4 border-b border-black"> </div>
            @if ($credits)
                @foreach ($credits as $credit)
                    <ul class="grid justify-between grid-flow-col grid-cols-9 mx-4 ">

                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-left font-medium">
                                    {{ $credit->credit_number }}
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-left font-medium">
                                    {{ $credit->customerJoin->firstname .
                                        ' ' .
                                        $credit->customerJoin->middlename .
                                        ' ' .
                                        $credit->customerJoin->lastname }}
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-left font-bold">
                                    {{ $credit->customerJoin->contact_number }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-center fot-bold">
                                    {{ \Carbon\Carbon::parse($credit->created_at)->format('M d Y') }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-center fot-bold">
                                    {{ \Carbon\Carbon::parse($credit->due_date)->format('M d Y') }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-right fot-bold">
                                    {{ $credit->credit_amount }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-right fot-bold">
                                    {{ $credit->remaining_balance }}
                                </p>
                            </div>
                        </li>
                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-center fot-bold">
                                    {{ $credit->status }}
                                </p>
                            </div>
                        </li>

                        <li class="col-span-1 py-[3px]">
                            <div>
                                <p class="text-[0.8em] text-right fot-bold">
                                    {{ $credit->credit_limit }}
                                </p>
                            </div>
                        </li>
                    </ul>
                @endforeach
            @endif
        </div>
        <div class="px-4 py-4 ">
            <div class="flex flex-row gap-2 text-nowrap">
                <p class="text-[1em] font-bold uppercase">Date & Time Created:</p>
                <p>
                    {{ $dateCreated }}
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
