<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('meta_data')

    {{-- <link rel="shortcut icon" href="{{ asset('storage/images/logo/logo.png') }}" type="image/x-icon"> --}}

    <title>{{ $seo_title ?? env('APP_NAME') }}</title>
    <meta name="description" content="{{ $seo_description ?? NULL }}">

    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/confetti.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />

    @if(env('APP_ENV') === 'development')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else 
        <link rel="preload" as="style" href="{{  asset('build/assets/app-41d701a9.css') }}" />
        <link rel="modulepreload" href="{{  asset('build/assets/app-56576e97.js') }}" />
        <link rel="stylesheet" href="{{  asset('build/assets/app-41d701a9.css') }}" />
        <script type="module" src="{{  asset('build/assets/app-56576e97.js') }}"></script>
    @endIf

    @stack('header')

    @livewireStyles

    <style>
        .ss-values, .ss-main, .ss-content {
            background-color: #000 !important;
        }

        .ss-main {
            width: 120px;
        }

        .ss-search {
            display: none !important;
        }

        .ss-option:hover, .ss-selected{
            background-color: red !important;
        }
    </style>

</head>

<body>
    <livewire:toasts />
    <section class="page-wrapper min-h-screen w-screen" x-data="{ toggleSidebar : true}">
        @livewire("partials.header")
        {{$slot}}
        @livewire("partials.footer")
    </section>


    @livewireScripts
    @livewireScriptConfig
    @toastScripts

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://unpkg.com/alpinejs@3.9.0/dist/cdn.min.js"></script>
    <script defer src="{{asset('js/js.js')}}?v={{uniqid()}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script src="https://kit.fontawesome.com/4286a4e89d.js"></script>

    @stack("script")


</body>

</html>