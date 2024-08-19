<div>
    <div class="flex flex-col justify-between">
        <div class="flex flex-row items-center justify-between mb-4">
            <div>
                <h1 class="text-[2em] font-bold pointer-events-none">Delivery</h1>
            </div>
        </div>
    </div>
    <div>
        {{-- @livewire('components.PurchaseAndDeliveryManagement.purchase-form') --}}
    </div>
    @if (!$showRestockForm)
        <div class="">
            @livewire('components.PurchaseAndDeliveryManagement.Delivery.delivery-table')
        </div>
    @else
        <div>
            @livewire('components.PurchaseAndDeliveryManagement.Delivery.restock-form')
        </div>
    @endif

    <div>
        @livewire('components.PurchaseAndDeliveryManagement.Delivery.restock-form')
    </div>
</div>
