<div x-data="{ show: @entangle('show') }">
    <button x-on:click="show = !show">haplas</button>
    <div>
        @if ($this->show)
            <p>hi</p>
        @else
            <p>hello</p>
        @endif
    </div>
</div>
