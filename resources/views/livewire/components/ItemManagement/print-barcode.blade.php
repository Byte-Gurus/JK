<div class="fixed inset-0 z-40 overflow-y-scroll bg-white no-scrollbar" x-show="isPrint">
    <div class="flex flex-row flex-wrap items-center justify-center m-4 ">

        @if ($barcode)
        @php
        if (strlen($barcode) == 13) {
        $barcodeNum = substr($barcode, 0, -1);
        dump($barcode);
        }
        @endphp
        @for ($i = 0; $i < $barcode_quantity; $i++) <div class="p-4 border border-black w-fit">
            <img id="barcode" class="w-0 " wire:model="barcode">{!! DNS1D::getBarcodeSVG($barcodeNum, 'EAN13', 2, 80)
            !!}</img>
    </div>
    @endfor
    @endif
</div>
</div>
