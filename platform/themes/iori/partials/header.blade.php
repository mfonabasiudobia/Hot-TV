<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {!! BaseHelper::googleFonts('https://fonts.googleapis.com/css2?family=' . urlencode(theme_option('primary_font', 'Manrope')) . ':wght@200;300;400;500;600;700;800&display=swap') !!}
        <style>
            :root {
                --primary-color: {{ theme_option('primary_color', '#006D77') }};
                --primary-hover-color: {{ theme_option('primary_hover_color', '#06d6a0') }};
                --secondary-color: {{ theme_option('secondary_color', '#8D99AE') }};
                --success-color: {{ theme_option('success_color', '#06D6A0') }};
                --danger-color: {{ theme_option('danger_color', '#EF476F') }};
                --warning-color: {{ theme_option('warning_color', '#FFD166') }};
                --primary-font: '{{ theme_option('primary_font', 'Manrope') }}', sans-serif;
            }
        </style>

        {!! Theme::header() !!}

        @if(theme_option('animation_enabled', 'yes') !== 'yes')
            <style>
                .img-reveal {
                    visibility: visible;
                }
            </style>
        @endif
    </head>
    <body @if (BaseHelper::siteLanguageDirection() == 'rtl') dir="rtl" @endif>
        {!! Theme::partial('dropdown-menu-mobile') !!}

        {!! Theme::partial('preloader') !!}

        {!! apply_filters(THEME_FRONT_BODY, null) !!}
        <header>
            {!! Theme::partial('top-navigation') !!}
        </header>
