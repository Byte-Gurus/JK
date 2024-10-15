<div
    class=" flex flex-col gap-2 font-bold overflow-auto bg-[rgba(53,53,53,0.7)] backdrop-blur-md h-screen max-h-[400px] rounded-md rounded-tr-none px-4 py-2">
    @foreach ($notifications as $notification)
        <div class="bg-[rgba(99,99,99,0.24)] rounded-lg h-fit backdrop-blur-xl">
            <div @if ($notification->inventoryJoin) wire:click="goToOtherPage({{ $notification->inventory_id }},
            'inventory')"
            href="{{ route('inventorymanagement.index') }}" wire:navigate
            @elseif ($notification->creditJoin)
            wire:click="goToOtherPage({{ $notification->credit_id }}, 'credit')"
            href="{{ route('creditmanagement.index') }}" wire:navigate @endif
                class=" grid grid-flow-row text-white gap-2 bg-[rgb(122, 122, 122)] p-2 text-sm rounded-md
            ease-in-out duration-100 text-wrap
            transition-all cursor-pointer hover:bg-[rgb(233,72,84)]">
                <p class="text-xs italic font-thin text-right text-white hover:text-black">
                    {{ $notification->created_at->format('M d Y h:i A') }}
                </p>
                <div class="grid items-center grid-flow-col">
                    <p class="col-span-10 text-md">
                        {{ $notification->description }}
                    </p>
                    <div
                        class="flex items-center justify-center p-2 col-span-2 text-[rgb(255,187,187)] rounded-full hover:bg-red-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                            stroke="currentColor" class="size-6">
                            <path strokeLinecap="round" strokeLinejoin="round"
                                d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
