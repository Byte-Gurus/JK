<div x-data="{ sidebar: @entangle('sidebarStatus'), showPurchaseOrder: @entangle('purchaseOrderOpen') }"
    @if (!$this->sidebarStatus) class=" ml-[220px] transition-all ease-in-out duration-75"
    @else
        class=" ml-[0px] transition-all ease-in-out duration-100" @endif>
    <div x-show="showNavbar" x-data="{ showNavbar: @entangle('showNavbar') }">
        @livewire('components.navbar')
    </div>
    <div class=" m-[3vh] duration-700 ease-linear transition-all">
        <div x-show="showPurchasePage" x-data="{ showPurchasePage: @entangle('showPurchasePage')}">
            @livewire('pages.purchase-page')
        </div>
        <div x-show="showDeliveryPage" x-data="{ showDeliveryPage: @entangle('showDeliveryPage')}">
            @livewire('pages.delivery-page')
        </div>
    </div>
</div>
