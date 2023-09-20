<div {!! $attributes->merge(['class' => "flex items-center justify-center relative w-full"]) !!}>
    <img src="{{ asset('images/loaders/loading-white.svg') }}" wire:loading wire:target="{{ $target }}" class="w-10 h-auto" alt='' />
</div>