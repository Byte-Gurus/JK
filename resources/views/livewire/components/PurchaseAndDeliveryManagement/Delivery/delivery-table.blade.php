{{-- // --}}
<div class="relative bg-black rounded-lg" x-show="showDeliveryTable" wire:poll.visible="1000ms">


    <div class="relative overflow-hidden bg-white border border-[rgb(143,143,143)] sm:rounded-md">

        {{-- //* filters --}}
        <div class="flex flex-row items-center justify-between px-4 py-4">

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
                    class="w-1/2 p-4 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-black text-[rgb(53,53,53)] rounded-sm cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Search by Purchase Order No." required="" />

            </div>


            <div class="flex flex-row items-center justify-center gap-4">

                {{-- //*user type filter --}}


                <div class="flex flex-col gap-1">

                    <label class="text-sm font-medium text-gray-900 text-nowrap">Status:</label>

                    <select wire:model.live="statusFilter"
                        class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md  block p-2.5 ">
                        <option value="0">All</option>
                        <option value="Complete Stock in">Complete Stock in</option>
                        <option value="Delivered">Delivered</option>
                        <option value="In progress">In progress</option>
                        <option value="Cancelled">Cancelled</option>
                        <option value="Stocked in with backorder">Stocked in with backorder</option>

                    </select>
                </div>

                <div class="flex flex-col gap-1">

                    <label class="text-sm font-medium text-gray-900 text-nowrap">Supplier:</label>

                    <select wire:model.live="supplierFilter"
                        class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md block p-2.5 ">
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


                        {{-- //* supplier name --}}
                        <th scope="col" class="px-4 py-3">Supplier Name</th>

                        {{-- //* purchase order number --}}
                        <th scope="col" class="px-4 py-3 text-center">Purchase Order No.</th>

                        {{-- //* status --}}
                        <th scope="col" class="px-4 py-3 text-center">Status</th>

                        {{-- date ordered --}}
                        <th wire:click="sortByColumn('created_at')" scope="col"
                            class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center justify-center text-center">

                                <p>Date Ordered</p>

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </span>
                            </div>
                        </th>

                        {{-- //* date of delivery --}}
                        <th wire:click="sortByColumn('date_delivered')" scope="col"
                            class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center justify-center">

                                <p>Date of Delivery</p>

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
                        <th scope="col" class="px-4 py-3 text-center text-nowrap">Actions</th>
                    </tr>
                </thead>

                {{-- //* table body --}}
                <tbody>
                    @foreach ($deliveries as $delivery)
                        <tr
                            class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $delivery->purchaseJoin->supplierJoin->company_name }}
                            </th>

                            {{-- //* purchase number --}}
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">

                                {{ $delivery->purchaseJoin->po_number }}
                            </th>

                            {{-- //* item status --}}
                            <th scope="row" class="px-4 py-4 font-medium text-center text-md whitespace-nowrap">
                                <p
                                    @if ($delivery->status == 'Delivered') class=" text-green-900 font-medium bg-green-100
                                border border-green-900 text-xs text-center px-2 py-0.5 rounded-sm"

                                @elseif ($delivery->status == 'Cancelled')

                                class=" text-red-900 pointer-events-none font-medium bg-red-100 border border-red-900
                                text-xs text-center px-2 py-0.5 rounded-sm"

                                @elseif ($delivery->status == 'Complete Stock in')

                                class=" text-blue-900 pointer-events-none font-medium bg-blue-100 border border-blue-900
                                text-xs text-center px-2 py-0.5 rounded-sm"

                                @elseif ($delivery->status == 'Stocked in with backorder')

                                class=" text-purple-900 pointer-events-none font-medium bg-purple-100 border
                                border-purple-900 text-xs text-center px-2 py-0.5 rounded-sm"

                                @elseif ($delivery->status == 'In Progress')

                                class=" text-orange-900 pointer-events-none font-medium bg-orange-100 border
                                border-orange-900 text-xs text-center px-2 py-0.5 rounded-sm"

                                @elseif ($delivery->status == 'Backorder complete')

                                class=" text-orange-900 pointer-events-none font-medium bg-pink-100 border
                                border-pink-900 text-xs text-center px-2 py-0.5 rounded-sm" @endif>

                                    {{ $delivery->status }}
                                </p>
                            </th>

                            {{-- //* status --}}

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $delivery->created_at->format(' M d Y ') }}
                            </th>

                            {{-- <th scope="row"
                            class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                            <div class="flex justify-center ">

                                @if ($delivery->status === 'Cancelled')
                                <p>N/A</p>
                                @elseif ($delivery->status === 'In Progress')
                                <button wire:click="setDateToday({{ $delivery->id }})"
                                    class="px-4 py-2 transition-all duration-100 ease-in-out bg-red-200 rounded-md hover:bg-red-400">Set
                                    delivery today</button>
                                @else
                                <a scope="row"
                                    class="px-4 py-4 font-black text-center text-gray-900 text-md whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($delivery->date_delivered)->format(' M d Y ') }}
                                </a>
                                @endif
                            </div>
                        </th> --}}
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                <div class="flex justify-center ">

                                    @if ($delivery->status === 'Cancelled')
                                        <p>N/A</p>
                                    @elseif ($delivery->status === 'In Progress')
                                        <button x-on:click='$wire.displayDeliveryDatePicker()'
                                            wire:click="changeDate({{ $delivery->id }})"
                                            class="flex flex-row items-center gap-2 px-4 py-2 font-bold transition-none ease-in-out bg-green-100 border border-green-900 rounded-lg hover:bg-green-300 duration-0">
                                            <p>SET
                                                DELIVERY DATE</p>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                            </svg>

                                        </button>
                                        {{-- <input type="date"
                                    wire:change="changeDate({{ $delivery->id }}, $event.target.value)"
                                    wire:model="delivery_date{{ $delivery->id }}"
                                    class="bg-white focus:outline-black hover:shadow-sm hover:shadow-[rgb(53,53,53)] ease-in-out duration-100 transition-all cursor-pointer select-none text-gray-900 border border-[rgb(143,143,143)] text-sm rounded-md block w-fit text-center p-2.5">
                                --}}
                                @else
                                @if ($delivery->status == 'Delivered')
                                <div class="flex flex-row items-center gap-2 p-2">
                                    <div>
                                        <a scope="row"
                                            class="px-4 py-4 font-black text-center text-gray-900 text-md whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($delivery->date_delivered)->format(' M d Y ') }}
                                        </a>
                                    </div>
                                    <div class="flex items-center justify-center px-1 py-1 font-medium text-blue-600 transition-all duration-100 ease-in-out rounded-lg hover:bg-blue-100 "
                                        x-on:click='$wire.displayDeliveryDatePicker()'
                                        wire:click="changeDate({{ $delivery->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </div>
                                </div>
                                @else
                                <a scope="row"
                                    class="px-4 py-4 font-black text-center text-gray-900 text-md whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($delivery->date_delivered)->format(' M d Y ') }}
                                </a>
                                @endif
                                @endif
                            </div>
                        </th>

                        {{-- //* action --}}
                        <th class="relative h-full px-4 py-4 z-99 text-md text-nowrap">
                            @if ($delivery->status === 'Complete Stock in')
                            <div
                                class="flex items-center justify-center p-1 mx-auto text-center cursor-not-allowed w-fit">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </div>
                            @else
                            <div x-data="{ openActions: false }">
                                <div x-on:click="openActions = !openActions"
                                    class="p-1 w-fit mx-auto relative cursor-pointer transition-all duration-100 ease-in-out rounded-full hover:bg-[rgba(0,0,0,0.08)]">

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
                                    class="absolute overflow-hidden right-12 z-10 transform max-w-m origin-top-right w-[170px]">

                                    <div class=" overflow-y-auto rounded-l-lg rounded-br-lg rounded-tr-none h-3/5 max-h-full
                                        min-h-[20%]">
                                        <div class="flex flex-col font-black bg-[rgba(53,53,53,0.95)]">

                                            {{-- restock --}}
                                            @if ($delivery->status === 'Delivered')
                                            <button
                                                x-on:click="$wire.viewRestockForm(); $wire.getDeliveryID({{ $delivery->id }}); openActions = !openActions"
                                                class="flex transition-all duration-100 ease-in-out hover:text-blue-300 hover:pl-3 flex-row items-center gap-2 px-2 py-2 text-white justify-left hover:bg-[rgb(37,37,37)]">
                                                <div><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                    </svg>
                                                </div>
                                            </div>
                                        @else
                                            {{-- <a scope="row"
                                                class="px-4 py-4 font-black text-center text-gray-900 text-md whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($delivery->date_delivered)->format(' M d Y ')  }}
                                            </a> --}}
                                        @endif
                                    @endif
                                </div>
                            </th>

                            {{-- //* action --}}
                            <th class="relative h-full px-4 py-4 z-99 text-md text-nowrap">
                                @if ($delivery->status === 'Complete Stock in')
                                    <div
                                        class="flex items-center justify-center p-1 mx-auto text-center cursor-not-allowed w-fit">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                                        </svg>
                                    </div>
                                @else
                                    <div x-data="{ openActions: false }">
                                        <div x-on:click="openActions = !openActions"
                                            class="p-1 w-fit mx-auto relative cursor-pointer transition-all duration-100 ease-in-out rounded-full hover:bg-[rgba(0,0,0,0.08)]">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                            </svg>
                                        </div>

                                        <div x-show="openActions"
                                            x-transition:enter="transition ease-in-out duration-300" x-cloak
                                            x-transition:enter-start="transform opacity-100 scale-0"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-out duration-100"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-0"
                                            x-on:click.away="openActions = false"
                                            class="absolute overflow-hidden right-12 z-10 transform max-w-m origin-top-right w-[170px]">

                                            <div
                                                class=" overflow-y-auto rounded-l-lg rounded-br-lg rounded-tr-none h-3/5 max-h-full
                                        min-h-[20%]">
                                                <div class="flex flex-col font-black bg-[rgba(53,53,53,0.95)]">

                                                    {{-- restock --}}
                                                    @if ($delivery->status === 'Delivered')
                                                        <button
                                                            x-on:click="$wire.viewRestockForm(); $wire.getDeliveryID({{ $delivery->id }}); openActions = !openActions"
                                                            class="flex transition-all duration-100 ease-in-out hover:text-blue-300 hover:pl-3 flex-row items-center gap-2 px-2 py-2 text-white justify-left hover:bg-[rgb(37,37,37)]">
                                                            <div><svg xmlns="http://www.w3.org/2000/svg"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke-width="1.5" stroke="currentColor"
                                                                    class="size-6">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                                </svg></div>
                                                            <div>Restock</div>
                                                        </button>
                                                    @endif

                                                    @if ($delivery->status === 'In Progress')
                                                        <button
                                                            x-on:click="$wire.cancelDelivery({{ $delivery->id }}); openActions = !openActions"
                                                            class="flex transition-all duration-100 ease-in-out hover:text-red-300 hover:pl-3 flex-row items-center gap-2 px-2 py-2 text-white justify-left hover:bg-[rgb(37,37,37)]">
                                                            <div><svg xmlns="http://www.w3.org/2000/svg"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    strokeWidth={1.5} stroke="currentColor"
                                                                    class="size-6">
                                                                    <path strokeLinecap="round" strokeLinejoin="round"
                                                                        d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                                                </svg>
                                                            </div>
                                                            <div>Cancel Delivery</div>
                                                        </button>
                                                    @endif

                                                    @if (
                                                        ($delivery->status === 'Stocked in with backorder' && $delivery->purchaseJoin->backorderJoin->isNotEmpty()) ||
                                                            $delivery->status === 'Backorder complete')
                                                        <button
                                                            x-on:click="$wire.viewBackorderDetails(); openActions = !openActions"
                                                            wire:click="getPO_ID({{ $delivery->id }})"
                                                            class="flex transition-all duration-100 ease-in-out hover:text-purple-300 hover:pl-3 flex-row items-center gap-2 px-2 py-2 text-white justify-left hover:bg-[rgb(37,37,37)]">
                                                            <div><svg xmlns="http://www.w3.org/2000/svg"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    strokeWidth={1.5} stroke="currentColor"
                                                                    class="size-6">
                                                                    <path strokeLinecap="round" strokeLinejoin="round"
                                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                                </svg>
                                                            </div>
                                                            <div>Backorder</div>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- //* table footer --}}
        <div class="border-t border-[rgb(53,53,53)] ">

            {{-- //*pagination --}}
            <div class="mx-4 my-2 text-nowrap">

                {{ $deliveries->links() }}

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
