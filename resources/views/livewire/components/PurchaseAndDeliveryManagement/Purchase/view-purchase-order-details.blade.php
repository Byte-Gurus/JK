{{-- // --}}
<div class="relative my-[3vh] rounded-lg" x-cloak >
    <div class="flex flex-row h-[74vh] gap-4 ">
        <div class="relative w-full overflow-hidden border-[rgb(143,143,143)] border bg-white rounded-lg sm:rounded-lg">

            <div class="grid items-center grid-flow-col gap-4 py-[3vh] px-4 text-wrap">

                <div class="flex flex-col gap-1 text-black rounded-r-full">
                    <p class="text-[1em] font-thin text-left w-full">Purchase Order No.</p>
                    <p class="text-[1.2em] font-black">{{ $po_number }}</p>
                </div>

                <div class="flex flex-col gap-1 text-black ">
                    <p class="text-[1em] font-thin text-left w-full">Supplier Name</p>
                    <p class="text-[1.2em] font-black">{{ $supplier }}</p>
                </div>


                <div class="flex flex-col gap-1 text-black">
                    <p class="text-[1em] font-thin text-left w-full">Date Created</p>
                    <p class="text-[1em] font-black">{{ $dateCreated }}</p>
                </div>

                <div class="flex flex-col gap-1 text-black">
                    <p class="text-[1em] font-thin text-left w-full">Created By</p>
                    <p class="text-[1em] font-black">{{ $createdBy }}</p>
                </div>
            </div>

            {{-- //* tablea area --}}
            <div class="h-[680px] pb-[136px] overflow-x-auto overflow-y-scroll  no-scrollbar scroll">

                <table class="w-full overflow-auto text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                        <tr class=" text-nowrap">

                            {{-- //* barcode --}}
                            <th scope="col" class="px-4 py-3 text-left">Barcode</th>

                            {{-- //* item name --}}
                            <th scope="col" class="py-3 text-left">Item Name</th>

                            {{-- //* purchase quantity --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Purchase Quantity</th>
                            </th>
                        </tr>
                    </thead>

                    {{-- //* table body --}}

                    <tbody>
                        @foreach ($purchaseDetails as $purchaseDetail)
                            <tr
                                class="border-b hover:bg-gray-100 border-[rgb(207,207,207)] transition ease-in duration-75 index:bg-red-400">
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                    <p>{{ $purchaseDetail->itemsJoin->barcode }}</p>
                                </th>
                                <th scope="row"
                                    class="py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                    <p>{{ $purchaseDetail->itemsJoin->item_name }}</p>
                                </th>
                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                    <p>{{ $purchaseDetail->purchase_quantity }}</p>
                                </th>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
