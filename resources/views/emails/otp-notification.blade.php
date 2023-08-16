<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Verification</title>

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

        .btn {
            color: #fff;
            border-radius: 50px;
            padding: 7px 15px;
            font-size: 14px;
            outline: none;
            border: none;
            display: inline-block;
        }

        .activation-btn {
            padding: 15px 70px;
            background-color: #00347A;
            text-decoration: none;
        }

        .btn-code {
            padding: 7px 70px;
            background-color: transparent;
            font-size: 40px;
            color: #00347A;
            font-weight: bold;
            border: 2px dashed #00347A;
        }
    </style>
</head>

<body>
    <main class="container">
        <section class="text-center">
            {{-- <img src="{{ asset(cache('setting')->logo) }}" style="height: 50px; width: auto; " /> --}}

            <h1 class="title">Account Activation</h1>
        </section>

        <section style="border-radius: 5px;background-color: #fff; margin: 50px 0; color: #5E5E5E;"
            class="text-center">

            <img src="{{ asset('images/lock.png') }}" />

            <section style="padding: 30px 0;">
                

                <section>
                    {{-- Dear {{ $user->fullname }}, --}}
                    
                    <p>We are writing to inform you that we have received a request to verify your account. As part of our security
                        measures, we require a One-Time Password (OTP) to complete this process.</p>
                    
                    <p>
                        <button class="btn btn-code">{{ $otp }}</button>
                    </p>
                    
                    <p>
                        Please note that this OTP is only valid for a limited time, and it will expire soon. Therefore, we kindly request
                        that
                        you enter the OTP as soon as possible to verify your account.
                    </p>
                    
                    <p>
                        If you did not request this verification, please disregard this email and do not enter the OTP. Your account will
                        not be
                        affected.
                    </p>
                    
                    <p>
                        Thank you for choosing our service. If you have any questions or concerns, please feel free to contact us.
                    </p>
                    
                    <p>
                        Best regards,
                    </p>
                </section>
            </section>

        </section>




        <footer class="text-center">
            {{-- <ul style="list-style: none;">
                <li style="display: inline-block;">
                    <a href="#">
                        <img src="assets/images/fb.png" />
                    </a>
                </li>

                <li style="display: inline-block;">
                    <a href="#">
                        <img src="assets/images/tw.png" />
                    </a>
                </li>

                <li style="display: inline-block;">
                    <a href="#">
                        <img src="assets/images/in.png" />
                    </a>
                </li>

                <li style="display: inline-block;">
                    <a href="#">
                        <img src="assets/images/instagram.png?v=4" />
                    </a>
                </li>
            </ul> --}}
            <div style="font-size: 24px;">Copyright © {{ date('Y') }}</div>
            {{-- <div class="content-title">{{ cache('setting')->business_name }}</div> --}}
            {{-- <div>{{ cache('setting')->business_name }} tagline</div> --}}
        </footer>
    </main>
</body>

</html>