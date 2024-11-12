{{-- // --}}
<div class="relative my-[3vh] rounded-lg" x-cloak>

    <div class="relative w-full overflow-hidden border-[rgb(143,143,143)] border bg-white rounded-lg sm:rounded-lg">
        <form wire:submit.prevent="create">

            <div class="grid items-center justify-between grid-flow-col grid-cols-3 gap-4 py-4 pr-4 text-nowrap">
                {{-- <div
                    class="flex flex-row items-center gap-6 w-fit p-2 pr-4 bg-[rgb(40,23,83)] shadow-md shadow-[rgb(206,187,255)] text-white rounded-r-full">
                    <p class="text-[1em]">Purchase Order No</p>
                    <p class="text-[1.2em] font-black text-center w-fit">{{ $po_number }}</p>
                </div> --}}
                <div class="relative w-full">
                    {{-- <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">

                        <svg aria-hidden="true" class="w-5 h-5 text-black" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.100ms="search"
                        class="w-1/2 p-3 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-black text-[rgb(53,53,53)] rounded-md cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Search an Item" required="" /> --}}
                </div>
                {{-- <div class="flex flex-col col-span-1 gap-2 ">
                    <p class="text-[1em]">Supplier Name</p>
                    <select id="supplier" wire:model="select_supplier" required
                        class=" bg-[rgb(255,255,255)] border border-[rgb(53,53,53)] rounded-md text-gray-900 text-sm block w-1/2 px-4 py-2 appearance-auto ">
                        <option value="" selected>Select Supplier</option>
                        @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">
                            {{ $supplier->company_name }}</option>
                        @endforeach

                        @error('select_supplier')
                        <span class="font-medium text-red-500 error">{{ $message }}</span>
                        @enderror
                    </select>
                </div> --}}
                <div class="flex flex-row items-center justify-end col-span-1 gap-4 flex-nowrap text-nowrap">
                    <button type="submit" wire:click="test"
                        class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(212,212,212)] text-[rgb(53,53,53)] border rounded-lg ">
                        Test</button>
                    <div>
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
                </div>
            </div>

            {{-- //* tablea area --}}
            <div class=" overflow-x-auto overflow-y-scroll h-[58vh]  no-scrollbar scroll">

                <table class="w-full overflow-auto text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                        <tr class=" text-nowrap">

                            {{-- //* action --}}
                            <th scope="col" class="flex items-center justify-center gap-2 px-4 py-3 text-center ">

                                <input type="checkbox" wire:model.live="selectAll"
                                    class="w-6 h-6 text-red-300 ease-linear rounded-full transition-allduration-100 hover:bg-red-400 hover:text-red-600">

                            </th>

                            {{-- //* barcode --}}
                            <th scope="col" class="py-2 text-left">Barcode</th>

                            {{-- //* item name --}}
                            <th scope="col" class="py-2 text-left ">Item Name</th>

                            {{-- //* item name --}}
                            <th scope="col" class="py-2 text-left ">Description</th>

                            {{-- //* item name --}}
                            <th scope="col" class="py-2 text-left ">Unit</th>

                            {{-- //* item name --}}
                            <th scope="col" class="py-2 text-left ">Category</th>

                            {{-- //* stocks on hand --}}
                            <th scope="col" class="py-2 text-center">Stocks-On-Hand</th>

                            {{-- {-- //* stocks on hand --}}
                            <th scope="col" class="py-2 text-center text-wrap">Maximum stock level</th>

                            {{-- //* item reorder quantity --}}
                            <th scope="col" class="py-2 text-center text-wrap">Item Reorder Qty</th>

                            {{-- //* purchase quantity --}}
                            @if (in_array('true', $toOrderItems))
                            <th scope="col" class="py-2 text-center text-wrap">Purchase Qty</th>
                            @endif

                        </tr>
                    </thead>

                    {{-- //* table body --}}

                    <tbody>
                        {{-- @foreach ($reorder_lists as $index => $reorder_list)
                        <tr
                            class="border-b hover:bg-gray-100 border-[rgb(207,207,207)] transition ease-in duration-75 index:bg-red-400">
                            <th scope="row" class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                <div class="flex justify-center">
                                    <input type="checkbox" wire:model.live="selectedToRemove" value="{{ $index }}"
                                        class="w-6 h-6 text-red-300 transition-all duration-100 ease-linear rounded-full hover:bg-red-400 hover:text-red-600">
                                </div>
                            </th>
                            <th scope="row" class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                {{ $reorder_list['barcode'] }}
                            </th>
                            <th scope="row"
                                class="px-2 py-6 font-medium text-left text-gray-900 break-all text-md text-wrap whitespace-nowrap">
                                {{ $reorder_list['item_name'] }}
                            </th>
                            <th scope="row"
                                class="px-2 py-6 font-medium text-left text-gray-900 break-all text-wrap text-md whitespace-nowrap">
                                {{ $reorder_list['item_description'] }}
                            </th>
                            <th scope="row"
                                class="py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                {{ $reorder_list['total_quantity'] }}
                            </th>
                            <th scope="row"
                                class="py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                {{ $reorder_list['maximum_stock_level'] }}
                            </th>
                            <th scope="row"
                                class="py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                {{ $reorder_list['reorder_point'] }}
                            </th>
                            <th scope="row"
                                class="flex flex-col items-center justify-center py-6 font-medium text-gray-900 text-clip text-md whitespace-wrap">
                                <input type="number" wire:model="purchase_quantities.{{ $index }}" required
                                    class="bg-gray-100 self-center appearance-none border border-gray-400 text-gray-900 text-sm rounded-md text-center w-2/3 p-2.5">
                            </th>
                        </tr>
                        <tr>
                            <td colspan="8" class="text-center">
                                @error("purchase_quantities.$index")
                                <div class="p-1 bg-red-100">
                                    <span class="font-medium text-center text-red-500">{{ $message }}</span>
                                </div>
                                @enderror
                            </td>
                        </tr>
                        @endforeach --}}
                        @foreach ($reorderLists as $index => $reorderList)
                        <tr
                            class="border-b hover:bg-gray-100 border-[rgb(207,207,207)] transition ease-in duration-75 index:bg-red-400">
                            <th scope="row" class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                <div class="flex justify-center">
                                    <input type="checkbox" wire:model.live="toOrderItems.{{ $index }}"
                                        class="w-6 h-6 text-red-300 transition-all duration-100 ease-linear rounded-full hover:bg-red-400 hover:text-red-600">
                                </div>
                            </th>
                            <th scope="row" class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                {{ $reorderList->barcode }}
                            </th>
                            <th scope="row" class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                {{ $reorderList->item_name }}
                            </th>
                            <th scope="row" class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                {{ $reorderList->item_description }}
                            </th>
                            <th scope="row" class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                {{ $reorderList->item_unit }}
                            </th>

                            <th scope="row" class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
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
                                class="flex flex-col items-center justify-center py-6 font-medium text-gray-900 text-clip text-md whitespace-wrap">
                                @if (isset($toOrderItems[$index]) && $toOrderItems[$index])
                                <input type="number" wire:model.live="purchaseQuantities.{{ $index }}" required
                                    class="bg-gray-100 self-center appearance-none border border-gray-400 text-gray-900 text-sm rounded-md text-center w-2/3 p-2.5">

                                @error("purchaseQuantities.$index")
                                <span class="font-medium text-red-500 error">{{ $message }}</span>
                                @enderror
                                @endif
                            </th>

                            <th scope="row"
                                class="py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                @if (isset($toOrderItems[$index]) && $toOrderItems[$index])
                                <select wire:change="updateSelectSupplier({{ $index }}, $event.target.value)"
                                    wire.model.live="selectSuppliers.{{$index}}">
                                    @if (!isset($reorderList->lowest_item_cost))
                                    <option value="No Supplier" selected>No supplier for this item</option>
                                    @else
                                    <option value="No Supplier" selected>Yiipi</option>
                                    @endif

                                    @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">
                                        {{ $supplier->company_name }}</option>
                                    @endforeach
                                </select>

                                @error("selectSupplier.$index")
                                <span class="font-medium text-red-500 error">{{ $message }}</span>
                                @enderror
                                @endif
                            </th>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
