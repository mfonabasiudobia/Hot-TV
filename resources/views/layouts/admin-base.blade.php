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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('header')

    @livewireStyles
    {{-- @powerGridStyles --}}
    {{-- select2-3ug2-container --}}
    <style>
        .select2-selection {
            background-color: transparent !important;
            border: 1px solid #ccc !important;
            
        }
        
        .select2-search__field {
            /* font-size: 12px !important; */
            padding: 4px 0px !important;
            opacity: 0.7;
            height: 33px !important;
        }

        /* Increase the height of the Select2 container */
        .select2-container .select2-selection--single {
            background-color: #000 !important;
            background: #000 !important;
            color: #fff !important;
            height: 45px; /* Adjust the height as needed */
            padding: 7px 0; /* Adjust the padding and height as needed */
        }
        
        .select2-search__field, .tox-menubar, .tox-toolbar__primary {
            /* background-color: #000 !important; */
            /* background: #000 !important; */
            /* color: #fff !important; */
        }
        /* Increase the height of Select2 options */
        .select2-container .select2-results__option {
            background-color: #000 !important;
            background: #000 !important;
            color: #fff !important;
        }

        /* Custom CSS to change the background color of TinyMCE */
        /* .tox-tinymce {
            background-color: black !important;
        }


        .select2-search__field, .select2-selection, .select2-selection--single, .select2-container, .select2-container--default, .select2-container--focus, .select2-hidden-accessible {
            height: 40px !important;
            padding: 4px 0px !important;
            background: #000 !important;
        } */
        
        .select2-selection__choice {
            /* font-size: 12px !important; */
            background: #FF0207 !important;
            color: #fff !important;
            border: none !important;
        }
        
        .select2-selection__choice * {
            border: none !important;
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




    {{-- @powerGridScripts --}}
    @livewireScripts
    @toastScripts

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/srfq9lugj6h3um0oumk0latm9rs1cx0zyrcojwh2rc7van3r/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://unpkg.com/alpinejs@3.9.0/dist/cdn.min.js"></script>
    <script defer src="{{asset('js/js.js')}}?v={{uniqid()}}"></script>

    @stack("script")


</body>

</html>