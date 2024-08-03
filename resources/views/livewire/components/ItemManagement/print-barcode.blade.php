<div class="fixed inset-0 z-40 overflow-y-scroll bg-white no-scrollbar"
    x-show="isPrint">
    <div class="flex flex-row flex-wrap items-center justify-center m-4 ">
        @if ($barcode)
            @for ($i = 0; $i < $barcode_quantity; $i++)


                <div class="p-4 border border-black w-fit">
                    <img id="barcode" class="w-0 " wire:model="barcode">{!! DNS1D::getBarcodeSVG($barcode, 'EAN13', 1.5, 60) !!}</img>
                </div>
            @endfor
        @endif
    </div>
</div>
