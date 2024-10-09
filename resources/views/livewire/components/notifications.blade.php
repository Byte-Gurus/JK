<div
    class=" flex flex-col gap-2 font-bold overflow-auto bg-[rgb(75,75,75)] h-screen max-h-[400px] rounded-md px-4 py-2">
    @foreach ($notifications as $notification)

    <div class=" h-fit bg-[rgb(36,36,36)] rounded-sm">


        <p @if ($notification->inventoryJoin)
            wire:click="goToOtherPage({{$notification->inventory_id}}, 'inventory')"
            @elseif ($notification->creditJoin)
            wire:click="goToOtherPage({{$notification->credit_id}}, 'credit')"
            @endif

            class="text-white bg-[rgb(122, 122, 122)] p-2 text-sm rounded-md ease-in-out duration-100 text-wrap
            transition-all cursor-pointer hover:bg-[rgb(233,72,84)]">
            {{ $notification->description }}</p>
    </div>
    @endforeach

</div>
