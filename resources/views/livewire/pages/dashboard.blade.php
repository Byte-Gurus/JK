<div x-data="{ sidebar: @entangle('sidebarStatus') }"
    @if (!$this->sidebarStatus) class=" ml-[220px] transition-all ease-in-out duration-75"
    @else
        class=" ml-[0px] transition-all ease-in-out duration-100" @endif>
    <div class="bg-white">
        @livewire('components.navbar')
    </div>
    <div class="m-[28px]">

        <div class=" translate-y-[-10px] contents before:bg-red-100 after:bg-blue-200">
            @livewire('dashboard-cards')
        </div>

        <div class="flex flex-row justify-end gap-2 mb-4">
            <div class="w-full">
                <select id="selectPicker" wire:model.live="selectPicker"
                    class="bg-orange-200 py-3 text-center w-full border border-[rgb(143,143,143)] text-orange-900 hover:bg-orange-300 active:bg-orange-500 duration-100 ease-in-out transition-all text-md font-black rounded-md block">
                    <option value="1">Daily Sales</option>
                    <option value="2">Weekly Sales</option>
                    <option value="3">Monthly Sales</option>
                    <option value="4">Yearly Sales</option>
                </select>
            </div>
        </div>

        <div class="grid grid-flow-col grid-cols-4 gap-4 ">
            <div class="col-span-3">
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
            <div
                class="w-full h-full col-span-1 p-4 bg-[rgb(53,53,53)] border shadow-md shadow-[rgb(0,0,0)] border-[rgb(0,0,0)] rounded-lg">
                <div class="text-center ">
                    <p class="text-lg text-[rgb(255,255,255)] italic font-black">Transaction History</p>
                </div>
            </div>
        </div>
        <div class="grid w-full grid-flow-col grid-cols-3 gap-4 my-4">
            <div class="w-full col-span-2">
                @livewire('charts.fast-slow-moving-chart')

            </div>
            <div class="w-full col-span-1">
                @livewire('charts.inventory-movement-chart')
            </div>
        </div>
    </div>
</div>
