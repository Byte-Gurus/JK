<div
    class=" flex flex-col gap-2 font-bold overflow-auto bg-[rgb(75,75,75)] backdrop-blur-xl h-screen max-h-[400px] rounded-md rounded-tr-none px-4 py-2">
    @foreach ($notifications as $notification)
        <div class="bg-[rgb(56,56,56)]  rounded-lg h-fit backdrop-blur-xl">

            <div @if ($notification->inventoryJoin) wire:click="goToOtherPage({{ $notification->inventory_id }}, 'inventory')"
            @elseif ($notification->creditJoin)
            wire:click="goToOtherPage({{ $notification->credit_id }}, 'credit')" @endif
                class=" grid grid-flow-col grid-cols-12 text-white bg-[rgb(122, 122, 122)] p-2 text-sm rounded-md ease-in-out duration-100 text-wrap
            transition-all cursor-pointer hover:bg-[rgb(233,72,84)]">
                <p class="col-span-10 ">
                    {{ $notification->description }}
                </p>

                <div class="flex items-center justify-center col-span-2 text-[rgb(255,187,187)] rounded-full hover:bg-red-900">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8.689c0-.864.933-1.406 1.683-.977l7.108 4.061a1.125 1.125 0 0 1 0 1.954l-7.108 4.061A1.125 1.125 0 0 1 3 16.811V8.69ZM12.75 8.689c0-.864.933-1.406 1.683-.977l7.108 4.061a1.125 1.125 0 0 1 0 1.954l-7.108 4.061a1.125 1.125 0 0 1-1.683-.977V8.69Z" />
                    </svg>
                </div>
            </div>
        </div>
    @endforeach
</div>
