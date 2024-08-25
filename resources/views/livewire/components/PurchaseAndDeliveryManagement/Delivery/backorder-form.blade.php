<div x-show="showBackorderForm">
    <div class="flex flex-row h-[655px] gap-4 ">
        <div class="relative w-3/4 overflow-hidden border-[rgb(143,143,143)] border bg-white rounded-lg sm:rounded-lg">
            <form wire:submit.prevent="create">
                <div class="flex flex-row items-center justify-between gap-4 py-6 pr-4 my-2 text-nowrap">

                    <div
                        class="flex flex-row items-center gap-6 w-fit p-2 pr-4 bg-[rgb(40,23,83)] shadow-md shadow-[rgb(206,187,255)] text-white rounded-r-full">
                        <div>
                            <p class="text-[1em] font-thin text-center w-full">PO number</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="text-[1.2em] font-black">{{ $po_number }}</p>
                        </div>
                        <div>
                            |
                        </div>
                        <div>
                            <p class="text-[1em] font-thin text-center w-full">Supplier</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="text-[1.2em] font-black">{{ $supplier }}</p>
                        </div>
                    </div>
                </div>

                {{-- //* tablea area --}}
                <div class="h-[680px] pb-[136px] overflow-x-auto overflow-y-scroll  no-scrollbar scroll">

                    <table class="w-full overflow-auto text-sm text-left scroll no-scrollbar">

                        {{-- //* table header --}}
                        <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                            <tr class=" text-nowrap">

                                {{-- //* action --}}
                                <th scope="col" class="flex justify-center gap-2 px-4 py-3 text-center items-cente ">

                                    <input type="checkbox" wire:model="selectAllToReorder" wire:click="reorderAll"
                                        class="w-6 h-6 text-red-300 ease-linear rounded-full transition-allduration-100 hover:bg-red-400 hover:text-red-600">

                                </th>

                                {{-- //* barcode --}}
                                <th scope="col" class="px-4 py-3 text-left">Barcode</th>

                                {{-- //* item name --}}
                                <th scope="col" class="px-4 py-3 text-left">Item Name</th>

                                {{-- //* item reorder quantity --}}
                                <th scope="col" class="py-3 text-center">Backorder Quantity</th>

                                {{-- //* purchase quantity --}}
                                <th scope="col" class="py-3 text-center text-nowrap">Status</th>

                            </tr>
                        </thead>

                        {{-- //* table body --}}

                        <tbody>
                            @foreach ($backorder_lists as $index => $backorder_list)
                                <tr
                                    class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">

                                    <th scope="row"
                                        class="py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                        <div class="flex justify-center">
                                            <input type="checkbox" wire:model="selectedToReorder"
                                                value="{{ $index }}"
                                                class="w-6 h-6 text-red-300 transition-all duration-100 ease-linear rounded-full hover:bg-red-400 hover:text-red-600">
                                        </div>
                                    </th>

                                    <th scope="row"
                                        class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                        {{ $backorder_list['barcode'] }}
                                    </th>

                                    <th scope="row"
                                        class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                        {{ $backorder_list['item_name'] }}
                                    </th>

                                    <th scope="row"
                                        class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                        {{ $backorder_list['backorder_quantity'] }}
                                    </th>

                                    <th scope="row"
                                        class="px-4 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                        {{ $backorder_list['status'] }}
                                    </th>

                                    {{-- //* purchase number --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        {{-- Removed Item Section --}}
        <div
            class="relative w-1/2 overflow-hidden border border-[rgb(143,143,143)] bg-[rgb(255,249,231)] sm:rounded-lg">
            <div class="flex flex-row gap-4 m-4 justify-evenly text-nowrap">
                <div class="flex flex-col">
                    <div>
                        <p class="text-[1.2em]">Purchase Order No</p>
                        <p class="text-[1.2em] font-black text-center w-full">{{ $po_number }}</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="supplier" class="text-[1.2em]">Supplier Name</label>
                        <select id="supplier" wire:model="select_supplier" required
                            class=" bg-[rgb(255,255,255)] border border-[rgb(53,53,53)] rounded-md text-gray-900 text-sm block w-fit px-4 py-2 appearance-auto ">
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
                </div>
                <div class="flex flex-row items-center gap-4">
                    <div>
                        <button
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(195,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(141,255,128)] transition-all duration-100 ease-in-out">Reorder</button>
                    </div>
                    <div>
                        <button
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out">Cancel
                            PO</button>
                    </div>
                </div>
            </div>

            <div class="h-[680px] pb-[150px] overflow-x-auto overflow-y-scroll no-scrollbar scroll">

                <table class="w-full overflow-auto text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead
                        class="text-xs text-[rgb(53,53,53)] uppercase cursor-default bg-[rgb(247,228,187)] sticky top-0   ">

                        <tr class=" text-nowrap">

                            {{-- //* action --}}
                            <th scope="col"
                                class="flex items-center justify-center gap-2 px-4 py-3 text-center justi ">

                                <input type="checkbox" wire:model="selectAllToRestore" wire:click="restoreAll"
                                    class="w-6 h-6 text-red-300 transition-all duration-100 ease-linear rounded-full hover:bg-red-400 hover:text-red-600">

                            </th>

                            {{-- //* barcode --}}
                            <th scope="col" class="py-3 text-left ">Barcode</th>

                            {{-- //* item name --}}
                            <th scope="col" class="py-3 text-left ">Item Name</th>

                            {{-- //* stocks on hand --}}
                            <th scope="col" class="py-3 text-center ">Stocks-On-Hand</th>

                        </tr>
                    </thead>

                    {{-- //* table body --}}

                    <tbody>
                        @if (!empty($removed_items))
                            @foreach ($removed_items as $index => $removed_item)
                                <tr
                                    class="border-b hover:bg-[rgb(255,241,212)] border-[rgb(53,53,53)] transition ease-in duration-75 index:bg-red-400">
                                    <th scope="row"
                                        class="py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                        <div class="flex justify-center">
                                            <input type="checkbox" wire:model="selectedToRestore"
                                                value="{{ $index }}"
                                                class="w-6 h-6 text-red-300 transition-all duration-100 ease-linear rounded-full hover:bg-red-400 hover:text-red-600">
                                        </div>
                                    </th>
                                    <th scope="row"
                                        class="py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                        {{ $removed_item['barcode'] }}
                                    </th>
                                    <th scope="row"
                                        class="py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                        {{ $removed_item['item_name'] }}
                                    </th>

                                    <th scope="row"
                                        class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                        {{ $removed_item['total_quantity'] }}
                                    </th>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
