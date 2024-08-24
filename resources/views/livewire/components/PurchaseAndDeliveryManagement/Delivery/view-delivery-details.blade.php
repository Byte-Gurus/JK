<div x-show="openDeliveryDetails">
    <div class="relative w-full overflow-hidden border-[rgb(143,143,143)] border bg-white rounded-lg sm:rounded-lg">
        <form wire:submit.prevent="create">

            <div class="flex flex-row items-center justify-between gap-4 px-4 py-4 text-nowrap">
                <div class="flex flex-row gap-6">
                    <div class="flex flex-row gap-2">
                        <h1 class="text-[1.2em] font-black">P0#</h1>
                    </div>
                    <div class="flex flex-row gap-2">
                        <label for="supplier" class="text-[1.2em] ">BINI</label>

                    </div>
                </div>
            </div>

            {{-- //* tablea area --}}
            <div class="h-[580px] pb-[136px] overflow-x-auto overflow-y-scroll  no-scrollbar scroll">

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

                        </tr>
                    </thead>

                    {{-- //* table body --}}

                    <tbody>
                        <tr
                            class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition-all ease-in-out duration-1000">

                            {{-- barcode --}}
                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                <p></p>
                            </th>

                            {{-- item name --}}
                            <th scope="row"
                                class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                <p></p>
                            </th>

                            {{-- purchase quantity --}}
                            <th scope="row"
                                class="px-4 py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                <p></p>
                            </th>

                            {{-- sku --}}
                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                                <p></p>
                            </th>

                            {{-- restock quantity --}}
                            <th scope="row"
                                class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{-- wire:model="restock_quantity.{{ $index }}" required --}}
                                <p></p>
                            </th>

                            {{-- cost --}}
                            <th scope="row"
                                class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{-- wire:model.live="cost.{{ $index }}" required --}}
                                <p></p>
                            </th>

                            {{-- markup --}}
                            <th scope="row"
                                class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                {{-- wire:model.live="markup.{{ $index }}"required --}}
                                <p></p>

                            </th>

                            {{-- srp --}}
                            <th scope="row"
                                class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                <p></p>
                            </th>

                            {{-- exp date --}}
                            <th scope="row"
                                class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{-- wire:model="expiration_date.{{ $index }}" required --}}
                                <p></p>
                            </th>


                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
