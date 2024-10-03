<div x-data="{ sidebar: @entangle('sidebarStatus') }"
    @if (!$this->sidebarStatus) class=" ml-[220px] transition-all ease-in-out duration-75"
    @else
        class=" ml-[0px] transition-all ease-in-out duration-100" @endif>
    <div x-show="showNavbar" x-data="{ showNavbar: @entangle('showNavbar') }">
        @livewire('components.navbar')
    </div>
    @if (!$reportSelected)
        <div class="m-[28px]">
            <div class="flex flex-col justify-between">
                <div class="flex flex-row items-center justify-between">
                    <div>
                        <h1 class="text-[2em] font-bold pointer-events-none">Manage Report</h1>
                    </div>
                </div>
                <div>
                    <div
                        class="p-2 my-4 text-center font-black italic border-2 border-[rgb(20,20,20)] bg-[rgb(53,53,53)] text-white">
                        <p>Select a Report To View or Print</p>
                    </div>
                </div>
            </div>
            <div class="grid w-full grid-flow-col grid-cols-3 gap-6">
                <div class="grid h-full grid-flow-row col-span-2 gap-6 grid-row-4">
                    <div
                        class="flex-col row-span-1 hover:p-8 h-auto w-full hover:border-2 col-span-1 gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-2 font-bold text-[rgb(55,55,55)] italic text-[2em]">
                                <p>Sales</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col ">
                            <div x-on:click="$wire.displayDailySalesReportDatePickerModal()"
                                class="px-4 py-2 font-bold hover:text-[1.4em] transition-all duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md  text-nowrap">
                                <button>Daily Sales</button>
                            </div>
                            <div x-on:click="$wire.displayWeeklySalesReportDatePickerModal()"
                                class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md  text-nowrap">
                                <button>Weekly Sales</button>
                            </div>
                            <div x-on:click="$wire.displayMonthlySalesReportDatePickerModal()"
                                class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md text-nowrap">
                                <button>Monthly Sales</button>
                            </div>
                            <div x-on:click="$wire.displayYearlySalesReportDatePickerModal()"
                                class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md text-nowrap">
                                <button>Yearly Salesssssss</button>
                            </div>
                            <div x-on:click="$wire.displayVoidedTransactionsReportDatePickerModal()"
                                class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md text-nowrap">
                                <button>Voided Transactions</button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex-col hover:p-8 w-full hover:border-2  h-auto col-span-1 gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-2 font-bold text-[rgb(55,55,55)] italic text-[2em]">
                                <p>Return</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 ">
                            <div x-on:click="$wire.displaySalesReturnReportDatePickerModal()"
                                class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md text-nowrap">
                                <button>Sales Return List</button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex-col hover:p-8 w-full hover:border-2  h-auto col-span-1 gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-2 font-bold text-[rgb(55,55,55)] italic text-[2em]">
                                <p>Tax</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 ">
                            <div
                                class="px-4 py-2 transition-all font-bold hover:text-[1.2em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md text-nowrap">
                                <button>3% Percentage Tax Liability </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-flow-row col-span-1 grid-rows-3 gap-6">
                    <div
                        class="flex-col hover:p-8 hover:border-2 w-full row-span-2 gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-2 font-bold text-[rgb(55,55,55)] italic text-[2em]">
                                <p>Inventory</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col justify-evenly">
                            <div x-on:click="$wire.displayStockonhandReport()"
                                class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md text-nowrap">
                                <button>Stock-on-hand</button>
                            </div>
                            <div x-on:click="$wire.displaySlowMovingItemsReportDatePickerModal()"
                                class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md text-nowrap">
                                <button>Slow-moving Items</button>
                            </div>
                            <div x-on:click="$wire.displayFastMovingItemsReportDatePickerModal()"
                                wire:click="calculateFastMoving"
                                class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md text-nowrap">
                                <button>Fast-moving Items</button>
                            </div>
                            <div x-on:click="$wire.displayReorderListReport()"
                                class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md text-nowrap">
                                <button>Reorder List</button>
                            </div>
                            <div x-on:click="$wire.displayBackorderedItemsReport()"
                                class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md text-nowrap">
                                <button>Backordered Items</button>
                            </div>
                            <div x-on:click="$wire.displayExpiredItemsReportDatePickerModal()"
                                class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md text-nowrap">
                                <button>Expired Items List</button>
                            </div>
                            <div x-on:click="$wire.displayDamagedItemsReportDatePickerModal()"
                                class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md text-nowrap">
                                <button>Damaged Items List</button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex-col hover:p-8 hover:border-2 w-full row-span-1  gap-2 p-4 transition-all duration-300 ease-in-out border border-black rounded-lg hover:shadow-[rgb(250,216,114)] hover:bg-[rgb(255,227,142)] hover:shadow-2xl">
                        <div class="flex flex-row items-center w-full">
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                            <div class="m-2 font-bold text-[rgb(55,55,55)] italic text-[2em]">
                                <p>Customer</p>
                            </div>
                            <div class="w-full ">
                                <div class="border border-black "></div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 ">
                            <div x-on:click="$wire.displayCustomerCreditListReportDatePickerModal()"
                                class="px-4 py-2 transition-all font-bold hover:text-[1.4em] duration-100 ease-in-out hover:ml-4 hover:bg-[rgb(53,53,53)] hover:text-white rounded-md text-nowrap">
                                <button>Customer Credit List</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Daily Sales --}}

    <div x-show="showDailySalesReport" x-data="{ showDailySalesReport: @entangle('showDailySalesReport') }">
        @livewire('components.ReportManagement.daily-sales-report')
    </div>

    <div x-show="showDailySalesReportDatePickerModal" x-data="{ showDailySalesReportDatePickerModal: @entangle('showDailySalesReportDatePickerModal') }">
        @livewire('components.ReportManagement.daily-sales-report-date-picker-modal')
    </div>

    {{-- Weekly Sales --}}

    <div x-show="showWeeklySalesReport" x-data="{ showWeeklySalesReport: @entangle('showWeeklySalesReport') }">
        @livewire('components.ReportManagement.weekly-sales-report')
    </div>

    <div x-show="showWeeklySalesReportDatePickerModal" x-data="{ showWeeklySalesReportDatePickerModal: @entangle('showWeeklySalesReportDatePickerModal') }">
        @livewire('components.ReportManagement.weekly-sales-report-date-picker-modal')
    </div>

    {{-- Monthly Sales --}}

    <div x-show="showMonthlySalesReport" x-data="{ showMonthlySalesReport: @entangle('showMonthlySalesReport') }">
        @livewire('components.ReportManagement.monthly-sales-report')
    </div>

    <div x-show="showMonthlySalesReportDatePickerModal" x-data="{ showMonthlySalesReportDatePickerModal: @entangle('showMonthlySalesReportDatePickerModal') }">
        @livewire('components.ReportManagement.monthly-sales-report-date-picker-modal')
    </div>

    {{-- Yearly Sales --}}

    <div x-show="showYearlySalesReport" x-data="{ showYearlySalesReport: @entangle('showYearlySalesReport') }">
        @livewire('components.ReportManagement.yearly-sales-report')
    </div>

    <div x-show="showYearlySalesReportDatePickerModal" x-data="{ showYearlySalesReportDatePickerModal: @entangle('showYearlySalesReportDatePickerModal') }">
        @livewire('components.ReportManagement.yearly-sales-report-date-picker-modal')
    </div>

    {{-- Return --}}

    <div x-show="showSalesReturnReport" x-data="{ showSalesReturnReport: @entangle('showSalesReturnReport') }">
        @livewire('components.ReportManagement.sales-return-report')
    </div>

    <div x-show="showSalesReturnReportDatePickerModal" x-data="{ showSalesReturnReportDatePickerModal: @entangle('showSalesReturnReportDatePickerModal') }">
        @livewire('components.ReportManagement.sales-return-report-date-picker-modal')
    </div>

    {{-- Voided Transactions --}}

    <div x-show="showVoidedTransactionsReport" x-data="{ showVoidedTransactionsReport: @entangle('showVoidedTransactionsReport') }">
        @livewire('components.ReportManagement.voided-transaction-items-report')
    </div>

    <div x-show="showVoidedTransactionsReportDatePickerModal" x-data="{ showVoidedTransactionsReportDatePickerModal: @entangle('showVoidedTransactionsReportDatePickerModal') }">
        @livewire('components.ReportManagement.voided-transactions-report-date-picker-modal')
    </div>

    {{-- Customer Credit --}}

    <div x-show="showCustomerCreditListReport" x-data="{ showCustomerCreditListReport: @entangle('showCustomerCreditListReport') }">
        @livewire('components.ReportManagement.customer-credit-list-report')
    </div>

    <div x-show="showCustomerCreditListReportDatePickerModal" x-data="{ showCustomerCreditListReportDatePickerModal: @entangle('showCustomerCreditListReportDatePickerModal') }">
        @livewire('components.ReportManagement.customer-credit-list-report-date-picker-modal')
    </div>

    {{-- Inventory --}}

    {{-- Stock-on-hand report --}}

    <div x-show="showStockonhandReport" x-data="{ showStockonhandReport: @entangle('showStockonhandReport') }">
        @livewire('components.ReportManagement.stockonhand-report')
    </div>

    {{-- Slow Moving Items --}}

    <div x-show="showSlowMovingItemsReportDatePickerModal" x-data="{ showSlowMovingItemsReportDatePickerModal: @entangle('showSlowMovingItemsReportDatePickerModal') }">
        @livewire('components.ReportManagement.slow-moving-items-report-date-picker-modal')
    </div>

    <div x-show="showSlowMovingItemsReport" x-data="{ showSlowMovingItemsReport: @entangle('showSlowMovingItemsReport') }">
        @livewire('components.ReportManagement.slow-moving-items-report')
    </div>

    {{-- Fast Moving Items --}}

    <div x-show="showFastMovingItemsReport" x-data="{ showFastMovingItemsReport: @entangle('showFastMovingItemsReport') }">
        @livewire('components.ReportManagement.fast-moving-items-report')
    </div>

    <div x-show="showFastMovingItemsReportDatePickerModal" x-data="{ showFastMovingItemsReportDatePickerModal: @entangle('showFastMovingItemsReportDatePickerModal') }">
        @livewire('components.ReportManagement.fast-moving-items-report-date-picker-modal')
    </div>

    {{-- Reorder List Report --}}

    <div x-show="showReorderListReport" x-data="{ showReorderListReport: @entangle('showReorderListReport') }">
        @livewire('components.ReportManagement.reorder-list-report')
    </div>

    {{-- Backordered Items --}}

    <div x-show="showBackorderedItemsReport" x-data="{ showBackorderedItemsReport: @entangle('showBackorderedItemsReport') }">
        @livewire('components.ReportManagement.backordered-items-report')
    </div>

    {{-- Expired Items --}}

    <div x-show="showExpiredItemsReport" x-data="{ showExpiredItemsReport: @entangle('showExpiredItemsReport') }">
        @livewire('components.ReportManagement.expired-items-report')
    </div>

    <div x-show="showExpiredItemsReportDatePickerModal" x-data="{ showExpiredItemsReportDatePickerModal: @entangle('showExpiredItemsReportDatePickerModal') }">
        @livewire('components.ReportManagement.expired-items-report-date-picker-modal')
    </div>

    {{-- Damaged Item --}}

    <div x-show="showDamagedItemsReport" x-data="{ showDamagedItemsReport: @entangle('showDamagedItemsReport') }">
        @livewire('components.ReportManagement.damaged-items-report')
    </div>

    <div x-show="showDamagedItemsReportDatePickerModal" x-data="{ showDamagedItemsReportDatePickerModal: @entangle('showDamagedItemsReportDatePickerModal') }">
        @livewire('components.ReportManagement.damaged-items-report-date-picker-modal')
    </div>

</div>
