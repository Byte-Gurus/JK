{{-- // --}}
<div class="relative rounded-lg" x-show="showDeliveryTable" x-cloak wire:poll.visible="1000ms">


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
                placeholder="Search by PO No. or Item." required="" />

        </div>

        <div class="flex flex-row items-center justify-center gap-4">



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

    <div
        class="overflow-x-auto overflow-y-scroll border rounded-md border-[rgb(149,149,149)] shadow-md bg-[rgb(252,252,252)] p-2 scroll no-scrollbar h-[60vh]">
        @if (empty($deliveries))
            <div class="flex items-center justify-center w-full h-full">
                <p class="text-[1.8em] opacity-40 font-black">NO PURCHASE ORDERS YET</p>
            </div>
        @else
            <div class="grid grid-cols-2 gap-4 transition-transform duration-1000 ease-in-out lg:grid-cols-3">
                @foreach ($deliveries as $delivery)
                    <div
                        class="w-full transition duration-200 ease-in-out border shadow-md hover:shadow-blue-900 border-[rgb(53,53,53)] rounded-md bg-[rgb(241,250,255)]">
                        <div
                            class="flex h-fit pointer-events-none text-[rgb(53,53,53)] border-b border-[rgb(53,53,53)] flex-row justify-between row-span-3 px-4 py-2">
                            <div class="flex flex-col">
                                <p class="text-2xl font-black">{{ $delivery->purchaseJoin->po_number }}</p>
                                <div class="flex flex-row items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                    </svg>
                                    <p class="text-sm italic font-medium">
                                        {{ \Illuminate\Support\Str::limit($delivery->purchaseJoin->supplierJoin->company_name, 24, '...') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-col ">
                                <div class="flex flex-row items-center justify-end gap-1">
                                    <p class="text-sm italic font-thin">Created</p>
                                    <p class="italic font-bold text-right">
                                        {{ $delivery->created_at->format(' M d Y ') }}
                                    </p>
                                </div>
                                @if ($delivery->status == 'Delivered')
                                    <div class="flex flex-row items-center justify-end gap-1">
                                        <p class="text-sm italic font-thin">Delivered</p>
                                        <p class="italic font-bold text-right">
                                            {{ \Carbon\Carbon::parse($delivery->date_delivered)->format(' M d Y ') }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class=" overflow-x-auto overflow-y-scroll scroll h-[24vh] no-scrollbar">

                            <table class="w-full text-sm text-left scroll no-scrollbar">

                                {{-- //* table header --}}
                                <thead
                                    class="sticky top-0 text-xs font-medium text-[rgb(81,81,81)] italic uppercase bg-[rgb(211,255,246)] cursor-default">

                                    <tr class=" text-nowrap">

                                        <th scope="col" class="px-4 py-3 text-left">Item</th>

                                        {{-- //* status --}}
                                        <th scope="col" class="px-4 py-3 text-left">Unit</th>

                                        {{-- //* username --}}
                                        <th scope="col" class="px-4 py-3 text-center">Qty</th>

                                    </tr>
                                </thead>

                                {{-- //* table body --}}
                                <tbody>
                                    @foreach ($delivery->purchaseJoin->purchaseDetailsJoin as $purchaseDetail)
                                        <tr>

                                            {{-- //* name --}}
                                            <th scope="row"
                                                class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                                <div class="flex flex-col ">
                                                    <p
                                                        class="break-words text-left text-wrap font-bold text-md w-[140px]">
                                                        {{ $purchaseDetail->itemsJoin->item_name }}
                                                    </p>
                                                    <p class="break-words text-left text-md font-light w-[140px]">
                                                        {{ $purchaseDetail->itemsJoin->item_description }}
                                                    </p>
                                                </div>
                                            </th>

                                            {{-- //* contact number --}}
                                            <th scope="row"
                                                class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap ">
                                                {{ $purchaseDetail->itemsJoin->item_unit }}

                                            </th>

                                            {{-- //* role --}}
                                            <th scope="row"
                                                class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                                {{ $purchaseDetail->purchase_quantity }}
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class=" flex items-center justify-between px-4 py-1 border-t border-[rgb(53,53,53)]">
                            <div class="flex flex-row justify-between pointer-events-none ">
                                <div class="flex flex-row items-center gap-2">
                                    <div
                                        @if ($delivery->status == 'Delivered') class="bg-green-200 border
                                w-[16px] h-[16px] border-green-900 rounded-full pointer-events-none"

                                @elseif ($delivery->status == 'Cancelled')

                                class="text-xs font-thin text-center bg-red-200 border border-red-900 rounded-full
                                w-[16px] h-[16px] pointer-events-none "

                                @elseif ($delivery->status == 'Complete Stock in')

                                class="text-xs font-thin text-center bg-blue-200 border border-blue-900 rounded-full
                                w-[16px] h-[16px] pointer-events-none "

                                @elseif ($delivery->status == 'Stocked in with backorder')

                                class="text-xs font-thin text-center bg-purple-200 border border-purple-900 rounded-full
                                w-[16px] h-[16px] pointer-events-none "

                                @elseif ($delivery->status == 'In Progress')

                                class="text-xs font-thin text-center bg-orange-200 border border-orange-900
                                rounded-full w-[16px] h-[16px] pointer-events-none "

                                @elseif ($delivery->status == 'Backorder complete')

                                class="text-xs font-thin text-center bg-pink-200 border border-pink-900 rounded-full
                                w-[16px] h-[16px] pointer-events-none " @endif>
                                    </div>
                                    <p class="text-sm ">{{ $delivery->status }}</p>
                                </div>
                            </div>
                            <div class="flex justify-center gap-2">

                                @if ($delivery->status === 'Cancelled')
                                    <p class="italic font-medium text-md">N/A</p>
                                @elseif ($delivery->status === 'In Progress')
                                    <div class="flex flex-row items-center gap-2">
                                        <button x-on:click="$wire.cancelDelivery({{ $delivery->id }});"
                                            class="flex items-center p-1.5 transition-all duration-100 ease-in-out rounded-full hover:bg-red-200">
                                            <div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="text-red-500 size-6">
                                                    <path
                                                        d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                                                    <path fill-rule="evenodd"
                                                        d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.133 2.845a.75.75 0 0 1 1.06 0l1.72 1.72 1.72-1.72a.75.75 0 1 1 1.06 1.06l-1.72 1.72 1.72 1.72a.75.75 0 1 1-1.06 1.06L12 15.685l-1.72 1.72a.75.75 0 1 1-1.06-1.06l1.72-1.72-1.72-1.72a.75.75 0 0 1 0-1.06Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                        <button x-on:click='$wire.displayDeliveryDatePicker()'
                                            wire:click="changeDate({{ $delivery->id }})"
                                            class="flex flex-row items-center gap-2 px-2 py-0.5 font-bold transition-none ease-in-out bg-green-100 border border-green-900 rounded-lg hover:bg-green-300 duration-0">
                                            <p class="text-sm ">Set Delivery Date
                                            </p>
                                        </button>
                                    </div>
                                @endif

                                @if ($delivery->status == 'Delivered')
                                    <div class="  flex items-center text-[rgb(53,53,53)] transition-all duration-100 ease-in-out cursor-pointer underline"
                                        x-on:click='$wire.showImage({{ $delivery->id }})'>
                                        <p class="text-sm hover:text-[rgb(138,117,59)]">Receipt</p>
                                    </div>
                                    <div class="cursor-pointer hover:bg-[rgb(174,236,255)] rounded-full p-1"
                                        wire:click="printDelivery({{ $delivery->id }})"
                                        x-on:click="$wire.displayPrintDeliveryDetails()">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                        </svg>
                                    </div>
                                    <button x-on:click='$wire.displayDeliveryDatePicker()'
                                        wire:click="changeDate({{ $delivery->id }})"
                                        class="flex flex-row items-center gap-2 px-2 py-0.5 font-bold transition-none ease-in-out bg-orange-100 border border-orange-900 rounded-lg hover:bg-orange-300 duration-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
                                    <button
                                        x-on:click="$wire.viewRestockForm(); $wire.getDeliveryID({{ $delivery->id }});"
                                        class="flex flex-row items-center gap-2 px-2 py-0.5 font-bold transition-none ease-in-out bg-blue-100 border border-blue-900 rounded-lg hover:bg-blue-300 duration-0">
                                        <p class="text-sm ">Restock</p>
                                    </button>
                                @endif

                                @if ($delivery->status === 'Complete Stock in')
                                    <div class="  flex items-center text-[rgb(53,53,53)] transition-all duration-100 ease-in-out cursor-pointer underline"
                                        x-on:click=" $wire.showImage('{{ $delivery->id }}')">
                                        <p class="text-sm hover:text-[rgb(138,117,59)]">Receipt</p>
                                    </div>
                                    <div class="cursor-pointer hover:bg-[rgb(174,236,255)] rounded-full p-1"
                                        wire:click="printDelivery({{ $delivery->id }})"
                                        x-on:click="$wire.displayPrintDeliveryDetails()">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                        </svg>
                                    </div>
                                @endif

                                @if (
                                    ($delivery->status === 'Stocked in with backorder' && $delivery->purchaseJoin->backorderJoin->isNotEmpty()) ||
                                        $delivery->status === 'Backorder complete')
                                    <div class="  flex items-center text-[rgb(53,53,53)] transition-all duration-100 ease-in-out cursor-pointer underline"
                                        x-on:click=" $wire.showImage('{{ $delivery->id }}')">
                                        <p class="text-sm hover:text-[rgb(138,117,59)]">Receipt</p>
                                    </div>
                                    <div class="cursor-pointer hover:bg-[rgb(174,236,255)] rounded-full p-1"
                                        wire:click="printDelivery({{ $delivery->id }})"
                                        x-on:click="$wire.displayPrintDeliveryDetails()">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                        </svg>
                                    </div>
                                    <button x-on:click="$wire.viewBackorderDetails();"
                                        wire:click="getPO_ID({{ $delivery->id }})"
                                        class="flex flex-row items-center gap-2 px-2 py-0.5 font-bold transition-none ease-in-out bg-violet-100 border border-violet-900 rounded-lg hover:bg-violet-300 duration-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            strokeWidth={1.5} stroke="currentColor" class="size-6">
                                            <path strokeLinecap="round" strokeLinejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                        <p class="text-sm ">Backorder</p>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- //* table footer --}}
    <div>

        {{-- //*pagination --}}
        <div class="mx-4 my-2 text-nowrap">

            {{ $deliveries->links() }}

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
    @if ($receipt_picture)
        <div
            class="fixed inset-0 top-0 left-0 z-50 flex items-center justify-center w-screen h-screen bg-gray-900/50 ">

            <div class="flex flex-col items-center justify-center w-screen h-screen p-4 rounded-lg ">
                <div class="self-center bg-red-200 z-60">
                    <button type="button" wire:click='closeImage'
                        class="w-8 h-8 text-sm text-[rgb(255,120,120)] flex justify-center items-center bg-transparent rounded-lg hover:bg-[rgb(231,231,231)] transition duration-100 ease-in-out hover:text-[rgb(0,0,0)] ms-auto "
                        data-modal-hide="UserModal">

                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <img src="{{ $receipt_picture }}" alt="Customer ID Picture" class="w-1/3 h-1/2">
            </div>
        </div>
    @endif
</div>
