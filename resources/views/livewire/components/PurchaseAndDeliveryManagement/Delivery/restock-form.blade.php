<div>
    <div class="relative w-full overflow-hidden border-[rgb(143,143,143)] border bg-white rounded-lg sm:rounded-lg">
        <div class="flex items-center justify-center py-2 border border-black">
            <p class="font-black ">Restock Form</p>
        </div>

        <form wire:submit.prevent="create">

            <div class="flex flex-row items-center justify-between gap-4 px-4 py-4 text-nowrap">
                <div class="flex flex-row gap-6">
                    <div>
                        <h1 class="text-[1.2em]">Purchase Order No</h1>
                        <h2 class="text-[2em] font-black text-center w-full">{{ $po_number }}</h2>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="supplier" class="text-[1.2em]">Supplier Name</label>
                        <label for="supplier" class="text-[1.2em] ">{{ $supplier }}</label>

                    </div>
                </div>
                <div class="flex flex-row items-center justify-center gap-4 flex-nowrap text-nowrap">

                    <div>
                        <button type="button" wire:click='restockForm()'
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out">
                            Restock</button>
                    </div>
                </div>
            </div>

            {{-- //* tablea area --}}
            <div class="h-[520px] pb-[136px] overflow-x-auto overflow-y-scroll  no-scrollbar scroll">

                <table class="w-full overflow-auto text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                        <tr class=" text-nowrap">


                            {{-- //* barcode --}}
                            <th scope="col" class="py-3 text-left">Barcode</th>

                            {{-- //* item name --}}
                            <th scope="col" class="py-3 text-left">Item Name</th>

                            {{-- //* stocks on hand --}}
                            <th scope="col" class="py-3 texvt-center ">Purchased Quantity</th>

                            {{-- //* item reorder quantity --}}
                            <th scope="col" class="py-3 text-center">Remaining Quantity</th>

                            {{-- //* purchase quantity --}}
                            <th scope="col" class="py-3 text-center text-nowrap">SKU</th>
                            </th>

                            {{-- //* restock quantity --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Restock Quantity</th>
                            </th>

                            {{-- //* cost --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Cost (₱)</th>
                            </th>

                            {{-- //* markup --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Markup (%)</th>
                            </th>

                            {{-- //* srp --}}
                            <th scope="col" class="py-3 text-center text-nowrap">SRP (₱)</th>
                            </th>

                            {{-- //* expiration date --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Expiration Date</th>
                            </th>

                            {{-- //* actions --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Actions</th>
                            </th>
                        </tr>
                    </thead>

                    {{-- //* table body --}}

                    <tbody>
                        @foreach ($purchaseDetails as $purchaseDetail)
                            <tr
                                class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">
                                <th scope="row"
                                    class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail->itemsJoin->barcode }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail->itemsJoin->item_name }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail->itemsJoin->item_name }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail->itemsJoin->item_name }}
                                </th>


                                <th scope="row"
                                    class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail->itemsJoin->item_name }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail->itemsJoin->item_name }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail->itemsJoin->item_name }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail->itemsJoin->item_name }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail->itemsJoin->item_name }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail->itemsJoin->item_name }}
                                </th>

                                <th scope="row"
                                    class="flex justify-center px-4 py-6 font-medium text-center text-gray-900 rounded-full text-md whitespace-nowrap ">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        strokeWidth={1.5} stroke="currentColor" class="transition-all duration-100 ease-in-out bg-green-100 rounded-full size-8 hover:bg-green-200">
                                        <path strokeLinecap="round" strokeLinejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </th>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>