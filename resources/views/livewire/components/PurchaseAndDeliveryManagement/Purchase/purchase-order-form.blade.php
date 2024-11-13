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
                                placeholder="Search an Item" required="" />f
                        </div>
                        <div>
                            <button wire:click="getSelectedItems" type="button"
                                class="flex flex-row items-center px-8 py-2 transition-all duration-100 ease-in-out bg-orange-200 rounded-lg hover:bg-orange-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </button>
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

                                    {{-- //* barcode --}}
                                    <th scope="col" class="py-2 text-left">Barcode</th>

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
                                    <th scope="row"
                                        class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                        {{ $reorderList->barcode }}
                                    </th>
                                    <th scope="row"
                                        class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                        {{ $reorderList->item_name }}
                                    </th>
                                    <th scope="row"
                                        class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                        {{ $reorderList->item_description }}
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
                                                @if ($supplier->supplierItemsJoin->isNotEmpty() &&
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
                                        class="flex flex-col items-center justify-center py-6 font-medium text-gray-900 text-clip text-md whitespace-wrap">
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
                <div class="flex flex-col col-span-3 ">
                    <div class="self-end col-span-1 mb-4">
                        @if (empty($purchaseQuantities) || empty($reorderLists))
                        <button type="submit" disabled
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(212,212,212)] text-[rgb(53,53,53)] border rounded-lg ">
                            Save</button>
                        @else
                        <button type="submit"
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-lg hover:bg-[rgb(158,255,128)] transition-all duration-100 ease-in-out">
                            Save</button>
                        @endif
                    </div>
                    <button type="button" wire:click="test"
                        class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-lg hover:bg-[rgb(158,255,128)] transition-all duration-100 ease-in-out">
                        Test</button>


                    <div
                        class="border h-full col-span-11 flex-col rounded-lg bg-[#FCFCF2] shadow-lg border-[rgb(143,143,143)]">

                        <div
                            class="grid grid-flow-row px-4 py-2 italic text-green-800 bg-[rgb(237,255,203)] border-b-8 border-green-700 rounded-lg">
                            <p class="font-semibold text-left text-md">Estimated Cost</p>
                            <p class="text-2xl font-black text-center">₱20.00</p>
                        </div>
                        @foreach ($orders as $index => $order)
                        <div class="px-4 my-2">
                            {{$order['item']->item_name}}
                            {{$order['item']->item_description}}
                            {{$order['item']->item_unit}}
                            {{$order['supplier']->company_name}}
                            {{$order['supplierItem']->item_cost ?? 0.00}}
                            {{$order['purchaseQuantities']}}

                        </div>
                        <div></div>
                        @endforeach
                    </div>


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
