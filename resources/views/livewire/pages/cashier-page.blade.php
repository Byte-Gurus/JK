<div>
    <div x-show="showNavbarNoSidebar" x-data="{ showNavbarNoSidebar: @entangle('showNavbarNoSidebar') }">
        @livewire('components.navbar-no-sidebar')
    </div>
    <div x-show="showSalesTransaction" x-data="{ showSalesTransaction: @entangle('showSalesTransaction') }">
        @livewire('components.Sales.sales-transaction')
    </div>
    <div x-show="showSalesTransactionHistory" x-data="{ showSalesTransactionHistory: @entangle('showSalesTransactionHistory') }">
        @livewire('components.Sales.sales-transaction-history')
    </div>
    <div x-show="showSalesReturn" x-data="{ showSalesReturn: @entangle('showSalesReturn') }">
        @livewire('components.Sales.sales-return')
    </div>
    <div x-show="showSalesReceipt" x-data="{ showSalesReceipt: @entangle('showSalesReceipt') }">
        @livewire('components.Sales.sales-receipt')
    </div>
    <div x-show="showSalesReturnSlip" x-data="{ showSalesReturnSlip: @entangle('showSalesReturnSlip') }">
        @livewire('components.Sales.sales-return-slip')
    </div>
</div>
