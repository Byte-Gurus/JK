<div x-cloak class="flex flex-col h-[90vh] p-[3vh]">
    <div class="flex flex-row justify-between mb-[3vh]">
        @if ($showVoidTransactionTable)
            <div>
                <p class="text-[2em] font-black ">Void Transaction</p>
            </div>
            <button x-on:click="$wire.returnToTransactionHistory()"
                    class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out">Back</button>
        @endif
        @if ($showVoidTransactionForm)
            <div>
                <p class="text-[2em] font-black ">Void Transaction Form</p>
            </div>
            <button x-on:click="$wire.returnToVoidTransactionPageFromVoidTransactionForm()"
                    class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out">Back</button>
        @endif
        @if ($showVoidTransactionDetails)
            <div>
                <p class="text-[2em] font-black ">View Void Transaction Details</p>
            </div>
            <button x-on:click="$wire.returnToVoidTransactionPageFromVoidTransactionDetails()"
                    class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(255,180,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(255,128,128)] transition-all duration-100 ease-in-out">Back</button>
        @endif
    </div>
    @if ($showVoidTransactionTable)
        <div class="flex flex-row items-center justify-end gap-4 mb-[3vh]">
            <div class="flex flex-row items-center gap-4 ">
                <button
                    class=" px-4 py-2 text-sm font-bold flex flex-row items-center gap-2 bg-[rgb(197,255,180)] text-[rgb(53,53,53)] border rounded-md hover:bg-[rgb(158,255,128)] hover:translate-y-[-2px] transition-all duration-100 ease-in-out"
                    x-on:click="$wire.displayVoidTransactionModal()">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <p>Add New Void Transaction</p>
                </button>
            </div>
        </div>
    @endif
    <div x-show="showVoidTransactionTable" x-data="{ showVoidTransactionTable: @entangle('showVoidTransactionTable') }">
        @livewire('components.Sales.void-transaction-table')
    </div>
    <div x-show="showVoidTransactionDetails" x-data="{ showVoidTransactionDetails: @entangle('showVoidTransactionDetails') }">
        @livewire('components.Sales.view-void-transaction-details')
    </div>
    <div x-show="showVoidTransactionModal" x-data="{ showVoidTransactionModal: @entangle('showVoidTransactionModal') }">
        @livewire('components.Sales.void-transaction-modal')
    </div>
    <div x-show="showVoidTransactionForm" x-data="{ showVoidTransactionForm: @entangle('showVoidTransactionForm') }">
        @livewire('components.Sales.void-transaction-form')
    </div>
</div>
