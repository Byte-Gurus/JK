{{-- // --}}
<div class="relative my-[3vh] rounded-lg" x-cloak wire:poll.visible="1000ms">


    {{-- //* filters --}}
    <div class="flex flex-row items-center justify-between mb-[3vh]">

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
                class="w-1/2 p-3 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-black text-[rgb(53,53,53)] rounded-md cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                placeholder="Search by Purchase Order No." required="" />

        </div>

        <div class="flex flex-row items-center justify-center gap-4">

            {{-- //*user type filter --}}
            <div class="flex flex-col gap-1">

                <label class="text-sm font-thin text-gray-900 text-nowrap">Item Name:</label>

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

            {{-- //*user type filter --}}
            <div class="flex flex-col gap-1">

                <label class="text-sm font-thin text-gray-900 text-nowrap">Status:</label>

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

                <label class="text-sm font-thin text-gray-900 text-nowrap">Supplier:</label>

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
    <div class="overflow-x-auto overflow-y-scroll border-black scroll no-scrollbar h-[60vh]">
        <div class="grid grid-flow-row-dense grid-cols-3 gap-4 transition-transform duration-1000 ease-in-out">
            @foreach ($purchases as $purchase)
                <div
                    class="w-full grid grid-row-col grid-rows-12 h-[30vh] transition duration-1000 ease-in-out border shadow-md border-[rgb(53,53,53)] rounded-md bg-[rgb(255,248,241)]">
                    <div
                        class="flex text-[rgb(53,53,53)] h-fit border-b border-[rgb(53,53,53)] flex-row justify-between row-span-3 px-4 py-2">
                        <div class="flex flex-col">
                            <p class="text-2xl font-black">{{ $purchase->po_number }}</p>
                            <div class="flex flex-row items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                </svg>
                                <p class="text-sm italic font-medium"> {{ $purchase->supplierJoin->company_name }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="italic font-bold ">
                                {{ $purchase->created_at->format(' M d Y ') }}
                            </p>
                        </div>
                    </div>
                    <div class="grid h-full grid-flow-row px-4 overflow-auto leading-none row-span-7">
                        <div class="flex flex-row justify-between py-2">
                            <p>hi</p>
                            <p>hello</p>
                            <p>le</p>
                        </div>
                    </div>
                    <div class="row-span-2 flex items-center justify-between px-4 border-t border-[rgb(53,53,53)]">
                        <div class="flex flex-row justify-between ">
                            <div class="flex flex-row items-center gap-2">
                                <div
                                    @if ($purchase->deliveryJoin->status == 'Delivered') class="bg-green-200 border w-[16px] h-[16px] border-green-900 rounded-full pointer-events-none"

                                @elseif ($purchase->deliveryJoin->status == 'Cancelled')

                                class="text-xs font-thin text-center bg-red-200 border border-red-900 rounded-full w-[16px] h-[16px] pointer-events-none "

                                @elseif ($purchase->deliveryjoin->status == 'Complete Stock in')

                                class="text-xs font-thin text-center bg-blue-200 border border-blue-900 rounded-full w-[16px] h-[16px] pointer-events-none "

                                @elseif ($purchase->deliveryjoin->status == 'Stocked in with backorder')

                                class="text-xs font-thin text-center bg-purple-200 border border-purple-900 rounded-full w-[16px] h-[16px] pointer-events-none "

                                @elseif ($purchase->deliveryjoin->status == 'In Progress')

                                class="text-xs font-thin text-center bg-orange-320000 border border-orange-900 rounded-full w-[16px] h-[16px] pointer-events-none "

                                @elseif ($purchase->deliveryjoin->status == 'Backorder complete')

                                class="text-xs font-thin text-center bg-pink-200 border border-pink-900 rounded-full w-[16px] h-[16px] pointer-events-none " @endif>
                                </div>
                                <p class="text-sm ">{{ $purchase->deliveryjoin->status }}</p>
                            </div>
                        </div>
                        <div class="flex flex-row items-center gap-4">
                            <div class="cursor-pointer hover:bg-[rgb(255,234,174)] rounded-full p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                </svg>
                            </div>
                            <div x-on:click=" $wire.displayPurchaseOrderDetails(); openActions = !openActions"
                                wire:click="getPo_ID({{ $purchase->id }})"
                                class="underline transition-all duration-100 ease-in-out cursor-pointer">
                                <p class=" text-md hover:text-[rgb(138,117,59)]">View</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- //* table footer --}}
    <div>

        {{-- //*pagination --}}
        <div class="mx-4 my-2 text-nowrap">

            {{ $purchases->links() }}

        </div>

        {{-- //* per page --}}
        <div class="flex items-center justify-end mb-3 ">
            <div class="flex flex-row items-center px-6 py-2 border border-[rgb(53,53,53)] rounded-md">
                <label class="text-sm font-thin text-gray-900 w-15">Per Page</label>

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
