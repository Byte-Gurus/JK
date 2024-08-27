{{-- // --}}
<div class="relative">
    <div class="flex flex-col h-[655px] gap-4 ">
        <div class="flex flex-row items-center border border-[rgb(53,53,53)] justify-between gap-4 p-6 text-nowrap">
            <div class="flex flex-row gap-6">
                <div>
                    <h1 class="text-[1.2em]">Item Name</h1>
                    <h2 class="text-[2em] font-black text-center w-full"></h2>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="supplier" class="text-[1.2em]">Expiration Date</label>
                    <p></p>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="supplier" class="text-[1.2em]">Supplier</label>
                    <p></p>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="supplier" class="text-[1.2em]">Date Range</label>
                    <p></p>
                </div>
            </div>
        </div>
        <div class="relative w-full overflow-hidden border-[rgb(143,143,143)] border bg-white rounded-b-lg">

            {{-- //* tablea area --}}
            <div class="h-[680px] pb-[136px] overflow-x-auto overflow-y-scroll  no-scrollbar scroll">

                <table class="w-full overflow-auto text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                        <tr class=" text-nowrap">

                            {{-- //* date --}}
                            <th scope="col" class="px-4 py-3 text-left">Date</th>

                            {{-- //* remarks --}}
                            <th scope="col" class="py-3 text-left">Remarks</th>

                            {{-- //* in quantity --}}
                            <th scope="col" class="py-3 text-center text-nowrap">In Quantity</th>

                            {{-- //* value --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Value (₱)</th>

                            {{-- //* out quantity --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Out Quantity</th>

                            {{-- //* value --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Value (₱)</th>

                            {{-- //* quantity balance --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Quantity Balance</th>

                            {{-- //* value --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Value (₱)</th>
                        </tr>
                    </thead>

                    {{-- //* table body --}}

                    <tbody>
                        <tr
                            class="border-b hover:bg-gray-100 border-[rgb(207,207,207)] transition ease-in duration-75 index:bg-red-400">

                            <th scope="row"
                                class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                <p></p>
                            </th>

                            <th scope="row"
                                class="py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                <p></p>
                            </th>

                            <th scope="row"
                                class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                <p></p>
                            </th>

                            <th scope="row"
                                class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                <p></p>
                            </th>

                            <th scope="row"
                                class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                <p></p>
                            </th>

                            <th scope="row"
                                class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                <p></p>
                            </th>

                            <th scope="row"
                                class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                <p></p>
                            </th>

                            <th scope="row"
                                class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                <p></p>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
