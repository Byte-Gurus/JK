{{-- // --}}
<div class="relative">

    <div class="relative overflow-hidden bg-white border border-black shadow-lg sm:rounded-lg">

        <div class="grid justify-between grid-flow-col grid-cols-3 px-2 py-4">
            <div>
                <h1 class="text-[1.8em]">Purchase Order No</h1>
                <h2 class="text-[2em] font-black text-center w-full">{{ $purchase_number }}</h2>
            </div>
            <div class="flex flex-col gap-2">


                <label for="supplier" class="text-[1.8em]">Supplier Name</label>
                <select id="supplier" wire:model="suppliers"
                    class=" bg-[rgb(255,255,255)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                    <option value="" selected>Select Supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">
                            {{ $supplier->company_name }}</option>
                    @endforeach
                </select>


            </div>
            <div class="flex flex-row self-center justify-center gap-4">
                <div>
                    <button wire:click="addRows"
                        class=" px-8 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(254,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,244,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out">
                        Add Row</button>
                </div>
                <div>
                    <button
                        class=" px-8 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(158,255,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out">
                        Save</button>
                </div>
            </div>
        </div>

        {{-- //* tablea area --}}
        <div class="overflow-x-auto overflow-y-scroll h-[449px] scroll ">

            <table class="w-full h-10 text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                    <tr class=" text-nowrap">

                        {{-- //* action --}}
                        <th scope="col" class="px-4 py-3 text-center">Action</th>

                        {{-- //* barcode --}}
                        <th scope="col" class="px-4 py-3 text-left">Barcode</th>

                        {{-- //* item name --}}
                        <th scope="col" class="px-4 py-3 text-left">Item Name</th>

                        {{-- //* stocks on hand --}}
                        <th scope="col" class="px-4 py-3 text-center">Stocks-On-Hand</th>

                        {{-- //* item reorder quantity --}}
                        <th scope="col" class="px-4 py-3 text-center">Item Reorder Quantity</th>

                        {{-- //* purchase quantity --}}
                        <th scope="col" class="px-4 py-3 text-center text-nowrap">Purchase Quantity</th>
                        </th>


                    </tr>
                </thead>

                {{-- //* table body --}}
                <tbody>
                    @foreach ($reorder_lists as $reorder_list)
                        <tr
                            class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">
                            <th scope="row"
                                class="px-4 py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap ">
                                <div class="flex justify-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor"
                                        class="w-8 h-8 text-center text-red-300 rounded-full hover:bg-red-500">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </th>
                            <th scope="row"
                                class="px-4 py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap ">
                                {{ $reorder_list->barcode }}</th> <!-- Use item_id directly -->
                            <th scope="row"
                                class="px-4 py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $reorder_list->item_name }}</th> <!-- Use item_name directly -->
                            <th scope="row"
                                class="px-4 py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $reorder_list->total_quantity }}</th> <!-- Total quantity -->
                            <th scope="row"
                                class="px-4 py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $reorder_list->reorder_point }}</th>
                            <th scope="row"
                                class="px-4 py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                <input type="number"></th>
                            <!-- Use reorder_point, handle cases where it might not exist -->
                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- //* table footer --}}
        <div class="border-t border-black ">

            {{-- //*pagination --}}
            <div class="mx-4 my-2 text-nowrap">

                {{-- {{ $suppliers->links() }} --}}

            </div>

            {{-- //* per page --}}
            <div class="flex items-center px-4 py-2 mb-3">

                <label class="text-sm font-medium text-gray-900 w-15">Per Page</label>

                <select wire:model.live="perPage"
                    class="bg-[rgb(243,243,243)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2.5 ml-4">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
    </div>
</div>
