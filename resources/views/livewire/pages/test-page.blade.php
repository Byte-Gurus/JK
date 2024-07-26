<div>
    <form wire:submit="save" action="" enctype="multipart/form-data">
        @if ($photo)
            <img src="{{ $photo->temporaryUrl() }}">
        @endif

        <input type="file" wire:model="photo">

        @error('photo')
            <span class="error">{{ $message }}</span>
        @enderror

        <button type="submit">Save photo</button>
        sss
    </form>
</div>
