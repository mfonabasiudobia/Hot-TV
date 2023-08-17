<button {!! $attributes->merge(['class' => "$class flex items-center justify-center relative"]) !!}
    wire:loading.class="opacity-70 cursor-not-allowed" wire:loading.attr="disabled" wire:target="{{ $target }}">
    <span>{{$text}}</span>
    <img src="{{ asset('images/loaders/loading-white.svg') }}" wire:loading wire:target="{{ $target }}"
        class="w-5 h-auto" alt='' />
</button>