@include('flatpickr::components.style')
<div x-data="{ sidebar: @entangle('sidebarStatus') }"
    @if (!$this->sidebarStatus) class=" ml-[220px] transition-all ease-in-out duration-75"
    @else
        class=" ml-[0px] transition-all ease-in-out duration-100" @endif>
    <div>
        @livewire('components.navbar')
    </div>
    <div class="m-[28px]">
        <div class="flex flex-row gap-2">
            <div class="flex flex-row items-center gap-2">
                <div>
                    Date
                </div>
                <div class="rounded-md">
                    <x-flatpickr id="laravel-flatpickr" class="rounded-sm " onChange="dailyS" date-format="m/Y" />
                </div>
            </div>
            <div>
                <select id="transaction_type" wire:change='change()'

                    class=" bg-[rgb(255,206,121)] p-3 border border-[rgb(143,143,143)] text-gray-900 text-md font-black rounded-sm block w-full ">
                    <option value="1" >Daily Sales</option>
                    <option value="2">Weekly Sales</option>
                    <option value="3">Monthly Sales</option>
                    <option value="4">Yearly Sales</option>
                    <option value="4" selected>Overall Sales</option>
                </select>
            </div>
        </div>
        <div class=" w-content">
            @livewire('charts.user-chart')
        </div>
        <div class=" w-content">
            @livewire('charts.sale-chart')
        </div>
    </div>
</div>
@include('flatpickr::components.script')

{{-- <div>
    @livewire('test')
</div> --}}
