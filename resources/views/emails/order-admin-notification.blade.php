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

            <h1 class="title">Thank you</h1>
            <p>An order has been placed from {{ $order->user->fullname }}</p>
        </section>

        <section style="border-radius: 5px;background-color: #fff; margin: 50px 0; color: #5E5E5E; padding: 10px">

            <section>
                <div>
                    <strong>Order Number:</strong> <span>#{{ $order->id }}</span>
                </div>
                <div>
                    <strong>Order Date:</strong> <span>{{ $order->created_at->format('d M Y h:i A') }}</span>
                </div>
            </section>

            <section style="text-align: left;">
                <table class="table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>SNO</th>
                            <th>Item Details</th>
                            <th class="w-24">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->details as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->variant->service->name ?? NULL}} ({{ $item->variant->name ?? NULL }})</td>
                            <td>&#8358;{{ $item->price }}</td>
                        </tr>
                        @endforeach
                        <tr class="text-sm">
                            <td colspan="2" style="font-weight: bold; padding: 2px 0; text-align: right">Subtotal:</td>
                            <td class="font-light">&#8358;{{ $order->sub_total }}</td>
                        </tr>
                        <tr class="text-sm">
                            <td colspan="2" style="font-weight: bold; padding: 2px 0; text-align: right">Discount:</td>
                            <td class="font-light">-&#8358;{{ $order->coupon_amount }}</td>
                        </tr>
                        <tr class="text-sm">
                            <td colspan="2" style="font-weight: bold; padding: 2px 0; text-align: right">Service Fee:
                            </td>
                            <td class="font-light">+&#8358;{{ $order->service_fee }}</td>
                        </tr>
                        <tr class="text-sm">
                            <td colspan="2" style="font-weight: bold; padding: 2px 0; text-align: right">Delivery Fee:
                            </td>
                            <td class="font-light">+&#8358;{{ $order->delivery_fee }}</td>
                        </tr>
                        <tr class="text-sm">
                            <td colspan="2" style="font-weight: bold; padding: 2px 0; text-align: right">Driver Tip:
                            </td>
                            <td class="font-light">+&#8358;{{ $order->driver_tip }}</td>
                        </tr>
                        <tr class="text-sm">
                            <td colspan="2" style="font-weight: bold; padding: 2px 0; text-align: right">Tax:</td>
                            <td class="font-light">+&#8358;0.00</td>
                        </tr>
                        <tr class="text-sm">
                            <td colspan="2" style="font-weight: bold; padding: 2px 0; text-align: right">Total:</td>
                            <td class="font-light">&#8358;{{ number_format($order->order_amount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </section>

        <footer class="text-center">
            <div style="font-size: 24px;">Copyright © {{ date('Y') }}</div>
            <div class="content-title">{{ cache('setting')->business_name }}</div>
        </footer>
    </main>
</body>

</html>