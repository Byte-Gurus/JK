<div x-show="showRestockForms">
    <div class="relative w-full overflow-hidden border-[rgb(143,143,143)] border bg-white rounded-lg sm:rounded-lg">
        <div class="flex items-center justify-center py-2 border border-black">
            <p class="font-black ">Restock Form</p>
        </div>

        <form wire:submit.prevent="create">

            <div class="flex flex-row items-center justify-between gap-4 px-4 py-4 text-nowrap">
                <div class="flex flex-row gap-6">
                    <div>
                        <h1 class="text-[1.2em]">Purchase Order No</h1>
                        <h2 class="text-[2em] font-black text-center w-full">{{ $po_number }}</h2>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="supplier" class="text-[1.2em]">Supplier Name</label>
                        <label for="supplier" class="text-[1.2em] ">{{ $supplier }}</label>

                    </div>
                </div>
                <div class="flex flex-row items-center justify-center gap-4 flex-nowrap text-nowrap">

                    <div>
                        <button type="submit"
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out">
                            Restock</button>
                    </div>
                </div>
            </div>

            {{-- //* tablea area --}}
            <div class="h-[500px] pb-[136px] overflow-x-auto overflow-y-scroll  no-scrollbar scroll">

                <table class="w-full overflow-auto text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                        <tr class=" text-nowrap">

                            {{-- //* barcode --}}
                            <th scope="col" class="px-4 py-3 text-left">Barcode</th>

                            {{-- //* item name --}}
                            <th scope="col" class="py-3 text-left">Item Name</th>

                            {{-- //* stocks on hand --}}
                            <th scope="col" class="px-4 py-3 text-center ">Purchased Quantity</th>

                            {{-- //* purchase quantity --}}
                            <th scope="col" class="px-4 py-3 text-left text-nowrap">SKU</th>
                            </th>

                            {{-- //* restock quantity --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Restock Quantity</th>
                            </th>

                            {{-- //* cost --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Cost (₱)</th>
                            </th>

                            {{-- //* markup --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Markup (%)</th>
                            </th>

                            {{-- //* srp --}}
                            <th scope="col" class="py-3 text-center text-nowrap">SRP (₱)</th>
                            </th>

                            {{-- //* expiration date --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Expiration Date</th>
                            </th>

                            {{-- //* actions --}}
                            <th scope="col" class="px-4 py-3 text-center text-nowrap">Actions</th>
                            </th>
                        </tr>
                    </thead>

                    {{-- //* table body --}}

                    <tbody>
                        @foreach ($purchaseDetails as $index => $purchaseDetail)
                            <tr
                                class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition-all ease-in-out duration-1000">
                                <th scope="row"
                                    class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail['barcode'] }}
                                </th>
                                <th scope="row"
                                    class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                    {{ $purchaseDetail['item_name'] }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail['purchase_quantity'] }}
                                </th>


                                <th scope="row"
                                    class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail['sku_code'] }}
                                </th>
                                {{-- restock quantity --}}
                                <th scope="row"
                                    class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    <input type="number" wire:model="restock_quantity.{{ $index }}" required
                                        class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-center text-gray-900 text-sm rounded-md  block mx-auto w-2/3 p-2.5">


                                    @error("restock_quantity.$index")
                                        <span
                                            class="mt-2 font-medium text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                                    @enderror


                                    {{-- cost --}}
                                <th scope="row"
                                    class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    <input type="number" wire:model.live="cost.{{ $index }}" required
                                        class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-center text-gray-900 text-sm rounded-md  block w-full p-2.5">

                                    @error("cost.$index")
                                        <span
                                            class="mt-2 font-medium text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                                    @enderror



                                </th>

                                {{-- markup --}}
                                <th scope="row"
                                    class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                    <input type="number" wire:model.live="markup.{{ $index }}"required
                                        class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-center text-gray-900 text-sm rounded-md  block w-2/3 mx-auto p-2.5">

                                    @error("markup.$index")
                                        <span
                                            class="mt-2 font-medium text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                                    @enderror
                                </th>

                                {{-- srp --}}
                                <th scope="row"
                                    class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    <input type="number" wire:model.live="srp.{{ $index }}" required readonly
                                        class="  bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-center text-gray-900 text-sm rounded-md  block w-full p-2.5">


                                    @error("srp.$index")
                                        <span
                                            class="mt-2 font-medium text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                                    @enderror

                                </th>

                                {{-- exp date --}}
                                <th scope="row"
                                    class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    <input type="date" wire:model="expiration_date.{{ $index }}" required
                                        class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-center text-gray-900 text-sm rounded-md  block w-full p-2.5">

                                    @error("expiration_date.$index")
                                        <span
                                            class="mt-2 font-medium text-red-500 vsm:text-sm phone:text-sm tablet:text-sm laptop:text-md">{{ $message }}</span>
                                    @enderror
                                </th>

                                <th scope="row"
                                    class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    @if (isset($purchaseDetail['isDuplicate']) && $purchaseDetail['isDuplicate'])
                                        <button type="button" wire:click="removeItem({{ $index }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                strokeWidth={1.5} stroke="currentColor"
                                                class="transition-all duration-100 ease-in-out bg-red-100 rounded-full size-8 hover:bg-red-200">
                                                <path strokeLinecap="round" strokeLinejoin="round"
                                                    d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </button>
                                    @else
                                        <button type="button" wire:click="duplicateItem({{ $purchaseDetail['id'] }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                strokeWidth={1.5} stroke="currentColor"
                                                class="transition-all duration-100 ease-in-out bg-green-100 rounded-full size-8 hover:bg-green-200">
                                                <path strokeLinecap="round" strokeLinejoin="round"
                                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </button>
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
