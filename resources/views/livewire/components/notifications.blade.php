<div class=" flex flex-col gap-2 font-black bg-[rgb(75,75,75)] h-screen max-h-[400px] rounded-md px-4 py-2">
    @foreach ($notifications as $notification)
    <div class=" h-fit">
        <p class="text-white p-2 rounded-md ease-in-out duration-100 transition-all cursor-pointer hover:bg-[rgb(233,72,84)]">{{ $notification->description }}</p>
    </div>
    @endforeach
</div>
