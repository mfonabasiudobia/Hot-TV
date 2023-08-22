<section class="text-sm py-5 border-t border-b border-secondary">
    <div class="flex items-center container flex-wrap whitespace-nowrap">
        <span class="mr-2">
            Home 
        </span>

        @foreach ($routes as $key => $route)
            <span class="mr-2">/</span>

            @if(!is_null($route['route']))
                <a href="{{ $route['route'] }}" class="py-1 mr-2">{{ $route['title'] }}</a>
            @else
                <span class="{{ $key === count($routes) - 1 ? 'opacity-50' : null }} py-1 mr-2">
                    {{ $route['title'] }}
                </span>
            @endIf
        @endforeach
        
        
    </div>
</section>