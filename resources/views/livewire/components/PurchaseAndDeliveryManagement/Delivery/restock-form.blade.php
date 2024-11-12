<div x-cloak x-show="showRestockForm">
    <div class="relative w-full overflow-hidden border-[rgb(143,143,143)] border bg-white rounded-lg sm:rounded-lg">
        <form wire:submit.prevent="create">

            <div class="flex flex-row items-center justify-between gap-4 py-4 pr-4 my-2 text-nowrap">
                <div
                    class="flex flex-row items-center gap-6 w-fit p-2 pr-4 bg-[rgb(40,23,83)] shadow-md shadow-[rgb(206,187,255)] text-white rounded-r-full">
                    <div>
                        <p class="text-[1em] font-thin text-center w-full">Purchase Order No</p>
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
                        <p class="text-[1.2em] font-black text-wrap">{{ $supplier }}</p>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center gap-4 flex-nowrap text-nowrap">

                    <div>
                        <button type="submit"
                            class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(180,255,199)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(128,255,153)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out">
                            Restock</button>
                    </div>
                </div>
            </div>

            {{-- //* tablea area --}}
            <div class="h-[62vh] overflow-x-auto overflow-y-scroll">

                <table class="w-full text-sm text-left">
                    {{-- //* table header --}}
                    <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                        <tr class=" text-nowrap">

                            {{-- //* barcode --}}
                            <th scope="col" class="px-4 py-3 text-left">Barcode</th>

                            {{-- //* item name --}}
                            <th scope="col" class="px-4 py-3 text-left">Item Name</th>

                            {{-- //* item name --}}
                            <th scope="col" class="py-3 text-left">Item Description</th>

                            {{-- //* item name --}}
                            <th scope="col" class="py-3 text-left"> Unit</th>

                            {{-- //* item name --}}
                            <th scope="col" class="py-3 text-left">Category</th>

                            {{-- //* stocks on hand --}}
                            <th scope="col" class="px-4 py-3 text-center ">Purchased Quantity</th>

                            {{-- //* purchase quantity --}}
                            <th scope="col" class="px-4 py-3 text-left">SKU</th>
                            </th>

                            {{-- //* restock quantity --}}
                            <th scope="col" class="py-3 text-center ">Restock Quantity</th>
                            </th>

                            {{-- //* cost --}}
                            <th scope="col" class="py-3 text-center ">Cost (₱)</th>
                            </th>

                            {{-- //* markup --}}
                            <th scope="col" class="py-3 text-center">Markup (%)</th>
                            </th>

                            {{-- //* srp --}}
                            <th scope="col" class="py-3 text-center">SRP (₱)</th>
                            </th>

                            {{-- //* expiration date --}}
                            <th scope="col" class="py-3 text-center ">Expiration Date</th>
                            </th>

                            {{-- //* actions --}}
                            <th scope="col" class="px-4 py-3 text-center">Actions</th>
                            </th>
                        </tr>
                    </thead>

                    {{-- //* table body --}}

                    <tbody>
                        @foreach ($purchaseDetails as $index => $purchaseDetail)
                            <tr
                                class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition-all ease-in-out duration-1000">
                                <th scope="row"
                                    class="px-4 py-10 font-medium text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail['barcode'] }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-10 font-medium text-left text-gray-900 break-all text-md text-wrap whitespace-nowrap ">
                                    {{ $purchaseDetail['item_name'] }}
                                </th>

                                <th scope="row"
                                    class="py-10 font-medium text-left text-gray-900 break-all text-md text-wrap whitespace-nowrap">
                                    {{ $purchaseDetail['item_description'] }}
                                </th>

                                <th scope="row"
                                    class="py-10 font-medium text-left text-gray-900 break-all text-md text-wrap whitespace-nowrap">
                                    {{ $purchaseDetail['item_unit'] }}
                                </th>

                                <th scope="row"
                                    class="py-10 font-medium text-left text-gray-900 break-all text-md text-wrap whitespace-nowrap">
                                    {{ $purchaseDetail['item_category'] }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-10 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail['purchase_quantity'] }}
                                </th>

                                <th scope="row"
                                    class="px-4 py-10 font-medium text-gray-900 text-md whitespace-nowrap ">
                                    {{ $purchaseDetail['sku_code'] }}
                                </th>
                                {{-- restock quantity --}}
                                <th scope="row"
                                    class="px-2 py-10 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                    <input type="number" wire:model="restock_quantity.{{ $index }}" required
                                        oninput="validateInput(this)"
                                        class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none text-center text-gray-900 text-sm rounded-md  block mx-auto w-2/3 p-2.5">


                                </th>

                                {{-- cost --}}
                                <th scope="row"
                                    class="px-2 py-10 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                    <input type="number" wire:model.live.debounce.500ms="cost.{{ $index }}"
                                        step=".01" oninput="validateInput(this)" required
                                        class=" bg-[rgb(245,245,245)] [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none border border-[rgb(53,53,53)] text-center text-gray-900 text-sm rounded-md  block w-full p-2.5">
                                </th>

                                {{-- markup --}}
                                <th scope="row"
                                    class="px-2 py-10 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                    <input type="number" step="0.01"
                                        wire:model.live.debounce.500ms="markup.{{ $index }}" required
                                        step=".01" oninput="validateInput(this)"
                                        class=" bg-[rgb(245,245,245)] [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none border border-[rgb(53,53,53)] text-center text-gray-900 text-sm rounded-md  block w-2/3 mx-auto p-2.5">
                                </th>

                                {{-- srp --}}
                                <th scope="row"
                                    class="px-2 py-10 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    <input type="number" wire:model.live.debounce.500ms="srp.{{ $index }}"
                                        required readonly
                                        class="  bg-[rgb(245,245,245)] [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none border border-[rgb(53,53,53)] text-center text-gray-900 text-sm rounded-md  block w-full p-2.5">
                                </th>

                                {{-- exp date --}}
                                <th scope="row"
                                    class="px-2 py-10 font-medium text-center text-gray-900 text-md whitespace-nowrap ">

                                    @if ($purchaseDetail['shelf_life_type'] === 'Perishable')
                                        <input type="date" wire:model="expiration_date.{{ $index }}" required
                                            class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-center text-gray-900 text-sm rounded-md  block w-full p-2.5">
                                    @elseif($purchaseDetail['shelf_life_type'] === 'Non Perishable')
                                        N/A
                                    @endif
                                </th>


                                <th scope="row"
                                    class="px-2 py-10 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                    @if (isset($purchaseDetail['isDuplicate']) && $purchaseDetail['isDuplicate'])
                                        <button type="button" wire:click="removeItem({{ $index }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                strokeWidth={1.5} stroke="currentColor"
                                                class="transition-all duration-100 ease-in-out bg-red-100 rounded-full size-8 hover:bg-red-100">
                                                <path strokeLinecap="round" strokeLinejoin="round"
                                                    d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </button>
                                    @else
                                        <button type="button"
                                            wire:click="duplicateItem({{ $purchaseDetail['id'] }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor"
                                                class="transition-all duration-100 ease-in-out bg-green-100 rounded-full size-8 hover:bg-green-200">
                                                <path strokeLinecap="round" strokeLinejoin="round"
                                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </button>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td colspan="2" class="mb-2 text-center">

                                    @error("restock_quantity.$index")
                                        <div class="bg-red-100 ">
                                            <span
                                                class="col-span-1 text-[0.8em] font-medium text-center text-red-500 error text-wrap">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </td>

                                <td colspan="1"></td>

                                <td colspan="1" class="mb-2 text-center ">
                                    @error("cost.$index")
                                        <div class="bg-red-100 ">
                                            <span
                                                class="col-span-1 text-[0.8em] font-medium text-center text-red-500 error text-wrap">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </td>

                                <td colspan="1"></td>

                                <td colspan="1" class="mb-2 text-center ">
                                    @error("markup.$index")
                                        <div class="bg-red-100">
                                            <span
                                                class="col-span-1 text-[0.8em] font-medium text-center text-red-500 error text-wrap">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </td>

                                <td colspan="1"></td>


                                <td colspan="1" class="mb-2 text-center ">
                                    @error("srp.$index")
                                        <div class="bg-red-100">
                                            <span
                                                class="col-span-1 text-[0.8em] font-medium text-center text-red-500 error text-wrap">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </td>

                                <td colspan="1"></td>


                                <td colspan="2" class="mb-2 text-center ">
                                    @error("expiration_date.$index")
                                        <div class="bg-red-100">
                                            <span
                                                class="col-span-1 text-[0.8em] font-medium text-center text-red-500 error text-wrap">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
@script
    <script>
        function validateInput(input) {
            // Allow only digits and a single decimal point
            let value = input.value;
            const parts = value.split('.');

            // Remove any characters that are not digits or a decimal point
            value = value.replace(/[^0-9.]/g, '');

            // Allow only one decimal point
            if (parts.length > 2) {
                value = parts[0] + '.' + parts.slice(1).join('');
            }

            // Update the input value
            input.value = value;
        }
    </script>
@endscript
