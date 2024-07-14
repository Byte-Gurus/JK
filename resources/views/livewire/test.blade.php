<div>
    <form wire:submit.prevent="save" >

        <input type="file" accept="image/png, image/jpg" wire:model="image">

        @error('image')
            <span class="error">{{ $message }}</span>
        @enderror

        <button type="submit">Save photo</button>
    </form>
</div>
