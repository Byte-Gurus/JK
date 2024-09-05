{{-- // --}}
<div class="relative" x-cloak>

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
                    <option value="Paid">Paid</option>
                    <option value="Overdue">Overdue</option>

                </select>

            </div>
        </div>


        {{-- //* tablea area --}}
        <div class="overflow-x-auto overflow-y-scroll scroll h-[480px] ">

            <table class="w-full h-10 text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                    <tr class=" text-nowrap">



                        {{-- //* credit id --}}
                        <th scope="col" class="px-4 py-3 text-left">Credit ID</th>

                        {{-- //* customer name --}}
                        <th scope="col" class="px-4 py-3 text-left">Customer Name</th>

                        {{-- //* credit balance --}}
                        <th scope="col" class="px-4 py-3 text-center">Payment Method</th>

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
                        <th scope="col" class="px-4 py-3 text-center">GCash Reference No.</th>

                        {{-- //* status --}}
                        <th scope="col" class="px-4 py-3 text-center">Payment Amount</th>

                        {{-- //* status --}}
                        <th scope="col" class="px-4 py-3 text-center">Date</th>

                        {{-- //* status --}}
                        <th scope="col" class="px-4 py-3 text-center">Time</th>

                    </tr>
                </thead>

                {{-- //* table body --}}
                <tbody>



                </tbody>
            </table>
        </div>

        {{-- //* table footer --}}
        <div class="border-t border-black ">

            {{-- //*pagination --}}
            <div class="mx-4 my-2 text-nowrap">

                {{-- {{ $purchases->links() }} --}}

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
