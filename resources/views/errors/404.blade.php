<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Page</title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" />
</head>
<body class="bg-black text-white">


    <section class="flex flex-col items-center justify-center space-y-5 h-screen w-screen text-center">
        @php
            $gs = (array) gs();
        @endphp
    <img src="{{ file_path($gs['theme-iori-404_page_image']) }}" class="h-[200px] w-auto" />

    <p>The page you requested could not be found</p>

    <a href="{{ route('home') }}" class="py-2 px-5 btn btn-danger rounded-full">Back To Home</a>
</section>


</body>
</html>