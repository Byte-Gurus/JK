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
                    class="w-1/2 p-4 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-black text-[rgb(53,53,53)] rounded-sm cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Search by Purchase Order No." required="" />

            </div>

            <div class="flex flex-row items-center justify-center gap-4">

                {{-- //*user type filter --}}

                <div class="flex flex-col gap-1">

                    <label class="text-sm font-medium text-gray-900 text-nowrap">Supplier:</label>

                    <select wire:model.live="supplierFilter"
                        class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md  block p-2.5 ">
                        <option value="0">All</option>

                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
        </div>


        {{-- //* tablea area --}}
        <div class="overflow-x-auto overflow-y-scroll scroll no-scrollbar h-[52vh]">

            <table class="w-full text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0">

                    <tr class=" text-nowrap">

                        {{-- //* company name --}}
                        <th wire:click="sortByColumn('created_at')" scope="col"
                            class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center">

                                <p>Date Created</p>

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </span>
                            </div>
                        </th>

                        {{-- //* purchase order number --}}
                        <th scope="col" class="px-4 py-3 text-center">Purchase Order No.</th>

                        {{-- //* supplier name --}}
                        <th scope="col" class="px-4 py-3 text-center">Status</th>

                        {{-- //* supplier name --}}
                        <th scope="col" class="px-4 py-3 text-left">Supplier Name</th>

                        {{-- //* actions --}}
                        <th scope="col" class="px-4 py-3 text-center">Actions</th>

                    </tr>
                </thead>

                {{-- //* table body --}}
                <tbody>

                    @foreach ($purchases as $purchase)
                        <tr
                            class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $purchase->created_at->format(' M d Y ') }}
                            </th>

                            {{-- //* purchase order no --}}
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $purchase->po_number }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                <p
                                    @if ($purchase->deliveryJoin->status == 'Delivered') class=" text-green-900 font-medium  bg-green-100 border border-green-900 text-xs text-center px-2 py-0.5 rounded-sm"

                                    @elseif ($purchase->deliveryJoin->status == 'Cancelled')

                                    class=" text-red-900 pointer-events-none font-medium  bg-red-100 border border-red-900 text-xs text-center px-2 py-0.5 rounded-sm"

                                    @elseif ($purchase->deliveryjoin->status == 'Complete Stock in')

                                    class=" text-blue-900 pointer-events-none font-medium  bg-blue-100 border border-blue-900 text-xs text-center px-2 py-0.5 rounded-sm"

                                    @elseif ($purchase->deliveryjoin->status == 'Stocked in with backorder')

                                    class=" text-purple-900 pointer-events-none font-medium  bg-purple-100 border border-purple-900 text-xs text-center px-2 py-0.5 rounded-sm"

                                    @elseif ($purchase->deliveryjoin->status == 'In Progress')

                                    class=" text-orange-900 pointer-events-none font-medium  bg-orange-100 border border-orange-900 text-xs text-center px-2 py-0.5 rounded-sm"

                                    @elseif ($purchase->deliveryjoin->status == 'Backorder complete')

                                    class=" text-orange-900 pointer-events-none font-medium  bg-pink-100 border border-pink-900 text-xs text-center px-2 py-0.5 rounded-sm" @endif>

                                    {{ $purchase->deliveryjoin->status }}
                                </p>
                            </th>

                            {{-- //* supplier --}}
                            <th scope="row"
                                class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap ">
                                {{ $purchase->supplierJoin->company_name }}
                            </th>

                            {{-- //* Action --}}
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
                                        class="absolute overflow-hidden right-20 z-10 transform max-w-m origin-top-right w-[170px]">
                                        <div
                                            class=" overflow-y-auto rounded-l-lg rounded-br-lg rounded-tr-none h-3/5 max-h-full
                                        min-h-[20%]">
                                            <div class="flex flex-col font-black bg-[rgba(53,53,53,0.95)]">
                                                <button
                                                    x-on:click=" $wire.displayPurchaseOrderDetails(); openActions = !openActions"
                                                    wire:click="getPo_ID({{ $purchase->id }})"
                                                    class="flex transition-all duration-100 ease-in-out hover:text-green-300 hover:pl-3 flex-row items-center gap-2 px-2 py-2 text-white justify-left hover:bg-[rgb(37,37,37)]">
                                                    <div><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                        </svg></div>
                                                    <div>View PO</div>
                                                </button>

                                                <div class="w-full border border-[rgb(39,39,39)]"></div>
                                                {{-- x-on:click="showPrintModal=true; $wire.getBarcode('{{ $item->barcode
                                            }}'), openActions = !openActions " --}}

                                                <button wire:click="printPO({{ $purchase->id }})"
                                                    x-on:click="window.open('{{ route('reorderlist.sales.report') }}', '_blank'); openActions = !openActions"
                                                    {{--
                                                x-on:click="$wire.displayPrintPurchaseOrderDetails(), openActions = !openActions"
                                                --}} {{-- wire:click="getStock({{ $inventory->id }})" --}}
                                                    class="flex transition-all duration-100 ease-in-out hover:pl-3 hover:text-orange-300 flex-row items-center gap-2 px-2 py-2 text-white justify-left hover:bg-[rgb(37,37,37)]">
                                                    <div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor"
                                                            class="size-6">
                                                            <path strokeLinecap="round" strokeLinejoin="round"
                                                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                                        </svg>
                                                    </div>
                                                    <div>Print PO</div>
                                                </button>
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

                {{ $purchases->links() }}

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
