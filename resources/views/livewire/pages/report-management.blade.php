<div x-data="{ sidebar: @entangle('sidebarStatus') }"
    @if (!$this->sidebarStatus) class=" ml-[220px] transition-all ease-in-out duration-75"
    @else
        class=" ml-[0px] transition-all ease-in-out duration-100" @endif>
    @livewire('components.navbar')
    <div>
        <div class="m-[28px]">
            <div class="flex flex-col justify-between">
                <div class="flex flex-row items-center justify-between">
                    <div>
                        <h1 class="text-[2em] font-bold pointer-events-none">Manage Report</h1>
                    </div>
                </div>
                <div>
                    <div class="p-2 my-4 text-center font-black italic border-2 border-[rgb(20,20,20)] bg-[rgb(53,53,53)] text-white">
                        <p>Select a Report To View or Print</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-full gap-4">
                <div class="grid flex-col w-full grid-flow-col grid-cols-3 gap-6">
                    <div
                        class="flex-col hover:m-2 w-full hover:border-2 col-span-1 gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-4 font-black text-[2em]">
                                <p>Sales</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col ">
                            <div
                                class="px-4 py-2 font-bold hover:text-[1.6em] transition-all duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-2/3 text-nowrap">
                                <button>Daily Sales</button>
                            </div>
                            <div
                                class="px-4 py-2 transition-all font-bold hover:text-[1.6em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                                <button>Weekly Sales</button>
                            </div>
                            <div
                                class="px-4 py-2 transition-all font-bold hover:text-[1.6em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                                <button>Monthly Sales</button>
                            </div>
                            <div
                                class="px-4 py-2 transition-all font-bold hover:text-[1.6em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                                <button>Yearly Sales</button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex-col hover:m-2 w-full hover:border-2 col-span-1 gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-4 font-black text-[2em]">
                                <p>Return</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 ">
                            <div
                                class="px-4 py-2 transition-all font-bold hover:text-[1.6em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                                <button>Sales Return List</button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex-col hover:m-2 w-full hover:border-2 col-span-1 gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-4 font-black text-[2em]">
                                <p>Customer</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 ">
                            <div
                                class="px-4 py-2 transition-all font-bold hover:text-[1.6em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                                <button>Credit Customer List</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="grid flex-col w-full grid-flow-col grid-cols-3 gap-6">
                    <div
                        class="flex-col hover:m-2 hover:border-2 w-full col-span-1 gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-4 font-black text-[2em]">
                                <p>Inventory</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div
                                class="px-4 py-2 transition-all font-bold hover:text-[1.2em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-2/3 text-nowrap">

                                <button>Stock-on-hand</button>
                            </div>
                            <div
                                class="px-4 py-2 transition-all font-bold hover:text-[1.6em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                                <button>Slow-moving Items</button>
                            </div>
                            <div
                                class="px-4 py-2 transition-all font-bold hover:text-[1.6em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                                <button>Fast-moving Items</button>
                            </div>
                            <div
                                class="px-4 py-2 transition-all font-bold hover:text-[1.6em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                                <button>Reorder List</button>
                            </div>
                            <div
                                class="px-4 py-2 transition-all font-bold hover:text-[1.6em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                                <button>Backordered Items</button>
                            </div>
                            <div
                                class="px-4 py-2 transition-all font-bold hover:text-[1.6em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                                <button>Expired Items List</button>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex-col hover:m-2  hover:border-2 w-full col-span-1 gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-4 font-black text-[2em]">
                                <p>Transaction</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 ">
                            <div
                                class="px-4 py-2 transition-all font-bold hover:text-[1.6em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md w-3/4 text-nowrap">
                                <button>Void Transaction List</button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex-col hover:border-2 hover:m-2 w-full col-span-1 gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-4 font-black text-[2em]">
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
            </div>
        </div>
    </div>
</div>
