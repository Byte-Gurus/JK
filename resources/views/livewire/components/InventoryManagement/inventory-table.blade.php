{{-- // --}}

<div class="relative my-[3vh] rounded-lg" wire:poll.visible="500ms">

    <div class="relative overflow-hidden bg-white border border-[rgb(143,143,143)] sm:rounded-lg">

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
                    placeholder="Search by Item Name or Barcode" required="" />

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
                <div class="flex flex-row items-center gap-4 mb-4">

                    <div class="flex flex-col gap-1">

                        <label class="text-sm font-medium text-left text-gray-900 text-nowrap">Status:</label>

                        <select wire:model.live="statusFilter"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md  block p-3 ">
                            <option value="0">All</option>
                            <option value="Available">Available</option>
                            <option value="Not available">Not available</option>
                            <option value="Expired">Expired</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">

                        <label class="text-sm font-medium text-left text-gray-900 text-nowrap">Supplier :</label>

                        <select wire:model.live="supplierFilter"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md block p-3 ">
                            <option value="0">All</option>

                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
            </div>
        </div>


        {{-- //* tablea area --}}
        <div class="overflow-x-auto overflow-y-scroll h-[50vh]">

            <table class="w-full text-sm text-left">

                {{-- //* table header --}}
                <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                    <tr class=" text-nowrap">

                        {{-- //* barcode --}}
                        <th scope="col" class="px-4 py-3">SKU Code</th>

                        {{-- //* barcode --}}
                        <th scope="col" class="px-4 py-3">Barcode</th>

                        {{-- //* item name --}}
                        <th scope="col" class="px-4 py-3">Item name</th>

                        {{-- //* item name --}}
                        <th scope="col" class="px-4 py-3">Item Description</th>

                        {{-- //* supplier name --}}
                        <th scope="col" class="px-4 py-3 text-left">Supplier</th>

                        {{-- //* current stock quantity --}}
                        <th scope="col" class="px-4 py-3 text-center">Current stock quantity</th>

                        {{-- stock in quantity --}}
                        <th scope="col" class="px-4 py-3 text-center">Stock In quantity</th>

                        {{-- //* reorder point --}}
                        <th scope="col" class="px-4 py-3 text-center">Reorder point</th>

                        {{-- //* item cost --}}
                        <th scope="col" class="px-4 py-3 text-center">Item Cost (₱)</th>

                        {{-- //* mark-up price --}}
                        <th scope="col" class="px-4 py-3 text-center">Mark-up price (₱)</th>

                        {{-- //* sellign price --}}
                        <th scope="col" class="px-4 py-3 text-center">Selling price (₱)</th>

                        {{-- //* vat amount --}}
                        <th scope="col" class="px-4 py-3 text-center">Vat amount </th>

                        {{-- //* status --}}
                        <th scope="col" class="px-4 py-3 text-center">Status</th>

                        <th wire:click="sortByColumn('stock_in_date')" scope="col"
                            class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center">

                                <p>Stock-in date</p>

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </span>
                            </div>
                        </th>

                        {{-- //* updated at --}}
                        <th wire:click="sortByColumn('expiration_date')" scope="col"
                            class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center">

                                <p>Expiration</p>

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </span>
                            </div>
                        </th>

                        {{-- //* action --}}
                        <th scope="col" class="px-4 py-3 text-nowrap">Actions</th>

                    </tr>
                </thead>

                {{-- //* table body --}}
                <tbody>

                    @foreach ($inventories as $inventory)
                        <tr
                            class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->sku_code ?? 'null' }}
                            </th>

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->itemJoin->barcode }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap text-wrap">
                                {{ $inventory->itemJoin->item_name }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap text-wrap">
                                {{ $inventory->itemJoin->item_description }}
                            </th>

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->deliveryJoin?->purchaseJoin?->supplierJoin?->company_name ?? 'null' }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->current_stock_quantity }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->stock_in_quantity }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->itemJoin->reorder_point }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ number_format($inventory->cost, 2) }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ number_format($inventory->mark_up_price, 2) }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ number_format($inventory->selling_price, 2) }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ number_format($inventory->vat_amount, 2) }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center pointer-events-none text-md whitespace-nowrap">

                                {{-- //* active green, if inactive red --}}
                                <p
                                    @if ($inventory->status == 'Available') class=" text-green-900 font-medium  bg-green-100 border border-green-900 text-xs text-center px-2 py-0.5 rounded-sm"

                                @elseif ($inventory->status == 'Not available')

                                class=" text-red-900 font-medium  bg-red-100 border border-red-900 text-xs text-center px-2 py-0.5 rounded-sm"
                                @elseif ($inventory->status == 'New Item')
                                class=" text-yellow-900 font-medium  bg-yellow-100 border border-yellow-900 text-xs text-center px-2 py-0.5 rounded-sm"

                                @elseif ($inventory->status == 'Expired')

                                class=" text-orange-900 font-medium  bg-orange-100 border border-orange-900 text-xs text-center px-2 py-0.5 rounded-sm" @endif>

                                    {{ $inventory->status }}
                                </p>

                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $inventory->stock_in_date->format(' M d Y h:i A')  }}

                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                @if ($inventory->itemJoin->shelf_life_type === 'Perishable')
                                    {{ $inventory->expiration_date ? $inventory->expiration_date->format(' M d Y ') : 'null' }}
                                @elseif($inventory->itemJoin->shelf_life_type === 'Non Perishable')
                                    N/A
                                @endif

                            </th>

                            {{-- //* Action --}}
                            <th class="px-4 py-4 text-center z-99 text-md text-nowrap">
                                <div x-data="{ openActions: false }">
                                    <div x-on:click="openActions = !openActions"
                                        class="p-1 flex items-center justify-center cursor-pointer transition-all duration-100 ease-in-out rounded-full hover:bg-[rgba(0,0,0,0.08)]">

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
                                        class="absolute overflow-hidden  right-11 z-10 transform max-w-m origin-top-right w-[170px]">

                                        <div
                                            class=" overflow-y-auto rounded-l-lg rounded-br-lg rounded-tr-none h-3/5 max-h-full
                                    min-h-[20%]">
                                            <div class="flex flex-col font-black bg-[rgba(53,53,53,0.95)]">

                                                @if ($inventory->status !== 'New Item')
                                                    <button
                                                        x-on:click="$wire.displayInventoryForm(), openActions = !openActions"
                                                        wire:click="getStockPrice({{ $inventory->id }})"
                                                        class="flex transition-all duration-100 ease-in-out hover:pl-3 hover:text-blue-300 flex-row items-center gap-2 px-2 py-2 text-white justify-left hover:bg-[rgb(37,37,37)]">
                                                        <div>
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="size-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                            </svg>
                                                        </div>
                                                        <div>Edit</div>
                                                    </button>
                                                @endif

                                                <div class="w-full border border-[rgb(39,39,39)]"></div>

                                                @if ($inventory->status !== 'New Item')
                                                    <button
                                                        x-on:click="$wire.displayStockAdjustPage(), openActions = !openActions"
                                                        wire:click="getStockID({{ $inventory->id }})"
                                                        class="flex transition-all duration-100 ease-in-out hover:pl-3 hover:text-red-300 flex-row items-center gap-2 px-2 py-2 text-white justify-left hover:bg-[rgb(37,37,37)]">
                                                        <div><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" strokeWidth="1.5"
                                                                stroke="currentColor" class="size-6">
                                                                <path strokeLinecap="round" strokeLinejoin="round"
                                                                    d="M6 13.5V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 9.75V10.5" />
                                                            </svg></div>
                                                        <div>Stock Adjust</div>
                                                    </button>
                                                @endif

                                                <div class="w-full border border-[rgb(39,39,39)]"></div>

                                                {{-- x-on:click="showPrintModal=true; $wire.getBarcode('{{ $item->barcode }}'), openActions = !openActions " --}}

                                                @if ($inventory->status !== 'New Item')
                                                    <button
                                                        x-on:click="$wire.displayStockCard(), openActions = !openActions"
                                                        wire:click="getStock({{ $inventory->id }})"
                                                        class="flex transition-all duration-100 ease-in-out hover:pl-3 hover:text-yellow-300 flex-row items-center gap-2 px-2 py-2 text-white justify-left hover:bg-[rgb(37,37,37)]">
                                                        <div>
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" strokeWidth={1.5}
                                                                stroke="currentColor" class="size-6">
                                                                <path strokeLinecap="round" strokeLinejoin="round"
                                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                                            </svg>
                                                        </div>
                                                        <div>Stock Card</div>
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

                {{ $inventories->links() }}

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
