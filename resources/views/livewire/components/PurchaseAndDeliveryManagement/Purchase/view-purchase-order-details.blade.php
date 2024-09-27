{{-- // --}}
<div class="relative my-[3vh] rounded-lg" x-cloak >
    <div class="flex flex-row h-[64vh] gap-4 ">
        <div class="relative w-full overflow-hidden border-[rgb(143,143,143)] border bg-white rounded-lg sm:rounded-lg">

            <div class="flex flex-row items-center justify-between gap-4 px-4 py-4 text-nowrap">
                <div class="flex flex-row gap-6">
                    <div>
                        <h1 class="text-[1.2em]">Purchase Order No</h1>
                        <h2 class="text-[2em] font-black text-center w-full">{{ $po_number }}</h2>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="supplier" class="text-[1.2em]">Supplier Name</label>
                        <p>{{ $supplier }}</p>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="supplier" class="text-[1.2em]">Date Created</label>
                        <p>{{ $dateCreated }}</p>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="supplier" class="text-[1.2em]"> Created by</label>
                        <p>{{ $createdBy }}</p>
                    </div>
                </div>
            </div>

            {{-- //* tablea area --}}
            <div class="h-[680px] pb-[136px] overflow-x-auto overflow-y-scroll  no-scrollbar scroll">

                <table class="w-full overflow-auto text-sm text-left scroll no-scrollbar">

                    {{-- //* table header --}}
                    <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                        <tr class=" text-nowrap">

                            {{-- //* barcode --}}
                            <th scope="col" class="px-4 py-3 text-left">Barcode</th>

                            {{-- //* item name --}}
                            <th scope="col" class="py-3 text-left">Item Name</th>

                            {{-- //* purchase quantity --}}
                            <th scope="col" class="py-3 text-center text-nowrap">Purchase Quantity</th>
                            </th>
                        </tr>
                    </thead>

                    {{-- //* table body --}}

                    <tbody>
                        @foreach ($purchaseDetails as $purchaseDetail)
                            <tr
                                class="border-b hover:bg-gray-100 border-[rgb(207,207,207)] transition ease-in duration-75 index:bg-red-400">
                                <th scope="row"
                                    class="px-4 py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                    <p>{{ $purchaseDetail->itemsJoin->barcode }}</p>
                                </th>
                                <th scope="row"
                                    class="py-4 font-medium text-left text-gray-900 text-md whitespace-nowrap">
                                    <p>{{ $purchaseDetail->itemsJoin->item_name }}</p>
                                </th>
                                <th scope="row"
                                    class="py-4 font-medium text-center text-gray-900 text-md whitespace-nowrap">
                                    <p>{{ $purchaseDetail->purchase_quantity }}</p>
                                </th>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
