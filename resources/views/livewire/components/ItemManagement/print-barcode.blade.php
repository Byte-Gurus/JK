<div class="w-screen h-screen fixed inset-0 z-40 bg-white flex-wrap " x-show="isPrint">

    @if ($barcode)
        @for ($i = 0; $i < $barcode_quantity; $i++)
            <div class="m-5 ">

                <img id="barcode" wire:model="barcode">{!! DNS1D::getBarcodeSVG($barcode, 'C128', 1, 60) !!}</img>


                @error('barcode')
                    <span class="font-medium text-red-500 error">{{ $message }}</span>
                @enderror
            </div>
        @endfor

    @endif

</div>
