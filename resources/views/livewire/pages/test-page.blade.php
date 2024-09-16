<div class="grid w-full h-full grid-flow-col grid-cols-3 gap-6">
    <div class="grid grid-flow-row col-span-2 gap-6 grid-row-4">
        <div
            class="flex-col row-span-1 hover:ml-2 h-full w-full hover:border-2 col-span-1 gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
            <div class="flex flex-row items-center w-full">
                <div class="w-full ">
                    <div class="border border-black "></div>
                </div>
                <div class="m-2 font-black text-[2em]">
                    <p>Sales</p>
                </div>
                <div class="w-full ">
                    <div class="border border-black "></div>
                </div>
            </div>
            <div class="flex flex-col ">
                <div x-on:click="$wire.displayDailySalesReport()"
                    class="px-4 py-2 font-bold hover:text-[1.4em] transition-all duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-2/3 text-nowrap">
                    <button>Daily Sales</button>
                </div>
                <div x-on:click="$wire.displayWeeklySalesReport()"
                    class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                    <button>Weekly Sales</button>
                </div>
                <div x-on:click="$wire.displayMonthlySalesReport()"
                    class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                    <button>Monthly Sales</button>
                </div>
                <div x-on:click="$wire.displayYearlySalesReport()"
                    class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                    <button>Yearly Sales</button>
                </div>
            </div>

        </div>
        <div
            class="flex-col hover:ml-2 w-full hover:border-2 col-span-1 gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
            <div class="flex flex-row items-center w-full">
                <div class="w-full ">
                    <div class="border border-black "></div>
                </div>
                <div class="m-2 font-black text-[2em]">
                    <p>Return</p>
                </div>
                <div class="w-full ">
                    <div class="border border-black "></div>
                </div>
            </div>
            <div class="flex flex-col gap-4 ">
                <div x-on:click="$wire.displaySalesReturnReport()"
                    class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                    <button>Sales Return List</button>
                </div>
            </div>
        </div>
        <div
            class="flex-col hover:ml-2 w-full hover:border-2 col-span-1 gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
            <div class="flex flex-row items-center w-full">
                <div class="w-full ">
                    <div class="border border-black "></div>
                </div>
                <div class="m-2 font-black text-[2em]">
                    <p>Tax</p>
                </div>
                <div class="w-full ">
                    <div class="border border-black "></div>
                </div>
            </div>
            <div class="flex flex-col gap-4 ">
                <div
                    class="px-4 py-2 transition-all font-bold hover:text-[1.2em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-2/3 text-nowrap">
                    <button>3% Percentage Tax Liability</button>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-flow-row col-span-1 grid-rows-2 gap-6">
        <div
            class="flex-col hover:mr-2 hover:border-2 w-full  gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
            <div class="flex flex-row items-center w-full">
                <div class="w-full ">
                    <div class="border border-black "></div>
                </div>
                <div class="m-2 font-black text-[2em]">
                    <p>Inventory</p>
                </div>
                <div class="w-full ">
                    <div class="border border-black "></div>
                </div>
            </div>
            <div class="flex flex-col">
                <div x-on:click="$wire.displayStockonhandReport()"
                    class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                    <button>Stock-on-hand</button>
                </div>
                <div x-on:click="$wire.displaySlowMovingItemsReport()"
                    class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                    <button>Slow-moving Items</button>
                </div>
                <div x-on:click="$wire.displayFastMovingItemsReport()" wire:click="calculateFastMoving"
                    class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                    <button>Fast-moving Items</button>
                </div>
                <div x-on:click="$wire.displayReorderListReport()"
                    class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                    <button>Reorder List</button>
                </div>
                <div x-on:click="$wire.displayBackorderedItemsReport()"
                    class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                    <button>Backordered Items</button>
                </div>
                <div x-on:click="$wire.displayExpiredItemsReport()"
                    class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                    <button>Expired Items List</button>
                </div>
            </div>
        </div>
        <div
            class="flex-col hover:mr-2 hover:border-2 w-full  gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
            <div class="flex flex-row items-center w-full">
                <div class="w-full ">
                    <div class="border border-black "></div>
                </div>
                <div class="m-2 font-black text-[2em]">
                    <p>Customer</p>
                </div>
                <div class="w-full ">
                    <div class="border border-black "></div>
                </div>
            </div>
            <div class="flex flex-col gap-4 ">
                <div
                    class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                    <button>Credit Customer List</button>
                </div>
            </div>
        </div>
    </div>
</div>
