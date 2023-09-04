@php
    $supportedLocales = Language::getSupportedLocales();

    if (empty($options)) {
        $options = [
            'before' => '',
            'lang_flag' => true,
            'lang_name' => true,
            'class' => '',
            'after' => '',
        ];
    }
@endphp

@if ($supportedLocales && count($supportedLocales) > 1)
    @php
        $languageDisplay = setting('language_display', 'all');
        $showRelated = setting('language_show_default_item_if_current_version_not_existed', true);
    @endphp
    @if (setting('language_switcher_display', 'dropdown') == 'dropdown')
        <div class="box-dropdown-cart me-2">
            <span class="font-lg icon-list icon-account">
                @if (Arr::get($options, 'lang_flag', true) && ($languageDisplay == 'all' || $languageDisplay == 'flag'))
                    {!! language_flag(Language::getCurrentLocaleFlag()) !!}
                    <span class="color-grey-900 arrow-down ms-1">{{ Language::getCurrentLocaleName() }}</span>
                @endif
                @if (Arr::get($options, 'lang_name', true) && ($languageDisplay == 'name'))
                    &nbsp;<span class="color-grey-900 arrow-down">{{ Language::getCurrentLocaleName() }}</span>
                @endif
            </span>
            <div class="dropdown-account">
                <ul class="p-0">
                    @foreach ($supportedLocales as $localeCode => $properties)
                        @if ($localeCode != Language::getCurrentLocale())
                            <li>
                                <a class="font-md d-flex align-items-center" href="{{ $showRelated ? Language::getLocalizedURL($localeCode) : url($localeCode) }}">
                                    @if (Arr::get($options, 'lang_flag', true) && ($languageDisplay == 'all' || $languageDisplay == 'flag'))
                                        {!! language_flag($properties['lang_flag']) !!} <span>{{ $properties['lang_name'] }}</span>
                                    @endif
                                    @if (Arr::get($options, 'lang_name', true) &&  ($languageDisplay == 'name'))
                                        &nbsp;{{ $properties['lang_name'] }}
                                    @endif
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    @else
        <ul @class(['d-flex gap-3 box-dropdown-cart me-2', Arr::get($options, 'class')])>
            @foreach ($supportedLocales as $localeCode => $properties)
                @if ($localeCode !== Language::getCurrentLocale())
                    <li>
                        <a href="{{ Language::getSwitcherUrl($localeCode, $properties['lang_code']) }}">
                            @if (Arr::get($options, 'lang_flag', true) && ($languageDisplay == 'all' || $languageDisplay == 'flag'))
                                {!! language_flag($properties['lang_flag'], $properties['lang_name']) !!}
                            @endif
                            @if (Arr::get($options, 'lang_name', true) && ($languageDisplay == 'all' || $languageDisplay == 'name'))
                                &nbsp;<span>{{ $properties['lang_name'] }}</span>
                            @endif
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    @endif
@endif
