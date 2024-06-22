<div x-data="{ sidebar: @entangle('sidebarStatus') }"
    @if (!$this->sidebarStatus) class=" ml-[220px] transition-all ease-in-out duration-75"
    @else
        class=" ml-[0px] transition-all ease-in-out duration-100" @endif>
    @livewire('components.navbar')
    <div class=" m-[28px] w-content">
        @livewire('charts.user-chart')
    </div>
</div>
