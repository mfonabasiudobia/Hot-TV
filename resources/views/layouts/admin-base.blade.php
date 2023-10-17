<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="robots" content="noindex" />
    @stack('meta_data')

    <link rel="shortcut icon" href="{{ asset('storage/images/logo/logo.png') }}" type="image/x-icon">

    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.17.9/tagify.css" />

    {{-- @if(env('APP_ENV') === 'development') --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @else
        <link rel="preload" as="style" href="{{  asset('build/assets/app-41d701a9.css') }}" />
        <link rel="modulepreload" href="{{  asset('build/assets/app-56576e97.js') }}" />
        <link rel="stylesheet" href="{{  asset('build/assets/app-41d701a9.css') }}" />
        <script type="module" src="{{  asset('build/assets/app-56576e97.js') }}"></script>
    @endIf --}}
    @stack('header')

    @livewireStyles
    <style>
        .ss-values,
        .ss-main,
        .ss-content {
            background-color: #000 !important;
        }
    
        .ss-option:hover,
        .ss-selected, .ss-value-text, .ss-value-delete, .ss-value {
            background-color: #FFFFFF !important;
            color: #000 !important;
        }
    </style>

</head>

<body>
    <livewire:toasts />
    <section class="page-wrapper bg-dark text-white h-screen overflow-y-auto"
        x-data="{ toggleSidebar : true}">
        <section class="flex">
            @livewire("admin.partials.sidebar")
            <div class="overflow-y-auto w-full min-h-screen">
                @livewire("admin.partials.header")
                <div class="p-3 md:p-5">
                    {{$slot}}
                </div>
            </div>
        </section>
    </section>



    @livewireScripts
    {{-- @toastScripts --}}
    <script src="{{ asset('js/tall-toasts.js') }}" data-turbo-eval="false" data-turbolinks-eval="false"></script>
    <script data-turbo-eval="false" data-turbolinks-eval="false">
        document.addEventListener('alpine:init', () => {
                window.Alpine.directive('ToastComponent', window.ToastComponent);
            });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.17.9/tagify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/srfq9lugj6h3um0oumk0latm9rs1cx0zyrcojwh2rc7van3r/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://unpkg.com/alpinejs@3.9.0/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.min.js"></script>
    <script defer src="{{asset('js/js.js')}}?v={{uniqid()}}"></script>
    <script src="https://kit.fontawesome.com/4286a4e89d.js"></script>

    @stack("script")


</body>

</html>