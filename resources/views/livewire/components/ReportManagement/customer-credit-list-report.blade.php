<div class="flex justify-center">

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
                    <p class="text-[0.8em] uppercase">Non-VAT Reg TIN 936-196-461-0000</p>
                </div>
            </div>
        </div>
        <div>
            <p class="text-[2em] font-bold text-right italic m-4 mr-10 uppercase">DAILY SALES REPORT</p>

        </div>
        {{-- @if ($transaction_info) --}}
            <div class="flex flex-col justify-between col-span-1 px-4 mb-2">
                <div class="flex flex-col ">
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[1em] font-bold uppercase">Date & Time Created:</p>
                        {{-- {{ $transaction_info['dateCreated'] ?? ' ' }} --}}

                        </p>
                    </div>
                    <div class="flex flex-row text-nowrap">
                        <p class="text-[1em] font-bold uppercase">Prepared By:</p>
                        {{-- {{ $transaction_info['createdBy'] ?? ' ' }} --}}

                    </div>
                </div>
            </div>
        {{-- @endif --}}

        <div>
            <div class="w-full my-4 border-b border-black"> </div>

            {{-- //* table header --}}
            <ul class="grid justify-between grid-flow-col grid-cols-7 mx-4 ">

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">ID</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold"> Name</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-left font-bold">Contact No.</p>
                    </div>
                </li>
                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Credit ID</p>
                    </div>
                </li>

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Date of Credit</p>
                    </div>
                </li>

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Credit Amount</p>
                    </div>
                </li>

                <li class="col-span-1 ">
                    <div>
                        <p class="text-[0.8em] uppercase text-center font-bold">Credit Limit</p>
                    </div>
                </li>

            </ul>

            <div class="w-full my-4 border-b border-black"> </div>

            {{-- @foreach ($transactions as $transaction) --}}
            <ul class="grid justify-between grid-flow-col grid-cols-7 mx-4 ">

                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-left font-medium">
                            ta
                    </div>
                </li>
                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-left font-medium">
                            arce
                    </div>
                </li>
                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-left font-bold">
                            queen
                        </p>
                    </div>
                </li>
                <li class="col-span-1 py-[3px]">
                    <div>
                        <p class="text-[0.8em] text-center fot-bold">
                            maraiah
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
                            hi
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