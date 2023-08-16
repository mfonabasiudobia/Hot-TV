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
           {{-- <img src="{{ asset(cache('setting')->logo) }}" style="height: 50px; width: auto; " /> --}}

            {{-- <h1 class="title">Hi {{ $user->fullname }}, <br /> Welcome to {{ cache('setting')->business_name }}!</h1> --}}
        </section>

        <section style="border-radius: 5px;background-color: #fff; margin: 50px 0; color: #5E5E5E;">

            <section style="padding: 30px 0;">
               {{-- <p>We are thrilled to welcome you to {{ cache('setting')->business_name }}, your one-stop-shop for all your dry cleaning --}}
            needs. Thank you for signing up with us!</p>
            
            {{-- <p>At {{ cache('setting')->business_name }}, we pride ourselves on providing high-quality and reliable dry cleaning --}}
            services to our
            customers. Our platform is designed to make your life easier by offering a seamless and hassle-free experience.</p>
            
            <p>With our easy-to-use platform, you can schedule pickups and deliveries, track your order status, and manage your account
            with just a few clicks. We also offer a wide range of services, including dry cleaning, laundry, and alterations, so you
            can trust us to take care of all your garment care needs.</p>
            
            <p>We are excited to have you as part of our community and look forward to providing you with exceptional service. If you
            have any questions or concerns, please don't hesitate to reach out to our customer support team, who are available 24/7
            to assist you.</p>
            
            {{-- <p>Thank you for choosing {{ cache('setting')->business_name }}. We can't wait to start working with you!</p> --}}
            
            <p>Best regards,</p>

            </section>
        </section>

       <footer class="text-center">
          {{--  <ul style="list-style: none;">
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