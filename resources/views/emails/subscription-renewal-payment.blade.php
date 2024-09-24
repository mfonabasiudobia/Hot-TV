<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subscription</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200;0,6..12,300;0,6..12,400;0,6..12,500;0,6..12,600;0,6..12,700;0,6..12,800;1,6..12,200;1,6..12,300;1,6..12,400;1,6..12,500;1,6..12,600;1,6..12,700;1,6..12,800&display=swap"
        rel="stylesheet">

    <style type="text/css">
        body {
            background-color: #F3F3F3;
            width: 100%;
            min-height: 100vh;
            overflow-x: hidden;
            font-family: 'Nunito Sans', sans-serif;
            padding: 50px 0;
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

        .btn {
            color: #fff;
            border-radius: 7px;
            padding: 10px 15px;
            font-size: 14px;
            outline: none;
            border: none;
            display: inline-block;
        }

        .btn-danger {
            background-color: #FF0207;
        }

        .text-danger {
            color: #FF0207;
        }

        .mb-5 {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
<main class="container">
    <header style="text-align: center; padding: 20px;background-color: #000; color: #fff;">
        <img src="{{ asset('images/logo-white.png') }}" alt="" style="height: 50px; width: auto;" />
    </header>
    <section style="border-radius: 5px;background-color: #fff; padding: 20px; color: #5E5E5E; overflow: hidden;">
        <div class="mb-5">Hi {{ $user->username }}</div>

        <div class="mb-5">
            This is a confirmation that your subscription to the {{ $user->subscription->subscription->name }} plan has been successfully renewed.
        </div>

        <div class="mb-5">
            Here are the updated details:
            <ul>
                <li><bold>Plan:</bold> {{ $user->subscription->subscription->name }}</li>
                <li><bold>Renewal Date:</bold> {{ $user->subscription->created->format('m-d-Y') }}</li>
                <li><bold>Amount Charged:</bold> {{ $user->subscription->amount }} on {{ $user->subscription->subscription->plan->name }} basis</li>
{{--                <li><bold> Next Billing Date:</bold> {{ $user->subscription->created->format('m-d-Y') }}</li>--}}
            </ul>

        </div>

        <div>Thank you for your continued trust in {{ config('app.name') }}. We are happy to have you with us!</div>

        <div>
            <strong>{{ config('app.name') }} Team.</strong>
        </div>
    </section>
    <footer style="text-align: center; padding: 20px;background-color: #000; color: #fff;">
        <div>
            This email was sent to you because you subscribed to {{ config('app.name') }}. To stop getting emails, please contact our
            support
            team.
        </div>
        <br />
        <div class="text-center text-danger">
            <a href="{{ url('/') }}" style="color:#FF0207;">Visit Our Website</a> &nbsp;
            <a href="#" style="color:#FF0207;">Contact Support</a>
        </div>
    </footer>
</main>
</body>
</html>
