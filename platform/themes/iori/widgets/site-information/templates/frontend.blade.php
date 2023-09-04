<div class="col-lg-3 width-20">
    @if ($logo = Arr::get($config, 'logo'))
        <a href="{{ Arr::get($config, 'url') }}">
            <div class="mb-10"><img src="{{ RvMedia::getImageUrl($logo) }}" alt="{{ theme_option('site_title') }}"></div>
        </a>
    @endif

    @if ($address = Arr::get($config, 'address'))
        <p class="font-md mb-20 color-grey-400">{{ $address }}</p>
    @endif

    @if ($config['working_hours_start'] && $config['working_hours_end'])
        <div class="font-md mb-20 color-grey-400"><strong class="font-md-bold d-inline-block me-1">{{ __('Hours') }}:</strong><span class="d-inline-block">{{ $config['working_hours_start'] }} - {{ $config['working_hours_end'] }}</span></div>
    @endif
    @if ($socialLinks = json_decode(theme_option('social_links')))
        <h6 class="color-brand-1">{{ __('Follow Us') }}</h6>
        <div class="mt-15">
            @foreach($socialLinks as $social)
                @php($social = collect($social)->pluck('value', 'key'))
                <a class="icon-socials" href="{{ $social->get('social-url') }}" title="{{ $social->get('social-name') }}">
                    @if ($socialIcon = $social->get('social-icon'))
                        <img src="{{ RvMedia::getImageUrl($socialIcon) }}" alt="{{ $social->get('social-name') }}" />
                    @else
                        {{ $social->get('social-name') }}
                    @endif
                </a>
            @endforeach
        </div>
    @endif
</div>
