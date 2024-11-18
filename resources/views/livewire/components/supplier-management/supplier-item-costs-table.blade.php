{{-- // --}}
<div class="relative my-[3vh] rounded-lg" wire:poll.visible="1000ms">
    <div class="relative overflow-hidden bg-white border border-[rgb(143,143,143)] sm:rounded-lg">
        <div
            class="flex flex-row items-center mt-4 gap-6 w-fit p-2 pr-4 bg-[rgb(40,23,83)] shadow-md shadow-[rgb(206,187,255)] text-white rounded-r-full">
            <div>
                <p class="text-[1em] font-thin text-center w-full">Company Name</p>
            </div>
            <div class="flex flex-col gap-2">
                <p class="text-[1.2em] font-black"> {{ $supplier->company_name ?? '' }}
                </p>
            </div>
            <div>
                |
            </div>
            <div>
                <p class="text-[1em] font-thin text-center w-full">Contact Person</p>
            </div>
            <div class="flex flex-col gap-2">
                <p class="text-[1.2em] font-black text-wrap">
                    {{ $supplier->contact_person ?? '' }}
                </p>
            </div>
        </div>

        {{-- //* filters --}}
        <div class="flex flex-row items-center justify-between px-4 py-4 ">

            {{-- //* search filter --}}
            <div class="relative w-full">

                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">

                    <svg aria-hidden="true" class="w-5 h-5 text-black " fill="currentColor" viewbox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.100ms="search"
                    class="w-1/3 p-4 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-black text-[rgb(53,53,53)] rounded-sm cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Search by Item Name" required="" />

            </div>

            <div class="flex flex-row items-center justify-center gap-4">
                <div class="relative w-1/2">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black " fill="none"
                                viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
                                <path strokeLinecap="round" strokeLinejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms='addItem' type="text" list="itemList"
                            class="w-[200px] p-4 pl-10 hover:bg-[rgb(230,230,230)] outline-offset-2 hover:outline transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-[rgb(101,101,101)] text-[rgb(53,53,53)] rounded-sm cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Search by Item Name or Barcode" required="">
                    </div>

                    @if (!empty($addItem))
                    <div
                        class="absolute z-10 w-full h-fit max-h-[400px] overflow-y-scroll backdrop-blur-md rounded-b-lg border-[rgb(53,53,53)] border-2 bg-[rgba(255,255,255,0.85)]">
                        @foreach ($items as $item)
                        <ul wire:click="selectItem({{ $item->id }})"
                            class=" w-full p-4 transition-all duration-100 ease-in-out border border-black cursor-pointer hover:bg-[rgba(205,205,205,0.79)] h-fit text-nowrap">
                            <li class="flex items-start justify-between">
                                <!-- Item details on the left side -->
                                <div class="flex flex-col w-[200px] items-start leading-1">
                                    <div class="text-[1.2em] font-bold text-wrap">{{ $item->item_name }}</div>
                                    <div class="text-[0.8em]">{{ $item->item_description }}</div>
                                </div>

                                <!-- Price on the right side -->
                                {{-- <div class="flex flex-row items-center self-center justify-between gap-2 pr-2 ">

                                    <p class="text-[1em] font-medium italic">PHP</p>
                                    <p class="text-[1.5em] font-bold ">
                                        {{ number_format($item->highestPricedInventory->selling_price, 2) }}
                                </div> --}}
                            </li>
                        </ul>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="flex flex-col gap-1">

                    <label class="text-sm font-medium text-left text-gray-900 text-nowrap">Unit:</label>

                    <select wire:model.live="unitFilter"
                        class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md  block p-3 ">
                        <option value="0">All</option>
                        <option value="Kilo">Kilo</option>
                        <option value="Pack">Pack</option>
                        <option value="Piece">Piece</option>
                    </select>
                </div>

                <div class="flex flex-col gap-1">

                    <label class="text-sm font-medium text-left text-gray-900 text-nowrap">Category:</label>

                    <select wire:model.live="categoryFilter"
                        class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md  block p-3 ">
                        <option value="0">All</option>
                        <option value="Frozen">Frozen Supply</option>
                        <option value="Consumer">Consumer Supply</option>
                    </select>
                </div>
            </div>
        </div>


        {{-- //* tablea area --}}
        <div class="overflow-x-auto overflow-y-scroll scroll h-[52vh] ">

            <table class="w-full text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                    <tr class=" text-nowrap">


                        {{-- //* item name --}}
                        <th scope="col" class="px-4 py-3 text-center">Item Name</th>

                        {{-- //* item description --}}
                        <th scope="col" class="px-4 py-3">Item Description</th>


                        {{-- //* unit --}}
                        <th scope="col" class="px-4 py-3">Unit</th>

                        {{-- //* category --}}
                        <th scope="col" class="px-4 py-3">Category</th>

                        {{-- //* item cost --}}
                        <th scope="col" class="px-4 py-3">Item Cost (₱)</th>


                        {{-- //* created at --} --}}
                        <th wire:click="sortByColumn('created_at')" scope="col"
                            class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center">

                                <p>Created at</p>

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </span>

                            </div>
                        </th>
                    </tr>
                </thead>

                {{-- //* table body --}}
                <tbody>

                    @foreach ($supplierItems as $supplierItem)
                    <tr
                        class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">

                        <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $supplierItem->itemJoin->item_name }}
                        </th>

                        <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $supplierItem->itemJoin->item_description }}
                        </th>

                        <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $supplierItem->itemJoin->item_unit }}
                        </th>

                        <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $supplierItem->itemJoin->item_category }}
                        </th>


                        <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ number_format($supplierItem->item_cost, 2) }}
                        </th>

                        <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                            {{ $supplierItem->created_at->format('M d Y ') }}
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

                {{ $supplierItems->links() }}

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
