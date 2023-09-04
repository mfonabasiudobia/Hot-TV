@php
    Arr::set($attributes, 'class', Arr::get($attributes, 'class') . ' icon-select');
    Arr::set($attributes, 'data-empty-value', __('Choose icon'));
@endphp

{!! Form::customSelect($name, [$value => $value], $value, $attributes) !!}

@once
    @if (request()->ajax())
        <link rel="stylesheet" href="{{ Theme::asset()->url('plugins/uicons-regular-rounded.css') }}">
        <script src="{{ Theme::asset()->url('js/icons-field.js') }}?v=1.0.0"></script>
    @else
        @push('header')
            <link rel="stylesheet" href="{{ Theme::asset()->url('plugins/uicons-regular-rounded.css') }}">
            <script src="{{ Theme::asset()->url('js/icons-field.js') }}?v=1.0.0"></script>
        @endpush
    @endif
@endonce
