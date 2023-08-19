<section class="text-sm py-5">
    <div class="flex items-center space-x-2">
        <span>
            Home 
        </span>

        @foreach ($routes as $key => $route)
            <span>/</span>

            @if(!is_null($route['route']))
                <a href="{{ $route['route'] }}">{{ $route['title'] }}</a>
            @else
                <span class="{{ $key === count($routes) - 1 ? 'opacity-50' : null }}">
                    {{ $route['title'] }}
                </span>
            @endIf
        @endforeach
        
        
    </div>
</section>