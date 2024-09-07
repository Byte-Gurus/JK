<div>
    <div class="relative overflow-hidden bg-white h-[620px] border rounded-md border-[rgb(143,143,143)] mb-[18px]">

        {{-- //* filters --}}
        <div class="flex flex-row items-center justify-between px-4 py-4 ">

            {{-- //* search filter --}}
            <div class="relative w-1/2 ">

                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black " fill="none" viewBox="0 0 24 24"
                        strokeWidth={1.5} stroke="currentColor" className="size-6">
                        <path strokeLinecap="round" strokeLinejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>

                <input type="text" wire:model.live.debounce.100ms = "search"
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
        <div class="overflow-x-auto overflow-y-scroll scroll h-[300px]">

            <table class="w-full text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white z-10 uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                    <tr class=" text-nowrap">

                        {{-- //* employee name --}}
                        <th scope="col" class="px-4 py-3 text-center">Employee</th>

                        {{-- //* transaction no --}}
                        <th scope="col" class="px-4 py-3">Transaction No.</th>

                        {{-- //* sku --}}
                        <th scope="col" class="px-4 py-3 text-center">SKU</th>

                        {{-- item name --}}
                        <th scope="col" class="px-4 py-3 text-center">Item Name</th>

                        {{-- original quantity --}}
                        <th scope="col" class="px-4 py-3 text-center">Original Quantity</th>

                        {{-- //* return quantity --}}
                        <th scope="col" class="px-4 py-3 text-center">Return Quantity</th>

                        {{-- //* unit price --}}
                        <th scope="col" class="px-4 py-3 text-center">Unit Price</th>

                        {{-- //* total return amount --}}
                        <th scope="col" class="px-4 py-3 text-center">Total Return Amount</th>

                        {{-- //* reason --}}
                        <th scope="col" class="px-4 py-3 text-center">Reason</th>

                        {{-- //* date --}}
                        <th scope="col" class="px-4 py-3 text-center">Date</th>

                    </tr>
                </thead>

                {{-- //* table body --}}
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
