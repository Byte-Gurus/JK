{{-- // --}}
<div class="relative my-[3vh] rounded-lg" x-cloak>

    <div class="relative w-full overflow-hidden bg-white rounded-lg sm:rounded-lg">
        <form wire:submit.prevent="create">

            <div class="grid grid-flow-col grid-cols-12 gap-4">

                <div class="flex flex-col col-span-9">
                    <div class="flex flex-row justify-between">
                        <div class="relative w-full mb-4">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">

                                <svg aria-hidden="true" class="w-5 h-5 text-black" fill="currentColor"
                                    viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>

                            <input type="text" wire:model.live.debounce.100ms="search" {{ $isAnyChecked ? 'disabled'
                                : '' }}
                                class="w-1/2 px-4 py-2 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-black text-[rgb(53,53,53)] rounded-md cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Search an Item" />
                        </div>
                        <div>
                            @if (empty($purchaseQuantities) || empty($reorderLists) || empty($selectSuppliers))
                            <button wire:click="getSelectedItems" type="button" disabled
                                class="relative flex flex-row items-center px-8 py-2 transition-all duration-100 ease-in-out bg-gray-400 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                                <p class="absolute bottom-0 text-[0.2em] left-6 italic font-thin">transfer</p>
                            </button>
                            @else
                            <button wire:click="getSelectedItems" type="button"
                                class="relative flex flex-row items-center px-8 py-2 transition-all duration-100 ease-in-out bg-orange-200 rounded-lg hover:bg-orange-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                                <p class="absolute bottom-0 text-[0.2em] text-orange-900 left-6 italic font-thin">
                                    transfer</p>
                            </button>
                            @endif
                        </div>
                    </div>
                    {{-- //* tablea area --}}
                    <div
                        class="border-[rgb(143,143,143)] col-span-9 border rounded-lg overflow-x-auto overflow-y-scroll h-[62vh]  no-scrollbar scroll">

                        <table class="w-full overflow-auto text-sm text-left scroll no-scrollbar">

                            {{-- //* table header --}}
                            <thead
                                class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                                <tr class=" text-nowrap">

                                    {{-- //* action --}}
                                    <th scope="col"
                                        class="flex items-center justify-center gap-2 px-4 py-3 text-center ">

                                        <input type="checkbox" wire:model.live="selectAll"
                                            class="w-6 h-6 text-red-300 ease-linear rounded-full transition-allduration-100 hover:bg-red-400 hover:text-red-600">

                                    </th>

                                    {{-- //* item name --}}
                                    <th scope="col" class="py-2 text-left break-words text-wrap">Name</th>

                                    {{-- //* item name --}}
                                    <th scope="col" class="py-2 text-left break-words text-wrap">Desc</th>

                                    {{-- //* item name --}}
                                    <th scope="col" class="py-2 text-left ">Unit</th>

                                    {{-- //* item name --}}
                                    <th scope="col" class="py-2 text-left ">Category</th>

                                    {{-- //* stocks on hand --}}
                                    <th scope="col" class="py-2 text-center text-wrap">Stocks On Hand</th>

                                    {{-- {-- //* stocks on hand --}}
                                    <th scope="col" class="py-2 text-center text-wrap">Max Stock Lvl</th>

                                    {{-- //* item reorder quantity --}}
                                    <th scope="col" class="py-2 text-center text-wrap">Reorder Qty</th>

                                    @if (in_array('true', $toOrderItems))
                                    {{-- //* item reorder quantity --}}
                                    <th scope="col" class="px-4 py-2 text-left text-wrap">Best Price</th>
                                    @endif

                                    {{-- //* purchase quantity --}}
                                    @if (in_array('true', $toOrderItems))
                                    <th scope="col" class="py-2 text-center text-wrap">Purchase Qty</th>
                                    @endif

                                </tr>
                            </thead>

                            {{-- //* table body --}}

                            <tbody>

                                @foreach ($reorderLists as $index => $reorderList)
                                <tr
                                    class="border-b hover:bg-gray-100 border-[rgb(207,207,207)] transition ease-in duration-75 index:bg-red-400">
                                    <th scope="row"
                                        class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                        <div class="flex justify-center">
                                            <input type="checkbox" wire:model.live="toOrderItems.{{ $index }}"
                                                class="w-6 h-6 text-red-300 transition-all duration-100 ease-linear rounded-full hover:bg-red-400 hover:text-red-600">
                                        </div>
                                    </th>
                                    <th scope="row" class="py-6 text-left text-gray-900 text-md whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <p class="font-bold break-words w-[100px] text-wrap">
                                                {{ $reorderList->item_name }}
                                            </p>
                                            <p class="italic font-thin">
                                                {{ $reorderList->barcode }}
                                            </p>
                                        </div>
                                    </th>
                                    <th scope="row"
                                        class="py-6 font-medium break-words w-[100px] text-wrap text-left text-gray-900 text-md whitespace-nowrap">
                                        <p class="font-bold break-words w-[100px] text-wrap">
                                            {{ $reorderList->item_description }}
                                        </p>
                                    </th>
                                    <th scope="row"
                                        class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                        {{ $reorderList->item_unit }}
                                    </th>

                                    <th scope="row"
                                        class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                        {{ $reorderList->item_category }}
                                    </th>

                                    <th scope="row"
                                        class="py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                        {{ $reorderList->total_stock_quantity }}
                                    </th>
                                    <th scope="row"
                                        class="py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                        {{ $reorderList->maximum_stock_level }}
                                    </th>
                                    <th scope="row"
                                        class="py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                        {{ $reorderList->reorder_point }}
                                    </th>

                                    <th scope="row"
                                        class="py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                        @if (isset($toOrderItems[$index]) && $toOrderItems[$index])
                                        <select
                                            class="bg-gray-100 border border-[rgb(53,53,53)] hover:bg-gray-50 transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md p-2.5 "
                                            wire:change="updateSelectSupplier({{ $index }}, $event.target.value)"
                                            wire.model.live="selectSuppliers.{{ $index }}">


                                            @if (isset($reorderList->lowestSupplier))
                                            <option value="{{ $reorderList->lowestSupplier->id }}" selected>
                                                {{ $reorderList->lowestSupplier->company_name }} -
                                                ₱{{
                                                number_format($reorderList->lowestSupplier->supplierItemsJoin->item_cost,
                                                2) }}
                                            </option>
                                            @else
                                            <option value="No Supplier" selected>No supplier for this item
                                            </option>
                                            @endif


                                            @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">
                                                {{ $supplier->company_name }} -
                                                @if (
                                                $supplier->supplierItemsJoin->isNotEmpty() &&
                                                $supplier->supplierItemsJoin->first()->item_cost > 0 &&
                                                isset($reorderList->lowestSupplier))
                                                ₱{{ number_format($supplier->supplierItemsJoin->first()->item_cost, 2)
                                                }}
                                                @else
                                                No Price yet
                                                @endif
                                            </option>
                                            @endforeach

                                        </select>

                                        @error("selectSuppliers.$index")
                                        <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror
                                        @endif
                                    </th>

                                    <th scope="row"
                                        class="py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap">

                                        @if (isset($toOrderItems[$index]) && $toOrderItems[$index])
                                        <input type="number" wire:model.live="purchaseQuantities.{{ $index }}" required
                                            class="bg-gray-100 self-center hover:bg-gray-50 appearance-none border border-gray-400 text-gray-900 text-sm rounded-md text-center w-2/3 p-2.5">

                                        @error("purchaseQuantities.$index")
                                        <span class="font-medium text-red-500 error">{{ $message }}</span>
                                        @enderror
                                        @endif
                                    </th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex flex-col col-span-3">
                    <div class="self-end col-span-1 mb-4">
                        @if (empty($orders))
                        <button type="submit" disabled
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(212,212,212)] text-[rgb(53,53,53)] border rounded-lg ">
                            Save</button>
                        @else
                        <button type="submit"
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-lg hover:bg-[rgb(158,255,128)] transition-all duration-100 ease-in-out">
                            Save</button>
                        @endif
                    </div>
                    {{-- <button type="button" wire:click="test"
                        class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-lg hover:bg-[rgb(158,255,128)] transition-all duration-100 ease-in-out">
                        Test</button> --}}
                    @if (empty($orders))
                    <div
                        class="border col-span-1 flex-col rounded-lg bg-[#e8e8e8ad] shadow-lg border-[rgb(143,143,143)]">
                        <div
                            class="px-4 py-0.2 m-2 italic text-red-900 hover:shadow-2xl shadow-2xl hover:shadow-red-900 bg-[#adadadad] rounded-md w-fit">
                            <button disabled type="button" wire:click="removeAll">Delete All</button>
                        </div>
                        <div class="flex gap-2 flex-col m-2 h-[49vh] no-scrollbar overflow-y-auto ">
                            @foreach ($orders as $index => $order)
                            <div class="p-2 bg-[rgb(255,248,237)] border border-black rounded-lg">
                                <div class="relative ">
                                    <button type="button" class="absolute right-0 p-1 rounded-md hover:bg-red-300 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="text-red-800 size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="grid grid-flow-col grid-cols-8 gap-2">
                                    <div class="flex col-span-5 flex-col flex-wrap items-start gap-0.5 mb-2">
                                        <p class="w-full text-xl font-semibold break-words text-wrap">
                                            {{ $order['item']->item_name }}
                                        </p>
                                        <p class=" w-full font-[400] break-words text-l text-wrap">
                                            {{ $order['item']->item_description }}
                                        </p>
                                    </div>
                                    <div
                                        class="col-span-2 items-center py-1 px-3 border h-fit text-center border-black rounded-lg bg-[rgb(255,242,222)]">
                                        <p class="text-sm italic font-medium">
                                            {{ $order['item']->item_unit }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-row items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                    </svg>
                                    <p class="w-full text-sm italic break-words text-wrap">
                                        {{ $order['supplier']->company_name }}
                                    </p>
                                </div>

                                <div class="grid grid-flow-col ">
                                    <div class="flex flex-row items-center justify-start gap-4">
                                        <p class="font-semibold text-md">
                                            Quantity
                                        </p>
                                        <p class="pb-[1px] pt-[2.4px] text-sm font-medium border-b border-black">
                                            {{ $order['purchaseQuantities'] }}
                                        </p>
                                    </div>
                                    <div class="flex flex-row items-center justify-start gap-4">
                                        <p class="font-semibold text-md">
                                            Cost
                                        </p>
                                        <p class="pb-[1px] pt-[2.4px] text-sm font-medium border-b border-black">
                                            ₱{{ number_format($order['supplierItem']->item_cost ?? 0.0, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div
                            class="grid grid-flow-row px-4 py-2 italic text-gray-800 bg-[rgb(167,167,167)] border border-gray-700 rounded-b-lg">
                            <p class="font-semibold text-left text-md">Overall Estimated Cost</p>
                            <p class="text-2xl font-black text-center">₱{{ number_format($orderTotal, 2) }}</p>
                        </div>
                    </div>
                    @else
                    <div class="border col-span-1 flex-col rounded-lg bg-[#FCFCF2] shadow-lg border-[rgb(143,143,143)]">
                        <div
                            class="px-4 py-0.2 m-2 italic text-red-100 hover:shadow-2xl shadow-2xl hover:shadow-red-900 bg-red-400 border-red-700 rounded-md w-fit hover:bg-red-500 hover:text-red-100">
                            <button type="button" wire:click="removeAll">Delete All</button>
                        </div>
                        <div class="flex gap-2 flex-col m-2 h-[49vh] no-scrollbar overflow-y-auto ">
                            @foreach ($orders as $index => $order)
                            <div class="p-2 bg-[rgb(255,248,237)] border border-black rounded-lg">
                                <div class="relative ">
                                    <button type="button" class="absolute right-0 p-1 rounded-md hover:bg-red-300 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="text-red-800 size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="grid grid-flow-col grid-cols-8 gap-2">
                                    <div class="flex col-span-5 flex-col flex-wrap items-start gap-0.5 mb-2">
                                        <p class="w-full text-xl font-semibold break-words text-wrap">
                                            {{ $order['item']->item_name }}
                                        </p>
                                        <p class=" w-full font-[400] break-words text-l text-wrap">
                                            {{ $order['item']->item_description }}
                                        </p>
                                    </div>
                                    <div
                                        class="col-span-2 items-center py-1 px-3 border h-fit text-center border-black rounded-lg bg-[rgb(255,242,222)]">
                                        <p class="text-sm italic font-medium">
                                            {{ $order['item']->item_unit }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-row items-center gap-2 mb-2"
                                    wire:click="removeRowOrder({{$index}})">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                    </svg>
                                    <p class="w-full text-sm italic break-words text-wrap">
                                        {{ $order['supplier']->company_name }}
                                    </p>
                                </div>

                                <div class="grid grid-flow-col ">
                                    <div class="flex flex-row items-center justify-start gap-4">
                                        <p class="font-semibold text-md">
                                            Quantity
                                        </p>
                                        <p class="pb-[1px] pt-[2.4px] text-sm font-medium border-b border-black">
                                            {{ $order['purchaseQuantities'] }}
                                        </p>
                                    </div>
                                    <div class="flex flex-row items-center justify-start gap-4">
                                        <p class="font-semibold text-md">
                                            Cost
                                        </p>
                                        <p class="pb-[1px] pt-[2.4px] text-sm font-medium border-b border-black">
                                            ₱{{ number_format($order['supplierItem']->item_cost ?? 0.0, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div
                            class="grid grid-flow-row px-4 py-2 italic text-green-800 bg-[rgb(237,255,203)] border border-green-700 rounded-b-lg">
                            <p class="font-semibold text-left text-md">Overall Estimated Cost</p>
                            <p class="text-2xl font-black text-center">₱{{ number_format($orderTotal, 2) }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
<script src="pikaday.js"></script>
<script>
    var picker = new Pikaday({
        field: document.getElementById('datepicker')
    });
</script>
