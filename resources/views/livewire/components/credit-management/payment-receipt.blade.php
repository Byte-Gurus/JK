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
                    <p class="text-[0.6em] uppercase">VAT Reg TIN 936-196-461-0000</p>
                </div>
            </div>
            <div class="flex flex-col justify-between px-4 mb-2">
                <div class="flex flex-col ">
                    <div class="flex flex-row gap-2 text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Date & Time:</p>
                        <p class="text-[0.6em] font-bold uppercase">
                            {{ isset($credit_payment_info['payment']['created_at']) ?
                            \Illuminate\Support\Carbon::parse($credit_payment_info['payment']['created_at'])->format('M
                            d Y h:i A') : null }}

                        </p>
                    </div>
                    <div class="flex flex-row gap-2 break-words text-wrap">
                        <p class="text-[0.6em] font-bold uppercase text-nowrap">Creditor Name:</p>
                        <p class="text-[0.6em] font-bold uppercase w-[116px]">

                            {{ $credit_payment_info['name'] ?? null }}</p>
                        </p>
                    </div>
                    <div class="flex flex-row gap-2 text-nowrap">
                        <p class="text-[0.6em] font-bold uppercase">Payment Method:</p>
                        <p class="text-[0.6em] font-bold uppercase">
                            {{ $credit_payment_info['payment']['payment_type'] ?? null }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[0.6em] font-bold uppercase gap-2">Reference no.</p>
                        <p class="text-[0.6em] font-bold uppercase">
                            {{ $credit_payment_info['payment']['reference_number'] ?? null }}</p>
                    </div>
                </div>
            </div>

            <div class="mx-4">
                <span class="">------------------------</span>

                {{-- //* table header --}}
                <div class="grid justify-between w-full grid-flow-col">
                    <div>
                        <p class="text-[0.4em] font-bold">Amount To Pay</p>
                    </div>
                    <div>
                        <p class="text-[0.4em] font-bold">
                        <p class="text-[0.4em] font-bold">{{ $credit_payment_info['payment']['amount'] ?? null }}
                        </p>
                    </div>
                </div>
                <div class="grid justify-between w-full grid-flow-col">
                    <div>
                        <p class="text-[0.4em] font-bold">Tendered Amount</p>
                    </div>
                    <div>
                        <p class="text-[0.4em] font-bold">
                            {{ $credit_payment_info['payment']['tendered_amount'] ?? null }}
                        </p>
                    </div>
                </div>
                <span class="">------------------------</span>
                <div class="grid justify-between w-full grid-flow-col">
                    <div>
                        <p class="text-[0.6em] font-black">Change</p>
                    </div>
                    <div>
                        {{ $credit_payment_info['change_or_balance'] ?? null }}
                    </div>
                </div>

                <span class="">------------------------</span>
            </div>

            <div class="flex flex-col gap-4 m-4 mb-6">
                <div class="flex flex-row break-words text-wrap">
                    <p class="text-[0.6em] font-bold uppercas text-nowrap">Prepared by:</p>
                    <p class="text-[0.6em] font-bold uppercase w-[116px]">
                        {{ $credit_payment_info['user'] ?? null }}</p>
                </div>
                <div class="flex flex-row text-nowrap">
                    <p class="text-[0.6em] font-bold uppercase">Signature:</p>
                    <p class="text-[0.6em] font-bold uppercase">
                        _________________
                </div>
            </div>
        </div>
    </div>
</div>
