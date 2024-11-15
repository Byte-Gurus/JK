<div class="flex flex-col">

    <div class="flex flex-row items-center justify-between">
        <div class="flex flex-col items-start">
            <div class="flex flex-col gap-1">
                {{-- <p class=" font-black text-[1.2em]">{{ $creditor_name }}</p> --}}
                jade
                {{-- <p class=" font-thin text-[0.6em] italic">{{ $credit_no }}</p> --}}123
            </div>
        </div>
    </div>
    {{-- @if ($imageUrl) --}}
        <div class="flex flex-col mb-4">
            <p class="mb-1 font-black text-gray-900 text-md">Customer Profile</p>
            {{-- <img src="{{ $imageUrl }}" alt="Customer ID Picture"
                class="w-1/3 h-1/2"> --}}
        </div>
    {{-- @endif --}}
    <div class="flex flex-col items-start">
        <div class="flex flex-col">
            <p class="font-black text-md">Credit Limit</p>
            <p>10000</p>
            {{-- <p class=" font-black text-[1.2em]">{{ $credit_limit }}</p> --}}
        </div>
    </div>
</div>
