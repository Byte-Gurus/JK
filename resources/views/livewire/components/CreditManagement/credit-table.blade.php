{{-- // --}}
<div class="relative my-[3vh] rounded-lg" x-cloak wire:poll.visible="1000ms">


    <div class="relative overflow-hidden bg-white border border-[rgb(143,143,143)] sm:rounded-md">

        {{-- //* filters --}}
        <div class="flex flex-row items-center justify-between px-4 py-4">

            {{-- //* search filter --}}
            <div class="relative w-full">

                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">

                    <svg aria-hidden="true" class="w-5 h-5 text-black" fill="currentColor" viewbox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </div>

                <input type="text" wire:model.live.debounce.100ms="search"
                    class="w-1/3 p-4 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-black text-[rgb(53,53,53)] rounded-sm cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Search by Purchase Order No." required="" />

            </div>


            <div class="flex flex-col gap-1">

                <label class="text-sm font-medium text-gray-900 text-nowrap">Status:</label>

                <select wire:model.live="statusFilter"
                    class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md block p-2.5 ">
                    <option value="0">All</option>
                    <option value="Pending">Pending</option>
                    <option value="With remaining balance"> With remaining balance</option>
                    <option value="Fully paid">Fully paid</option>
                    <option value="Overdue">Overdue</option>

                </select>

            </div>
        </div>


        {{-- //* tablea area --}}
        <div class="overflow-x-auto overflow-y-scroll scroll h-[52vh] ">

            <table class="w-full text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white z-10 uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0">

                    <tr class=" text-nowrap">



                        {{-- //* credit id --}}
                        <th scope="col" class="px-4 py-3 text-left">Credit No</th>

                        {{-- //* customer name --}}
                        <th scope="col" class="px-4 py-3 text-left">Customer Name</th>

                        {{-- //* credit balance --}}
                        <th scope="col" class="px-4 py-3 text-center">Credit Amount</th>
                        {{-- //* credit balance --}}
                        <th scope="col" class="px-4 py-3 text-center">Remaining balance</th>

                        {{-- //* credit payment amount --}}
                        {{-- <th wire:click="sortByColumn('created_at')" scope="col"
                            class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center">

                                <p>Credit Payment Amount</p>

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </span>

                            </div>
                        </th> --}}

                        {{-- //* credit limit --}}
                        <th scope="col" class="px-4 py-3 text-center">Credit Limit</th>

                        {{-- //* status --}}
                        <th scope="col" class="px-4 py-3 text-center">Status</th>

                        {{-- //* status --}}
                        <th scope="col" class="px-4 py-3 text-center">Issued Date</th>

                        {{-- //* status --}}
                        <th scope="col" class="px-4 py-3 text-center">Due Date</th>

                        {{-- //* actions --}}
                        <th scope="col" class="px-4 py-3 text-center">Actions</th>

                    </tr>
                </thead>

                {{-- //* table body --}}
                <tbody>

                    @foreach ($credits as $credit)
                        <tr
                            class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">

                            {{-- credit id --}}
                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $credit->credit_number }}
                            </th>

                            {{-- customer name --}}
                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $credit->customerJoin->firstname . ' ' . $credit->customerJoin->middlename . ' ' . $credit->customerJoin->lastname }}
                            </th>

                            {{-- credit balance --}}
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $credit->credit_amount ?? 'N/A' }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $credit->remaining_balance ?? 'N/A' }}
                            </th>

                            {{-- credit payment amount --}}
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $credit->credit_limit }}
                            </th>

                            {{-- credit limit --}}
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $credit->status }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                @if ($credit->credit_amount)
                                    {{ $credit->created_at->format(' M d Y ') }}
                                @else
                                    'N/A'
                                @endif
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ \Carbon\Carbon::parse($credit->due_date)->format(' M d Y ') }}
                            </th>


                            {{-- //* actions --}}
                            <th class="relative flex justify-center px-4 py-4 text-center z-99 text-md text-nowrap">
                                <div x-data="{ openActions: false }">
                                    <div x-on:click="openActions = !openActions"
                                        class="p-1  relative cursor-pointer transition-all duration-100 ease-in-out rounded-full hover:bg-[rgba(0,0,0,0.08)]">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                        </svg>
                                    </div>

                                    <div x-show="openActions" x-transition:enter="transition ease-in-out duration-300"
                                        x-cloak x-transition:enter-start="transform opacity-100 scale-0"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-out duration-100"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-0"
                                        x-on:click.away="openActions = false"
                                        class="absolute right-14 z-10 transform max-w-m origin-top-right w-[170px]">
                                        <div
                                            class=" overflow-y-auto rounded-l-lg rounded-br-lg rounded-tr-none h-3/5 max-h-full
                                        min-h-[20%]">
                                            <div class="flex flex-col font-black bg-[rgba(53,53,53,0.95)]">

                                                @if ($credit->transaction_id && $credit->status != 'Fully paid')
                                                    <button wire:click="getCredit({{ $credit->id }})"
                                                        x-on:click="$wire.displayCreditPaymentForm(); openActions = !openActions"
                                                        class="flex transition-all duration-100 ease-in-out hover:pl-3 hover:text-orange-300 flex-row items-center gap-2 px-2 py-2 text-white justify-left hover:bg-[rgb(37,37,37)]">
                                                        <div><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" strokeWidth={1.5}
                                                                stroke="currentColor" class="size-6">
                                                                <path strokeLinecap="round" strokeLinejoin="round"
                                                                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                                            </svg>
                                                        </div>
                                                        <div>Credit Payment</div>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{-- //* table footer --}}
        <div class="border-t border-black ">

            {{-- //*pagination --}}
            <div class="mx-4 my-2 text-nowrap">

                {{ $credits->links() }}

            </div>

            {{-- //* per page --}}
            <div class="flex items-center px-4 py-2 mb-3">

                <label class="text-sm font-medium text-gray-900 w-15">Per Page</label>

                <select wire:model.live="perPage"
                    class="bg-[rgb(243,243,243)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-20 p-2.5 ml-4">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>

            </div>


        </div>

    </div>


</div>
