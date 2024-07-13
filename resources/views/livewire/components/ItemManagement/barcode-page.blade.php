<div class="flex gap-3" x-data="{ barcode_quantity: @entangle('barcode_quantity')>
<h1>{{$barcode_quantity}}</h1>
    {{-- <img id="barcode" wire:model="barcode">{!! DNS1D::getBarcodeSVG($barcode, 'C128', 2, 60) !!}</img> --}}
</div>
