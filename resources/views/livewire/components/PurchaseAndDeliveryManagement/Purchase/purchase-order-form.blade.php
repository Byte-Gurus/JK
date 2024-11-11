{{-- // --}}
<div class="relative my-[3vh] rounded-lg" x-cloak>

    <div class="relative w-full overflow-hidden border-[rgb(143,143,143)] border bg-white rounded-lg sm:rounded-lg">
        <form wire:submit.prevent="create">

            <div class="grid items-center justify-between grid-flow-col grid-cols-3 gap-4 px-4 py-4 text-nowrap">
                <div class="flex flex-col col-span-1 gap-2 ">
                    <p class="text-[1em]">Purchase Order No</p>
                    <p class="text-[1.2em] font-black text-center w-fit">{{ $po_number }}</p>
                </div>
                <div class="flex flex-col col-span-1 gap-2 ">
                    <p class="text-[1em]">Item Name</p>
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
                </div>
                <div class="flex flex-col col-span-1 gap-2 ">
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
                </div>
                <div class="flex flex-row items-center justify-end col-span-1 gap-4 flex-nowrap text-nowrap">

                    <div>
                        @if (!empty($selectedToRemove) || empty($reorder_lists))
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

                                <input type="checkbox" wire:model="selectAllToRemove" wire:click="removeAll"
                                    class="w-6 h-6 text-red-300 ease-linear rounded-full transition-allduration-100 hover:bg-red-400 hover:text-red-600">

                            </th>

                            {{-- //* barcode --}}
                            <th scope="col" class="py-2 text-left">Barcode</th>

                            {{-- //* item name --}}
                            <th scope="col" class="px-2 py-2 text-left">Name</th>

                            {{-- //* item name --}}
                            <th scope="col" class="px-2 py-2 text-left">Description</th>

                            {{-- //* stocks on hand --}}
                            <th scope="col" class="py-2 text-center">Stocks-On-Hand</th>

                            {{-- {-- //* stocks on hand --}}
                            <th scope="col" class="py-2 text-center text-wrap">Maximum stock level</th>

                            {{-- //* item reorder quantity --}}
                            <th scope="col" class="py-2 text-center text-wrap">Item Reorder Qty</th>

                            {{-- //* purchase quantity --}}
                            <th scope="col" class="py-2 text-center text-wrap">Purchase Qty</th>

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
                                <th scope="row"
                                    class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                    <div class="flex justify-center">
                                        <input type="checkbox" wire:model.live="selectedToRemove"
                                            value="{{ $index }}"
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
                                    <input type="number" wire:model="purchase_quantities.{{ $index }}" required
                                        class="bg-gray-100 self-center appearance-none border border-gray-400 text-gray-900 text-sm rounded-md text-center w-2/3 p-2.5">
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
