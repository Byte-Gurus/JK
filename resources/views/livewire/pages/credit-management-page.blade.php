<div x-data="{ sidebar: @entangle('sidebarStatus') }"
    @if (!$this->sidebarStatus) class=" ml-[220px] transition-all ease-in-out duration-75"
    @else
        class=" ml-[0px] transition-all ease-in-out duration-100" @endif>
    @livewire('components.navbar')
    <div x-data="{ showModal: @entangle('showModal') }">
        <div class="m-[28px]">
            <div class="flex flex-col justify-between">
                <div class="flex flex-row items-center justify-between">
                    <div>
                        <h1 class="text-[2em] font-bold pointer-events-none">Manage Credit</h1>
                    </div>
                    @if ($showCreditTable)
                        <div class="flex flex-row gap-4">
                            <div>
                                <div class="flex flex-row gap-4 ">
                                    <button x-on:click="$wire.displayCreditHistory()"
                                        class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(180,255,248)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(128,255,247)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                strokeWidth={1.5} stroke="currentColor" class="size-5">
                                                <path strokeLinecap="round" strokeLinejoin="round"
                                                    d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                                            </svg>

                                        </div>
                                        <p>Credit History</p>
                                    </button>
                                </div>
                            </div>
                            <div class="flex flex-row gap-4 ">
                                <button
                                    class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(158,255,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out"
                                    x-on:click="showModal=true;$wire.formCreate()">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </div>
                                    <p>Add New Credit</p>
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-row gap-4">
                            <div>
                                <button x-on:click="$wire.returnToCreditTable()"
                                    class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out">Return</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div>
                @livewire('components.CreditManagement.credit-form')
            </div>
            <div class="my-[28px]" x-show="showCreditTable" x-data="{ showCreditTable: @entangle('showCreditTable') }">
                @livewire('components.CreditManagement.credit-table')
            </div>
            <div class="my-[28px]" x-show="showCreditHistory" x-data="{ showCreditHistory: @entangle('showCreditHistory') }">
                @livewire('components.CreditManagement.credit-history-table')
            </div>
            <div class="my-[28px]" x-show="showCreditPaymentForm" x-data="{ showCreditPaymentForm: @entangle('showCreditPaymentForm') }">
                @livewire('components.CreditManagement.credit-payment-form')
            </div>
        </div>
    </div>
</div>
