<div x-data="{ selected: @entangle('selected') }" class="w-screen h-screen transition-transform duration-1000 ease-in-out">
    <div class="grid grid-flow-row-dense grid-cols-3 gap-2 transition-transform duration-1000 ease-in-out">
        <div class="w-full transition-transform duration-1000 ease-in-out bg-red-100"
            :class="selected && 'col-span-3 h-[200px]'">
            gi
            <button x-on:click=" selected = !selected ">click me to expand</button>
        </div>
        <div class="w-full h-full transition duration-1000 ease-in-out bg-blue-100"
            :class="selected && 'col-span-3 h-[200px]'">
            fd
            <button x-on:click=" selected = !selected ">click me to expand</button>
        </div>
        <div class="w-full h-full transition duration-1000 ease-in-out bg-green-100">fd</div>
        <div class="w-full h-full transition duration-1000 ease-in-out bg-yellow-100">fd</div>
        <div class="w-full h-full transition duration-1000 ease-in-out bg-yellow-100">fd</div>
        <div class="w-full h-full transition duration-1000 ease-in-out bg-yellow-100">fd</div>
        <div class="w-full h-full transition duration-1000 ease-in-out bg-yellow-100">fd</div>
        <div class="w-full h-full transition duration-1000 ease-in-out bg-yellow-100">fd</div>
    </div>
</div>
