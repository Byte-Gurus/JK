<div>
    <div>
        @livewire('components.navbar-no-sidebar')
    </div>
    <div x-show="showSalesTransaction" x-data="{ showSalesTransaction: @entangle('showSalesTransaction') }">
        @livewire('components.Sales.sales-transaction')
    </div>
    <div x-show="showSalesTransactionHistory" x-data="{ showSalesTransactionHistory: @entangle('showSalesTransactionHistory') }">
        @livewire('components.Sales.sales-transaction-history')
    </div>
</div>

