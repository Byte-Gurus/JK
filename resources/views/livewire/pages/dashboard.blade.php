@include('flatpickr::components.style')
<div x-data="{ sidebar: @entangle('sidebarStatus') }"
    @if (!$this->sidebarStatus) class=" ml-[220px] transition-all ease-in-out duration-75"
    @else
        class=" ml-[0px] transition-all ease-in-out duration-100" @endif>
    <div>
        @livewire('components.navbar')
    </div>
    <div class="m-[28px]">
        <div class="flex flex-row items-center w-1/2 gap-2">
            <div>
                Date
            </div>
            <div class="rounded-md ">
                <x-flatpickr id="laravel-flatpickr" class="rounded-sm" month />
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
