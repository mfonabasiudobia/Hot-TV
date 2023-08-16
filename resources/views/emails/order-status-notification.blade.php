<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome Message</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Michroma:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">

    <style type="text/css">
        body {
            background-color: #EAF0F3;
            width: 100%;
            min-height: 100vh;
            overflow-x: hidden;
            font-family: 'Lato';
            padding: 50px 0;
        }

        .title {
            font-family: 'Michroma';
            font-size: 28px;
        }

        .content-title {
            font-family: 'Michroma';
            font-size: 20px;
        }

        .subtitle {
            font-size: 18px;
            color: #5E5E5E;
            line-height: 0;
        }

        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        @media (min-width: 768px) {
            .container {
                width: 750px;
            }
        }

        @media (min-width: 992px) {
            .container {
                width: 970px;
            }
        }

        @media (min-width: 1200px) {
            .container {
                width: 1170px;
            }
        }

        .text-black {
            color: #000;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <main class="container">
        <section class="text-center">
            <img src="{{ asset(cache('setting')->logo) }}" style="height: 50px; width: auto; " />

            <h1 class="title">Hi, {{ $order->user->fullname }}</h1>
            
        </section>

        <section style="border-radius: 5px;background-color: #fff; margin: 50px 0; color: #5E5E5E; padding: 10px">
            <p>Your order, which is associated with tracking ID #{{ $order->id }}, has been updated to
               {{ str()->replace('_', ' ', $order->order_status) }}. If you encounter any problems or have any concerns, please don't hesitate to reach out
                to us via phone {{ cache('setting')->phone_number }} or email us at {{ cache('setting')->email }}.</p>
        </section>

        <footer class="text-center">
            <div style="font-size: 24px;">Copyright © {{ date('Y') }}</div>
            <div class="content-title">{{ cache('setting')->business_name }}</div>
        </footer>
    </main>
</body>

</html>