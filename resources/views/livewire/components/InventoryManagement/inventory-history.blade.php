{{-- // --}}
<div class="relative my-[3vh] rounded-lg" wire:poll.visible="500ms">

    <div class="relative overflow-hidden bg-white border border-[rgb(143,143,143)] sm:rounded-lg">

        {{-- //* filters --}}
        <div class="flex flex-row items-center justify-between px-4 py-4 ">

            {{-- //* search filter --}}
            <div class="relative w-1/2 pr-4 mt-1">

                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black " fill="none" viewBox="0 0 24 24"
                        strokeWidth={1.5} stroke="currentColor" className="size-6">
                        <path strokeLinecap="round" strokeLinejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>

                <input type="text" wire:model.live.debounce.100ms="search"
                    class="w-full p-4 pl-10 hover:bg-[rgb(230,230,230)] transition duration-100 ease-in-out border border-[rgb(53,53,53)] placeholder-black text-[rgb(53,53,53)] rounded-sm cursor-pointer text-sm bg-[rgb(242,242,242)] focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Search by Item Name or Barcode" required="" />
            </div>


            <div class="flex flex-row items-center justify-center gap-2">

                <div class="flex flex-col">
                    <div class="flex flex-row ">
                        <div class="flex flex-col gap-1">
                            <label class="text-sm font-medium text-gray-900 text-nowrap">Start Date:</label>
                            <input type="date" wire:model.live="startDate"
                                class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-l-md block p-2.5" />
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-sm font-medium text-gray-900 text-nowrap">End Date:</label>
                            <input type="date" wire:model.live="endDate"
                                class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-r-md block p-2.5" />
                        </div>
                    </div>
                    <p class="text-[12px] font-light text-center text-gray-600 ">Date Range</p>
                </div>

                <div class="flex flex-row gap-4 mb-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-gray-900 text-nowrap">Status:</label>
                        <select wire:model.live="statusFilter"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-lg  block p-3">
                            <option value="0">All</option>
                            <option value="Available">Available</option>
                            <option value="Not available">Not available</option>
                            <option value="Expired">Expired</option>
                            <option value="New Item">New Item</option>

                        </select>
                    </div>

                    <div class="flex flex-col gap-1">

                        <label class="text-sm font-medium text-left text-gray-900 text-nowrap">Unit:</label>

                        <select wire:model.live="unitFilter"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md  block p-3 ">
                            <option value="0">All</option>
                            <option value="Kilo">Kilo</option>
                            <option value="Pack">Pack</option>
                            <option value="Piece">Piece</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">

                        <label class="text-sm font-medium text-left text-gray-900 text-nowrap">Category:</label>

                        <select wire:model.live="categoryFilter"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md  block p-3 ">
                            <option value="0">All</option>
                            <option value="Frozen">Frozen Supply</option>
                            <option value="Consumer">Consumer Supply</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-gray-900 text-nowrap">Supplier:</label>
                        <select wire:model.live="supplierFilter"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] text-ellipsis w-[180px] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-md block p-3">
                            <option value="0">All</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-gray-900 text-nowrap">Movement :</label>

                        <select wire:model.live="movementFilter"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-lg  block p-3">
                            <option value="0">All</option>
                            <option value="Inventory">Inventory</option>
                            <option value="Adjustment">Adjustment</option>
                            <option value="Sales">Sales</option>

                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-gray-900 text-nowrap">Operation :</label>

                        <select wire:model.live="operationFilter"
                            class="bg-gray-50 border border-[rgb(53,53,53)] hover:bg-[rgb(225,225,225)] transition duration-100 ease-in-out text-[rgb(53,53,53)] text-sm rounded-lg  block p-3">
                            <option value="0">All</option>
                            <option value="Stock In">Stock In</option>
                            <option value="Stock out">Stock Out</option>
                            <option value="Add">Add</option>
                            <option value="Deduct">Deduct</option>
                            <option value="Void">Void</option>

                        </select>
                    </div>
                </div>
            </div>
        </div>


        {{-- //* tablea area --}}
        <div class="overflow-x-auto overflow-y-scroll h-[45vh]">
            <table class="w-full text-sm text-left">
                {{-- //* table header --}}
                <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0">
                    <tr class=" text-nowrap">

                        {{-- //* date --}}
                        <th wire:click="sortByColumn('created_at')" scope="col"
                            class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                            <div class="flex items-center">

                                <p>Date & Time</p>

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </span>
                            </div>
                        </th>

                        {{-- //* item name --}}
                        <th scope="col" class="px-4 py-3">Movement</th>

                        <th scope="col" class="px-4 py-3">Status</th>

                        <th scope="col" class="px-4 py-3">SKU</th>

                        <th scope="col" class="px-4 py-3">Barcode</th>

                        <th scope="col" class="px-4 py-3">Item Name</th>

                        <th scope="col" class="px-4 py-3">Description</th>

                        <th scope="col" class="px-4 py-3">Unit</th>

                        <th scope="col" class="px-4 py-3">Category</th>

                        <th scope="col" class="px-4 py-3">Operation</th>

                        <th scope="col" class="px-4 py-3">Reason</th>

                        <th scope="col" class="px-4 py-3">Quantity</th>

                        <th scope="col" class="px-4 py-3">Supplier</th>
                    </tr>
                </thead>

                {{-- //* table body --}}
                <tbody>

                    @foreach ($InventoryHistories as $InventoryHistory)
                        <tr
                            class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition ease-in duration-75">

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $InventoryHistory->created_at->format(' M d Y h:i A') }}
                            </th>

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $InventoryHistory->movement_type }}
                            </th>

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                @if ($InventoryHistory->movement_type === 'Inventory')
                                    {{ $InventoryHistory->inventoryJoin->status ?? 'N/A' }}
                                @elseif ($InventoryHistory->movement_type === 'Adjustment')
                                    {{ $InventoryHistory->adjustmentJoin->inventoryJoin->status ?? 'N/A' }}
                                @elseif ($InventoryHistory->movement_type === 'Sales')
                                    {{ $InventoryHistory->transactionDetailsJoin->inventoryJoin->status ??
                                        $InventoryHistory->voidTransactionDetailsJoin->transactionDetailsJoin->inventoryJoin->status }}
                                @endif
                            </th>

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                @if ($InventoryHistory->movement_type === 'Inventory')
                                    {{ $InventoryHistory->inventoryJoin->sku_code ?? 'N/A' }}
                                @elseif ($InventoryHistory->movement_type === 'Adjustment')
                                    {{ $InventoryHistory->adjustmentJoin->inventoryJoin->sku_code }}
                                @elseif ($InventoryHistory->movement_type === 'Sales')
                                    {{ $InventoryHistory->transactionDetailsJoin->inventoryJoin->sku_code ??
                                        $InventoryHistory->voidTransactionDetailsJoin->transactionDetailsJoin->inventoryJoin->sku_code }}
                                @endif

                            </th>

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                @if ($InventoryHistory->movement_type === 'Inventory')
                                    {{ $InventoryHistory->inventoryJoin->itemJoin->barcode }}
                                @elseif ($InventoryHistory->movement_type === 'Adjustment')
                                    {{ $InventoryHistory->adjustmentJoin->inventoryJoin->itemJoin->barcode }}
                                @elseif ($InventoryHistory->movement_type === 'Sales')
                                    {{ $InventoryHistory->transactionDetailsJoin->inventoryJoin->itemJoin->barcode ??
                                        $InventoryHistory->voidTransactionDetailsJoin->transactionDetailsJoin->inventoryJoin->itemJoin->barcode }}
                                @endif
                            </th>

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                @if ($InventoryHistory->movement_type === 'Inventory')
                                    {{ $InventoryHistory->inventoryJoin->itemJoin->item_name }}
                                @elseif ($InventoryHistory->movement_type === 'Adjustment')
                                    {{ $InventoryHistory->adjustmentJoin->inventoryJoin->itemJoin->item_name }}
                                @elseif ($InventoryHistory->movement_type === 'Sales')
                                    {{ $InventoryHistory->transactionDetailsJoin->inventoryJoin->itemJoin->item_name ??
                                        $InventoryHistory->voidTransactionDetailsJoin->transactionDetailsJoin->inventoryJoin->itemJoin->item_name }}
                                @endif
                            </th>

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                @if ($InventoryHistory->movement_type === 'Inventory')
                                    {{ $InventoryHistory->inventoryJoin->itemJoin->item_description }}
                                @elseif ($InventoryHistory->movement_type === 'Adjustment')
                                    {{ $InventoryHistory->adjustmentJoin->inventoryJoin->itemJoin->item_description }}
                                @elseif ($InventoryHistory->movement_type === 'Sales')
                                    {{ $InventoryHistory->transactionDetailsJoin->inventoryJoin->itemJoin->item_description ??
                                        $InventoryHistory->voidTransactionDetailsJoin->transactionDetailsJoin->inventoryJoin->itemJoin->item_description }}
                                @endif
                            </th>

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                @if ($InventoryHistory->movement_type === 'Inventory')
                                    {{ $InventoryHistory->inventoryJoin->itemJoin->item_unit }}
                                @elseif ($InventoryHistory->movement_type === 'Adjustment')
                                    {{ $InventoryHistory->adjustmentJoin->inventoryJoin->itemJoin->item_unit }}
                                @elseif ($InventoryHistory->movement_type === 'Sales')
                                    {{ $InventoryHistory->transactionDetailsJoin->inventoryJoin->itemJoin->item_unit ??
                                        $InventoryHistory->voidTransactionDetailsJoin->transactionDetailsJoin->inventoryJoin->itemJoin->item_unit }}
                                @endif
                            </th>

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                @if ($InventoryHistory->movement_type === 'Inventory')
                                    {{ $InventoryHistory->inventoryJoin->itemJoin->item_category }}
                                @elseif ($InventoryHistory->movement_type === 'Adjustment')
                                    {{ $InventoryHistory->adjustmentJoin->inventoryJoin->itemJoin->item_category }}
                                @elseif ($InventoryHistory->movement_type === 'Sales')
                                    {{ $InventoryHistory->transactionDetailsJoin->inventoryJoin->itemJoin->item_category ??
                                        $InventoryHistory->voidTransactionDetailsJoin->transactionDetailsJoin->inventoryJoin->itemJoin->item_category }}
                                @endif
                            </th>


                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ $InventoryHistory->operation }}
                            </th>

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                {{ \Illuminate\Support\Str::limit(
                                    $InventoryHistory->adjustmentJoin->reason ?? ($InventoryHistory->voidTransactionDetailsJoin->reason ?? 'N/A'),
                                    24,
                                    '...',
                                ) }}

                            </th>

                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                @if ($InventoryHistory->operation === 'Stock In')
                                    {{ $InventoryHistory->inventoryJoin->stock_in_quantity }}
                                @elseif($InventoryHistory->operation === 'Stock out')
                                    {{ $InventoryHistory->transactionDetailsJoin->item_quantity }}
                                @elseif ($InventoryHistory->operation === 'Add' || $InventoryHistory->operation === 'Deduct')
                                    {{ $InventoryHistory->adjustmentJoin->adjusted_quantity }}
                                @elseif ($InventoryHistory->operation === 'Void')
                                    {{ $InventoryHistory->voidTransactionDetailsJoin->void_quantity }}
                                @endif
                            </th>
                            <th scope="row" class="px-4 py-4 font-medium text-gray-900 text-md whitespace-nowrap ">
                                @if ($InventoryHistory->movement_type === 'Inventory')
                                    {{ \Illuminate\Support\Str::limit(
                                        $InventoryHistory->adjustmentJoin->reason ??
                                            ($InventoryHistory->inventoryJoin->deliveryJoin->purchaseJoin->supplierJoin->company_name ?? 'N/A'),
                                        24,
                                        '...',
                                    ) }}
                                @elseif ($InventoryHistory->movement_type === 'Adjustment')
                                    {{ \Illuminate\Support\Str::limit(
                                        $InventoryHistory->adjustmentJoin->reason ??
                                            $InventoryHistory->adjustmentJoin->inventoryJoin->deliveryJoin->purchaseJoin->supplierJoin->company_name,
                                        24,
                                        '...',
                                    ) }}
                                @elseif ($InventoryHistory->movement_type === 'Sales')
                                    {{ \Illuminate\Support\Str::limit(
                                        $InventoryHistory->transactionDetailsJoin->inventoryJoin->deliveryJoin->purchaseJoin->supplierJoin->company_name ??
                                            $InventoryHistory->voidTransactionDetailsJoin->transactionDetailsJoin->inventoryJoin->deliveryJoin->purchaseJoin->supplierJoin->company_name,
                                        24,
                                        '...',
                                    ) }}
                                @endif
                            </th>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

        {{-- //* table footer --}}
        <div class="border-t border-black ">

            {{-- //*pagination --}}
            <div class="mx-4 my-2 text-nowrap">

                {{ $InventoryHistories->links() }}

            </div>

            {{-- //* per page --}}
            <div class="flex items-center px-4 py-2 mb-3">

                <label class="text-sm font-medium text-gray-900 w-15">Per Page</label>

                <select wire:model.live="perPage"
                    class="bg-[rgb(243,243,243)] border border-[rgb(53,53,53)] text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2.5 ml-4">
                    <option value="10">10</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
    </div>
</div>
