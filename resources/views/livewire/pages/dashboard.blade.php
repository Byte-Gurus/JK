<div x-data="{ sidebar: @entangle('sidebarStatus') }"
    @if (!$this->sidebarStatus) class=" ml-[220px] transition-all ease-in-out duration-75"
    @else
        class=" ml-[0px] transition-all ease-in-out duration-100" @endif>
    <div>
        @livewire('components.navbar')
    </div>
    <div class="m-[28px]">

        <div>
            <div class="flex flex-row gap-2">

                <div>
                    <select id="selectPicker" wire:model.live="selectPicker"
                        class="bg-[rgb(255,206,121)] p-3 border border-[rgb(143,143,143)] text-gray-900 text-md font-black rounded-sm block w-full">k
                        <option value="1">Daily Sales</option>
                        <option value="2">Weekly Sales</option>
                        <option value="3">Monthly Sales</option>
                        <option value="4">Yearly Sales</option>
                    </select>
                </div>
            </div>
            @if ($selectPicker == 1)
                @livewire('charts.daily-sales-chart')
            @elseif ($selectPicker == 2)
                @livewire('charts.weekly-sales-chart')
            @elseif ($selectPicker == 3)
                @livewire('charts.monthly-sales-chart')
            @elseif ($selectPicker == 4)
                @livewire('charts.yearly-sales-chart')
            @endif
        </div>
        @livewire('charts.inventory-movement-chart')

    </div>
</div>
