{{-- // --}}
<div class="relative" wire:poll.visible="500ms">


    <div class="relative overflow-hidden bg-white border border-black shadow-lg sm:rounded-lg">

        {{-- //* filters --}}
        <div class="flex flex-row items-center justify-between px-2 py-4 ">

            {{-- //* search filter --}}
            <div class="relative w-full">

                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black " fill="none" viewBox="0 0 24 24"
                        strokeWidth={1.5} stroke="currentColor" className="size-6">
                        <path strokeLinecap="round" strokeLinejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>

                <input type="text" wire:model.live.debounce.100ms = "search"
                    class="w-1/3 p-2 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-black text-[rgb(53,53,53)] rounded-lg cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Search by Item Name or Barcode" required="" />


            </div>


            <div class="flex flex-row items-center justify-center gap-4">
                <div class="flex flex-row items-center">

                    <div class="flex flex-row items-center gap-2">

                        <label class="text-sm font-medium text-gray-900 text-nowrap">Status :</label>

                        <select wire:model.live="statusFilter"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-lg  block p-2.5 ">
                            <option value="0">All</option>
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>

                        </select>

                    </div>
                </div>

                <div class="flex flex-row items-center">

                    <div class="flex flex-row items-center gap-2">

                        <label class="text-sm font-medium text-gray-900 text-nowrap">VAT type :</label>

                        <select wire:model.live="vatFilter"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-lg  block p-2.5 ">
                            <option value="0">All</option>
                            <option value="Vat">Vat</option>
                            <option value="Non vat">Non vat</option>

                        </select>

                    </div>
                </div>
            </div>
        </div>


        {{-- //* tablea area --}}
        <div class="overflow-x-auto overflow-y-scroll h-[500px] ">

            <table class="w-full h-10 text-sm text-left">

                {{-- //* table header --}}
                <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                    <tr class=" text-nowrap">

                        {{-- //* barcode --}}
                        <th scope="col" class="px-4 py-3">SKU Code</th>

                        {{-- //* item name --}}
                        <th wire:click="sortByColumn('item_name')" scope="col"
                            class="flex flex-row items-center justify-between gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center">
                                <p>Item Name</p>

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </span>

                            </div>

                        </th>

                        {{-- //* status --}}
                        <th scope="col" class="px-4 py-3 text-center">Item Cost</th>\

                        {{-- //* status --}}
                        <th scope="col" class="px-4 py-3 text-center">Mark-up price</th>

                         {{-- //* status --}}
                         <th scope="col" class="px-4 py-3 text-center">Selling price</th>

                          {{-- //* status --}}
                        <th scope="col" class="px-4 py-3 text-center">Quantity</th>

                         {{-- //* status --}}
                         <th scope="col" class="px-4 py-3 text-center">Supplier</th>

                          {{-- //* status --}}
                        <th scope="col" class="px-4 py-3 text-center">Stock-in date</th>

                         {{-- //* status --}}
                         <th scope="col" class="px-4 py-3 text-center">Expiration date</th>


                    </tr>
                </thead>

                {{-- //* table body --}}
                <tbody>

                    @foreach ($inventories as $inventory)
                        <tr
                            class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">

                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->sku_code }}
                            </th>

                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->itemJoin->item_name }}
                            </th>

                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->quantity }}
                            </th>

                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->cost }}
                            </th>

                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->mark_up_price }}
                            </th>

                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->selling_price }}
                            </th>

                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->supplierJoin->company_name }}
                            </th>
                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->stock_in_date->format('d-m-y') }}
                            </th>

                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->expiration_date->format('d-m-y') }}
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

                {{-- {{ $items->links() }} --}}

            </div>

            {{-- //* per page --}}
            <div class="flex items-center px-4 py-2 mb-3">

                <label class="text-sm font-medium text-gray-900 w-15">Per Page</label>

                <select wire:model.live = "perPage"
                    class="bg-[rgb(243,243,243)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2.5 ml-4">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>

            </div>


        </div>

    </div>


</div>
