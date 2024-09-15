<div class="relative" x-cloak>
    <div class="fixed inset-0 z-40 bg-gray-900/50 dark:bg-gray-900/80"></div>
    <div x-cloak class="my-[28px]" x-show="showStockAdjustForm" x-data="{ showStockAdjustForm: @entangle('showStockAdjustForm') }">
        @livewire('components.InventoryManagement.stock-adjust-form')
    </div>
    <div x-cloak class="my-[28px]" x-show="adminLoginForm" x-data="{ adminLoginForm: @entangle('adminLoginForm') }">
        @livewire('components.admin-login-form')
    </div>
</div>
