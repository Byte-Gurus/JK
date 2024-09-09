<div class="text-center">
    @foreach ($notifications as $notification)
        <p>{{ $notification->description }}</p>
    @endforeach
</div>
