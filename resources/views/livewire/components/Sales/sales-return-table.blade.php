<div class="relative overflow-hidden bg-white h-[66vh] mb-[3vh]">

    {{-- //* filters --}}
    <div class="flex flex-row items-center justify-between mb-[3vh] ">

        {{-- //* search filter --}}
        <div class="relative w-1/2 ">

            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black " fill="none" viewBox="0 0 24 24"
                    strokeWidth={1.5} stroke="currentColor" className="size-6">
                    <path strokeLinecap="round" strokeLinejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>

            <input type="text" wire:model.live.debounce.100ms="search"
                class="w-2/3 p-4 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-[rgb(101,101,101)] text-[rgb(53,53,53)] rounded-sm cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                placeholder="Search by Transaction No. or Sales Invoice No." required="" />
        </div>

        <div class="flex flex-row items-center justify-between gap-4">
            <div class="flex flex-col">
                <div class="flex flex-row ">
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-gray-900 text-nowrap">Start Date:</label>
                        <input type="date" wire:model.live="startDate"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-l-md block p-2.5" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-gray-900 text-nowrap">End Date:</label>
                        <input type="date" wire:model.live="endDate"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-r-md block p-2.5" />
                    </div>
                </div>
                <p class="text-[12px] font-light text-center text-gray-600 ">Date Range</p>
            </div>
        </div>
    </div>
    {{-- //* tablea area --}}
    <div class="overflow-x-auto overflow-y-scroll scroll no-scrollbar border border-[rgb(143,143,143)] h-[52vh]">

        <table class="w-full text-sm text-left scroll no-scrollbar">

            {{-- //* table header --}}
            <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0">

                <tr class=" text-nowrap">

                    {{-- //* transaction no --}}
                    <th scope="col" class="px-4 py-3">Return No.</th>

                    {{-- //* transaction no --}}
                    <th scope="col" class="px-4 py-3">Transaction No.</th>

                    {{-- original quantity --}}
                    <th scope="col" class="px-4 py-3 text-center">Original Amount (₱)</th>

                    {{-- //* total return amount --}}
                    <th scope="col" class="px-4 py-3 text-right">Refund Amount (₱)</th>
                    {{-- //* total return amount --}}
                    <th scope="col" class="px-4 py-3 text-right">Exchange Amount (₱)</th>
                    {{-- //* total return amount --}}
                    <th scope="col" class="px-4 py-3 text-right">Total Return Amount (₱)</th>

                    {{-- //* date --}}
                    <th scope="col" class="px-4 py-3 text-center">Date</th>

                    {{-- //* date --}}
                    <th scope="col" class="px-4 py-3 text-center">Actions</th>

                </tr>
            </thead>

            {{-- //* table body --}}
            <tbody>
                @foreach ($returns as $return)
                <tr
                    class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">

                    <th scope="row" class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap ">
                        {{ $return->return_number }}

                    </th>

                    <th scope="row" class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap ">
                        {{ $return->transactionJoin->transaction_number }}

                    </th>

                    <th scope="row" class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                        {{ number_format($return->refund_amount, 2) }}

                    </th>
                    <th scope="row" class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                        {{ number_format($return->exchange_amount, 2) }}

                    </th>

                    <th scope="row" class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                        {{ number_format($return->original_amount, 2) }}

                    </th>


                    <th scope="row" class="px-4 py-4 font-medium text-right text-gray-900 text-md whitespace-nowrap ">
                        {{ number_format($return->return_total_amount, 2) }}

                    </th>

                    <th scope="row" class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                        {{ $return->created_at->format(' M d Y h:i A') }}

                    </th>
                    <th class="px-4 py-4 text-center text-md text-nowrap">
                        <div
                            class="flex items-center justify-center px-1 py-1 font-medium text-blue-600 rounded-sm hover:bg-blue-100 ">

                            <button x-on:click="$wire.dDisplaySalesReturnDetails();"
                                wire:click="getReturn({{ $return->id }})">

                                <div class="flex items-center">

                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </span>

                                    <div>
                                        <p>View</p>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
