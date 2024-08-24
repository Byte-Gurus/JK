<div>
    <div class="grid items-center grid-flow-col grid-cols-3 p-[28px]">
        <div class="flex flex-col col-span-2">
            <div class="flex flex-row items-center gap-4 p-[28px]">
                <div>
                    <input type="search"
                        class="px-4 py-2 border outline-none rounded-md border-[rgb(143,143,143)] w-full"
                        placeholder="Search by Barcode or Item Name">
                </div>
                <div>
                    <button class="px-4 py-2 bg-blue-100">Sales</button>
                </div>
                <div>
                    <button class="px-4 py-2 bg-green-100">New Sales</button>
                </div>
                <div>
                    <button class="px-4 py-2 bg-yellow-100">Transaction History</button>
                </div>
            </div>
            <div class="border border-black ">
                {{-- //* tablea area --}}
                <div class="overflow-x-auto overflow-y-scroll scroll h-[500px] ">

                    <table class="w-full h-10 text-sm text-left scroll no-scrollbar">

                        {{-- //* table header --}}
                        <thead class="text-xs text-white uppercase cursor-default bg-[rgb(53,53,53)] sticky top-0   ">

                            <tr class=" text-nowrap">

                                {{-- //* # count --}}
                                <th wire:click="sortByColumn('created_at')" scope="col"
                                    class=" text-nowrap gap-2 px-4 py-3 transition-all duration-100 ease-in-out cursor-pointer hover:bg-[#464646] hover:text-white">

                                    <div class="flex items-center">

                                        <p>#</p>

                                    </div>
                                </th>

                                {{-- //* item name --}}
                                <th scope="col" class="px-4 py-3 text-center">Item Name</th>

                                {{-- //* vat --}}
                                <th scope="col" class="px-4 py-3 text-center">VAT(₱)</th>

                                {{-- //* quantity --}}
                                <th scope="col" class="px-4 py-3 text-center">Quantity</th>

                                {{-- //* price --}}
                                <th scope="col" class="px-4 py-3 text-center">Price(₱)</th>

                                {{-- //* amount --}}
                                <th scope="col" class="px-4 py-3 text-center">Amount(₱)</th>

                            </tr>
                        </thead>

                        {{-- //* table body --}}
                        <tbody>
                        </tbody>

                    </table>

                </div>
            </div>
            <div class=" py-[28px]">
                <div class="grid grid-flow-col grid-cols-2">
                    <div class="flex flex-row col-span-1 gap-4">
                        <div class="flex flex-col col-span-1 gap-2">
                            <div class="flex flex-row gap-2">
                                <div class="text-center bg-slate-400 text-nowrap">
                                    <button class="px-4 py-2 ">
                                        Quantity
                                    </button>
                                </div>
                                <div class="text-center bg-blue-400 text-nowrap">
                                    <button class="px-4 py-2 ">
                                        Remove Item
                                    </button>
                                </div>
                            </div>
                            <div class="w-full text-center bg-orange-400 text-nowrap">
                                <button class="px-4 py-2 ">
                                    Cancel Transaction
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 ">
                            <div class="text-center bg-indigo-400 text-nowrap">
                                <button class="px-4 py-2 ">Wholesale</button>
                            </div>
                            <div class="text-center bg-violet-400 text-nowrap">
                                <button class="px-4 py-2 ">
                                    Discount
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 ">
                            <div class="flex flex-row gap-4">
                                <div class="text-center bg-pink-400 text-nowrap">
                                    <button class="px-4 py-2 ">Return</button>
                                </div>
                                <div class="text-center bg-yellow-400 text-nowrap">
                                    <button class="px-4 py-2 ">Pay</button>
                                </div>
                            </div>
                            <div class="text-center bg-sky-400 text-nowrap">
                                <button class="px-4 py-2 ">
                                    Void Transaction
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center font-black">
                        <div class="text-center bg-green-400 text-nowrap">
                            <button>
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-red-100 ">transaction detailsss</div>
    </div>
    <div>
        <label for="datepicker">Expiration Date</label>
        <input type="text" id="datepicker"  wire:change="hi(picker.toString('YYYY-MM-DD'))">
    </div>
</div>
<script src="pikaday.js"></script>
<script>
    var picker = new Pikaday({ field: document.getElementById('datepicker') });

</script>
