{{-- // --}}
<div class="relative">

    <div class="relative overflow-hidden bg-white border border-[rgb(143,143,143)] sm:rounded-lg">

        {{-- //* filters --}}
        <div class="flex flex-row items-center justify-between px-2 py-4">

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
                    class="w-1/2 p-2 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-black text-[rgb(53,53,53)] rounded-md cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Search by Delivery ID" required="" />


            </div>


            <div class="flex flex-row items-center justify-center gap-4">

                {{-- //*user type filter --}}
                <div class="flex flex-row items-center gap-2">



                </div>


                <div class="flex flex-row items-center">

                    <div class="flex flex-row items-center gap-2">

                        <label class="text-sm font-medium text-gray-900 text-nowrap">Status :</label>

                        <select wire:model.live="statusFilter"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-lg  block p-2.5 ">
                            <option value="0">All</option>
                            <option value="Delivered">Delivered</option>
                            <option value="In progress">In progress</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>

                        <div class="flex flex-row items-center gap-2">

                            <label class="text-sm font-medium text-gray-900 text-nowrap">Supplier :</label>

                            <select wire:model.live="supplierFilter"
                                class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-lg  block p-2.5 ">
                                <option value="0">All</option>

                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                                @endforeach


                            </select>

                        </div>

                    </div>
                </div>
            </div>
        </div>


        {{-- //* tablea area --}}
        <div class="overflow-x-auto overflow-y-scroll scroll h-[500px] ">

            <table class="w-full h-10 text-sm text-left scroll no-scrollbar">

                {{-- //* table header --}}
                <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                    <tr class=" text-nowrap">


                        {{-- //* supplier name --}}
                        <th scope="col" class="px-4 py-3">Supplier Name</th>

                        {{-- //* purchase order number --}}
                        <th scope="col" class="px-4 py-3 text-center">Purchase Order No.</th>

                        {{-- //* status --}}
                        <th scope="col" class="px-4 py-3 text-center">Status</th>

                        <th wire:click="sortByColumn('date_created')" scope="col"
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
                        </th>


                    </tr>
                </thead>

                {{-- //* table body --}}
                <tbody>
                    @foreach ($deliveries as $delivery)
                        <tr
                            class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">

                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $delivery->purchaseJoin->supplierJoin->company_name }}
                            </th>

                            {{-- //* purchase number --}}
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">

                                {{ $delivery->purchaseJoin->po_number }}
                            </th>

                            {{-- //* item status --}}
                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                <div class="flex justify-center ">
                                    <div
                                        @if ($delivery->status == 'Delivered ') class=" text-black  bg-green-400 border border-green-900 text-xs text-center font-medium px-2 py-0.5 rounded"

                                    @elseif ($delivery->status == 'Cancelled')

                                    class=" text-black bg-rose-400 border border-red-900 text-xs font-medium px-2 py-0.5 rounded "

                                    @elseif ($delivery->status == 'In Progress')

                                    class=" text-black bg-orange-400 border w-fit self-center border-orange-900 text-xs font-medium px-2 py-0.5 rounded " @endif>

                                        {{ $delivery->status }}
                                    </div>

                                </div>
                            </th>


                            {{-- //* status --}}

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{ $delivery->created_at->format('d-m-y h:i A') }}
                            </th>

                            <th scope="row"
                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{-- {{ $delivery->date_delivered }} --}}
                                <div class="flex justify-center ">
                                    <input type="date"
                                        class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-center text-gray-900 text-sm rounded-md  block w-2/3 p-2.5">
                                </div>
                            </th>

                            {{-- //* Action --}}
                            <th class="flex justify-center px-4 py-4 text-center text-md text-nowrap">

                                <div x-data="{ openActions: false }">
                                    <div x-on:click="openActions = !openActions"
                                        class="p-1 transition-all duration-100 ease-in-out rounded-full hover:bg-[rgb(237,237,237)]">

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
                                        class="absolute right-8 z-10 transform max-w-m origin-top-right w-[170px]">
                                        <div
                                            class=" overflow-y-auto rounded-l-lg rounded-br-lg rounded-tr-none shadow-lg h-3/5 shadow-slate-300 ring-1 ring-black ring-opacity-5 max-h-full
                                    min-h-[20%]">
                                            <div class="flex flex-col font-black bg-[rgb(255,255,255)]">
                                                <button
                                                    x-on:click="$wire.showRestockForm(); $wire.getDeliveryID({{ $delivery->id }}); openActions = !openActions"
                                                    class="flex flex-row items-center gap-2 px-2 py-2 text-blue-600 justify-left hover:bg-blue-100">
                                                    <div><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                        </svg></div>
                                                    <div>Restock</div>
                                                </button>
                                                <div class="w-full border border-[rgb(205,205,205)]"></div>
                                                <button
                                                x-on:click="$wire.viewDeliveryDetails(); openActions = !openActions"
                                                    class="flex flex-row items-center gap-2 px-2 py-2 text-yellow-600 justify-left hover:bg-yellow-100">
                                                    <div><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                                        </svg>
                                                    </div>
                                                    <div>View Details</div>
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
        <div class="border-t border-[rgb(53,53,53)] ">

            {{-- //*pagination --}}
            <div class="mx-4 my-2 text-nowrap">

                {{ $deliveries->links() }}

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
