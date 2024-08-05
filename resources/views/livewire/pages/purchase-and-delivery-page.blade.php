<div x-data="{ sidebar: @entangle('sidebarStatus'), showPurchaseOrder: @entangle('purchaseOrderOpen') }"
    @if (!$this->sidebarStatus) class=" ml-[220px] transition-all ease-in-out duration-75"
    @else
        class=" ml-[0px] transition-all ease-in-out duration-100" @endif>
    @livewire('components.navbar')
    <div class=" mx-[28px] mt-4 text-right">
        <button wire:click="togglePurchaseOrder()"
            @if ($purchaseOrderOpen) class="px-4 py-2 font-bold transition duration-75 ease-in-out bg-orange-200 rounded-md hover:bg-orange-300 text-md"
        @else
        class="px-4 py-2 font-bold transition duration-75 ease-in-out bg-blue-200 rounded-md hover:bg-blue-300 text-md" @endif>
            @if ($purchaseOrderOpen)
                <p>Delivery</p>
            @else
                <p>Purchase Order</p>
            @endif
        </button>
    </div>
    <div class=" m-[28px] duration-700 ease-linear transition-all">
        @if ($purchaseOrderOpen)
            @livewire('pages.purchase-pageff')
        @else
            @livewire('pages.delivery-page')
        @endif
    </div>
</div>
