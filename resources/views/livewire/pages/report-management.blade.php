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
                    <div class="p-2 my-4 text-center font-black italic border border-[rgb(143,143,143)] bg-red-100">
                        <p>Select a Report To View or Print</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <div class="flex-col w-full gap-2 p-4 border border-black rounded-lg">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-4 text-[2em]">
                                <p>Sales</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 ">
                            <div>
                                <button>Daily Sales</button>
                            </div>
                            <div>
                                <button>Weekly Sales</button>
                            </div>
                            <div>
                                <button>Monthly Sales</button>
                            </div>
                            <div>
                                <button>Yearly Sales</button>
                            </div>
                        </div>
                    </div>
                    <div class="flex-col w-full gap-2 p-4 border border-black rounded-lg">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-4 text-[2em]">
                                <p>Return</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 ">
                            <div>
                                <button>Sales Return List</button>
                            </div>
                        </div>
                    </div>
                    <div class="flex-col w-full gap-2 p-4 border border-black rounded-lg">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-4 text-[2em]">
                                <p>Customer</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 ">
                            <div>
                                <button>Credit Customer List</button>
                            </div>
                        </div>
                    </div>
                    <div class="flex-col w-full gap-2 p-4 border border-black rounded-lg">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-4 text-[2em]">
                                <p>Tax</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 ">
                            <div>
                                <button>3% Percentage Tax Liability</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col w-full">
                    <div class="flex-col w-full gap-2 p-4 border border-black rounded-lg">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-4 text-[2em]">
                                <p>Sales</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 ">
                            <div>
                                <button>Stock-on-hand</button>
                            </div>
                            <div>
                                <button>Slow-moving Items</button>
                            </div>
                            <div>
                                <button>Fast-moving Items</button>
                            </div>
                            <div>
                                <button>Reorder List</button>
                            </div>
                            <div>
                                <button>Backorder Items</button>
                            </div>
                            <div>
                                <button>Expired Items List</button>
                            </div>
                        </div>
                    </div>
                    <div class="flex-col w-full gap-2 p-4 border border-black rounded-lg">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-4 text-[2em]">
                                <p>Transaction</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 ">
                            <div>
                                <button>Void Transaction List</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
