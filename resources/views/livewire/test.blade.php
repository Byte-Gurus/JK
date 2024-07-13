<div>
    @if ($photo)
        <img src="{{ $photo->temporaryUrl() }}">
    @endif

    <input type="file" wire:model="photo">

    @error('photo')
        <span class="error">{{ $message }}</span>
    @enderror
</div>
