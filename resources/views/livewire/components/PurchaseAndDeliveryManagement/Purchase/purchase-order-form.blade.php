{{-- // --}}
<div class="relative" x-show="showModal" x-cloak x-data="{ isCreate: @entangle('isCreate'), showModal: @entangle('showModal'), showEditModal: @entangle('showEditModal') }">
    <div class="flex flex-row gap-4 h-[640px] ">
        @if ($this->isCreate)
            <div class="relative w-full overflow-hidden bg-white border border-black rounded-lg shadow-lg sm:rounded-lg">
                <form wire:submit.prevent="create">

                    <div class="flex flex-row justify-between gap-4 px-8 py-4 text-nowrap">
                        <div>
                            <h1 class="text-[1.8em]">Purchase Order No</h1>
                            <h2 class="text-[2em] font-black text-center w-full">{{ $po_number }}</h2>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="supplier" class="text-[1.8em]">Supplier Name</label>
                            <select id="supplier" wire:model="supplier" required
                                class=" bg-[rgb(255,255,255)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                                <option value="" selected>Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">
                                        {{ $supplier->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-row items-center justify-center gap-2 flex-nowrap text-nowrap">
                            <div>
                                <button wire:click="addRows"
                                    class=" px-8 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(254,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,244,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out">
                                    Add Row</button>
                            </div>
                            <div>
                                <button type="submit"
                                    class=" px-8 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(158,255,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out">
                                    Save</button>
                            </div>
                        </div>
                    </div>

                    {{-- //* tablea area --}}
                    <div class="overflow-x-auto overflow-y-scroll h-[620px] scroll ">

                        <table class="w-full text-sm text-left scroll no-scrollbar">

                            {{-- //* table header --}}
                            <thead
                                class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                                <tr class=" text-nowrap">

                                    {{-- //* action --}}
                                    <th scope="col" class="px-4 py-3 text-center ">Action</th>

                                    {{-- //* barcode --}}
                                    <th scope="col" class="py-3 text-left">Barcode</th>

                                    {{-- //* item name --}}
                                    <th scope="col" class="py-3 text-left">Item Name</th>

                                    {{-- //* stocks on hand --}}
                                    <th scope="col" class="py-3 text-center ">Stocks-On-Hand</th>

                                    {{-- //* item reorder quantity --}}
                                    <th scope="col" class="py-3 text-center">Item Reorder Quantity</th>

                                    {{-- //* purchase quantity --}}
                                    <th scope="col" class="py-3 text-center text-nowrap">Purchase Quantity</th>
                                    </th>
                                </tr>
                            </thead>

                            {{-- //* table body --}}

                            <tbody>
                                @foreach ($reorder_lists as $index => $reorder_list)
                                    <tr
                                        class="border-b border-[rgb(207,207,207)] transition ease-in duration-75 index:bg-red-400">
                                        <th scope="row"
                                            class="py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">

                                            <div class="flex justify-center">

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor"
                                                    x-on:click="$wire.removeRow({{ $index }})"
                                                    class="w-10 h-10 text-center text-red-300 transition-all duration-100 ease-linear rounded-full hover:bg-red-400 hover:text-red-600">
                                                    <path strokeLinecap="round" strokeLinejoin="round"
                                                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>

                                            </div>



                                        <th scope="row"
                                            class="py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                            {{ $reorder_list['barcode'] }}
                                        </th>
                                        <th scope="row"
                                            class="py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                            {{ $reorder_list['item_name'] }}
                                        </th>
                                        <th scope="row"
                                            class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                            {{ $reorder_list['total_quantity'] }}
                                        </th>
                                        <th scope="row"
                                            class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                            {{ $reorder_list['reorder_point'] }}
                                        </th>
                                        <th scope="row"
                                            class="flex justify-center py-4 font-medium text-gray-900 text-clip text-md whitespace-nowrap">
                                            <input type="number" wire:model="purchase_quantities.{{ $index }}"
                                                required
                                                class="bg-[rgb(249,249,249)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg text-center w-1/2 p-2.5">
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            {{-- Removed Item Section --}}
            <div
                class="relative w-1/2 overflow-hidden border border-[rgb(30,24,9)] bg-[rgb(255,249,231)] sm:rounded-lg">


                <div class="flex justify-center px-2 py-10">
                    <div>
                        <h1 class="text-[1.8em] text-[rgb(65,47,20)] font-black">Removed Items</h1>
                    </div>

                </div>

                <div class="overflow-x-auto overflow-y-scroll h-[620px] scroll ">

                    <table class="w-full text-sm text-left scroll no-scrollbar">

                        {{-- //* table header --}}
                        <thead
                            class="text-xs text-[rgb(53,53,53)] uppercase cursor-default bg-[rgb(247,228,187)] sticky top-0   ">

                            <tr class=" text-nowrap">

                                {{-- //* action --}}
                                <th scope="col" class="px-4 py-3 text-center">Action</th>

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
                                        class="border-b border-[rgb(53,53,53)] transition ease-in duration-75 index:bg-red-400">
                                        <th scope="row"
                                            class="py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                            <div class="flex justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor"
                                                    class="w-10 h-10 text-center transition-all duration-100 ease-linear rounded-full text-[rgb(91,72,29)] hover:bg-[rgb(50,40,16)] hover:text-white"
                                                    x-on:click="$wire.restoreRow({{ $index }})">
                                                    <path strokeLinecap="round" strokeLinejoin="round"
                                                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                            </div>
                                        <th scope="row"
                                            class="py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                            {{ $reorder_list['barcode'] }}
                                        </th>
                                        <th scope="row"
                                            class="py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                            {{ $reorder_list['item_name'] }}
                                        </th>

                                        <th scope="row"
                                            class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                            {{ $reorder_list['total_quantity'] }}
                                        </th>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div
                class="relative w-full overflow-hidden bg-white border border-black rounded-lg shadow-lg sm:rounded-lg">
                <form wire:submit.prevent="create">
                    <div class="flex flex-row justify-between gap-4 px-8 py-4 text-nowrap">
                        <div>
                            <h1 class="text-[1.8em]">Purchase Order No</h1>
                            <h2 class="text-[2em] font-black text-center w-full">{{ $po_number }}</h2>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="supplier" class="text-[1.8em]">Supplier Name</label>
                            <select id="supplier" wire:model="supplier" required
                                class=" bg-[rgb(255,255,255)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                                <option value="" selected>Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">
                                        {{ $supplier->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-row items-center justify-center gap-2 flex-nowrap text-nowrap">
                            <div>
                                <button wire:click="addRows"
                                    class=" px-8 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(254,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,244,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out">
                                    Add Row</button>
                            </div>
                            <div>
                                <button type="submit"
                                    class=" px-8 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(158,255,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out">
                                    Update</button>
                            </div>
                        </div>
                    </div>

                    {{-- //* tablea area --}}
                    <div class="overflow-x-auto overflow-y-scroll h-[620px] scroll ">

                        <table class="w-full text-sm text-left scroll no-scrollbar">

                            {{-- //* table header --}}
                            <thead
                                class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                                <tr class=" text-nowrap">

                                    {{-- //* action --}}
                                    <th scope="col" class="px-4 py-3 text-center">Action</th>

                                    {{-- //* barcode --}}
                                    <th scope="col" class="px-4 py-3 text-left">Barcode</th>

                                    {{-- //* item name --}}
                                    <th scope="col" class="px-4 py-3 text-left">Item Name</th>

                                    {{-- //* stocks on hand --}}
                                    <th scope="col" class="px-4 py-3 text-center">Stocks-On-Hand</th>

                                    {{-- //* item reorder quantity --}}
                                    <th scope="col" class="px-4 py-3 text-center">Item Reorder Quantity</th>

                                    {{-- //* purchase quantity --}}
                                    <th scope="col" class="px-4 py-3 text-center text-nowrap">Purchase Quantity
                                    </th>
                                    </th>
                                </tr>
                            </thead>

                            {{-- //* table body --}}

                            <tbody>
                                @foreach ($reorder_lists as $index => $reorder_list)
                                    <tr
                                        class="border-b border-[rgb(207,207,207)] transition ease-in duration-75 index:bg-red-400">
                                        <th scope="row"
                                            class="px-2 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                            <div class="flex justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor"
                                                    x-on:click="$wire.removeRow({{ $index }})"
                                                    class="w-10 h-10 text-center text-red-300 transition-all duration-100 ease-linear rounded-full hover:bg-red-400 hover:text-red-600">
                                                    <path strokeLinecap="round" strokeLinejoin="round"
                                                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                            </div>
                                        <th scope="row"
                                            class="px-2 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                            {{ $reorder_list['barcode'] }}
                                        </th>
                                        <th scope="row"
                                            class="px-2 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                            {{ $reorder_list['item_name'] }}
                                        </th>
                                        <th scope="row"
                                            class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                            {{ $reorder_list['total_quantity'] }}
                                        </th>
                                        <th scope="row"
                                            class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                            {{ $reorder_list['reorder_point'] }}
                                        </th>
                                        <th scope="row"
                                            class="flex justify-center px-2 py-4 font-medium text-center text-gray-900 text-clip text-md whitespace-nowrap">
                                            <input type="number"
                                                wire:model="purchase_quantities.{{ $index }}" required
                                                class="bg-[rgb(249,249,249)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg text-center w-1/2 p-2.5">
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            {{-- Restock List Section --}}
            <div
                class="relative w-1/2 overflow-hidden border border-[rgb(30,24,9)] bg-[rgb(255,249,231)] sm:rounded-lg">


                <div class="flex justify-center px-2 py-10">
                    <div>
                        <h1 class="text-[1.8em] text-[rgb(65,47,20)] font-black">Reorder Lists</h1>
                    </div>

                </div>

                <div class="overflow-x-auto overflow-y-scroll h-[620px] scroll ">

                    <table class="w-full text-sm text-left scroll no-scrollbar">

                        {{-- //* table header --}}
                        <thead
                            class="text-xs text-[rgb(53,53,53)] uppercase cursor-default bg-[rgb(247,228,187)] sticky top-0   ">

                            <tr class=" text-nowrap">

                                {{-- //* action --}}
                                <th scope="col" class="px-4 py-3 text-center">Action</th>

                                {{-- //* barcode --}}
                                <th scope="col" class="px-4 py-3 text-left">Barcode</th>

                                {{-- //* item name --}}
                                <th scope="col" class="px-4 py-3 text-left">Item Name</th>

                                {{-- //* stocks on hand --}}
                                <th scope="col" class="px-4 py-3 text-center">Stocks-On-Hand</th>

                            </tr>
                        </thead>

                        {{-- //* table body --}}

                        <tbody>
                            @if (!empty($removed_items))
                                @foreach ($removed_items as $index => $removed_item)
                                    <tr
                                        class="border-b border-[rgb(53,53,53)] transition ease-in duration-75 index:bg-red-400">
                                        <th scope="row"
                                            class="px-4 py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                            <div class="flex justify-center"
                                                class="px-4 py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor"
                                                    class="w-10 h-10 text-center transition-all duration-100 ease-linear rounded-full text-[rgb(91,72,29)] hover:bg-[rgb(50,40,16)] hover:text-white"
                                                    x-on:click="$wire.restoreRow({{ $index }})">
                                                    <path strokeLinecap="round" strokeLinejoin="round"
                                                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                            </div>
                                        <th scope="row"
                                            class="px-4 py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                            {{ $reorder_list['barcode'] }}
                                        </th>
                                        <th scope="row"
                                            class="px-4 py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                            {{ $reorder_list['item_name'] }}
                                        </th>

                                        <th scope="row"
                                            class="px-4 py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                            {{ $reorder_list['total_quantity'] }}
                                        </th>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
