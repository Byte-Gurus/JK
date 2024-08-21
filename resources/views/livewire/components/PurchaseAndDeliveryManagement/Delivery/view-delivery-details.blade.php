<div x-show="viewDeliveryDetails">
    <div class="relative w-full overflow-hidden border-[rgb(143,143,143)] border bg-white rounded-lg sm:rounded-lg">
        <div class="flex items-center justify-center py-2 border border-black">
            <p class="font-black ">Restock Form</p>
        </div>

        <form wire:submit.prevent="create">

            <div class="flex flex-row items-center justify-between gap-4 px-4 py-4 text-nowrap">
                <div class="flex flex-row gap-6">
                    <div>
                        <h1 class="text-[1.2em]">Purchase Order No</h1>
                        <h2 class="text-[2em] font-black text-center w-full"> PO Number</h2>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="supplier" class="text-[1.2em]">Supplier Name</label>
                        <label for="supplier" class="text-[1.2em] ">Supplier name</label>

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
                        <tr
                            class="border-b border-[rgb(207,207,207)] hover:bg-[rgb(246,246,246)] transition-all ease-in-out duration-1000">
                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                            </th>
                            <th scope="row"
                                class="py-6 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                            </th>
                            <th scope="row"
                                class="px-4 py-6 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                            </th>


                            <th scope="row" class="px-4 py-6 font-medium text-gray-900 text-md whitespace-nowrap ">
                            </th>
                            {{-- restock quantity --}}
                            <th scope="row"
                                class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{-- wire:model="restock_quantity.{{ $index }}" required --}}
                                <input type="number"
                                    class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-center text-gray-900 text-sm rounded-md  block mx-auto w-2/3 p-2.5">




                                {{-- cost --}}
                            <th scope="row"
                                class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{-- wire:model.live="cost.{{ $index }}" required --}}
                                <input type="number"
                                    class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-center text-gray-900 text-sm rounded-md  block w-full p-2.5">



                            </th>

                            {{-- markup --}}
                            <th scope="row"
                            class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                            {{-- wire:model.live="markup.{{ $index }}"required --}}
                            <input type="number"
                                    class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-center text-gray-900 text-sm rounded-md  block w-2/3 mx-auto p-2.5">


                            </th>

                            {{-- srp --}}
                            <th scope="row"
                                class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                <input type="number"
                                {{--  wire:model.live="srp.{{ $index }}" required readonly --}}
                                    class="  bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-center text-gray-900 text-sm rounded-md  block w-full p-2.5">



                            </th>

                            {{-- exp date --}}
                            <th scope="row"
                                class="px-2 py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap ">
                                {{-- wire:model="expiration_date.{{ $index }}" required --}}
                                <input type="date"
                                    class=" bg-[rgb(245,245,245)] border border-[rgb(53,53,53)] text-center text-gray-900 text-sm rounded-md  block w-full p-2.5">
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
