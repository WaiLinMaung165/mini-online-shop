<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $order->order_code }}</title>
    <style>
        body {
            font-family: 'Domine', serif;
            background: #ffffff;
            color: #000000;
            margin: 0;
            padding: 0;
            font-size: 14px;
            position: relative;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            position: relative;
            z-index: 2;
        }

        /* Paid Watermark Styling */
        .watermark {
            position: fixed;
            top: 35%;
            left: 20%;
            transform: rotate(-30deg);
            font-size: 130px;
            font-weight: bold;
            color: rgba(25, 135, 84, 0.12);
            z-index: 1;
            text-align: center;
            width: 60%;
            letter-spacing: 10px;
        }

        .product-img {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #dddddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
    @if ($order->status == 'Completed' || $order->status == 'Approved' || $order->status == 'Shipped')
        <div class="watermark">PAID</div>
    @endif

    <div class="invoice-box">
        <!-- Header Section: 1 Row 2 Column (Store Info & Invoice Details) -->
        <table style="margin-bottom: 25px; border: none;">
            <tr>
                <td style="width: 50%; vertical-align: top; border: none; padding: 0;">
                    <h1 style="font-weight: bold; color: goldenrod; margin: 0; font-size: 32px; line-height: 1;">
                        ruiz<span style="color: black;">.</span>
                    </h1>
                    <p style="color: goldenrod; font-size: 13px; margin: 5px 0 0 0;">Online Luxury Watch Store</p>
                </td>
                <td style="width: 50%; vertical-align: top; text-align: right; border: none; padding: 0;">
                    <h3 style="font-weight: bold; color: darkred; margin: 0 0 8px 0; font-size: 20px;">INVOICE</h3>
                    <p style="margin: 0 0 3px 0; font-size: 13px;"><strong>Order Code:</strong> {{ $order->order_code }}
                    </p>
                    <p style="margin: 0 0 3px 0; font-size: 13px;"><strong>Date:</strong>
                        {{ $order->created_at->format('d M Y, h:i A') }}</p>
                    <p style="margin: 0; font-size: 13px;"><strong>Status:</strong> <span
                            style="color: #198754; font-weight: bold;">{{ $order->status }}</span></p>
                </td>
            </tr>
        </table>

        <table
            style="margin-bottom: 25px; border: 1px solid #dddddd; background-color: #f8f9fa; width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 100%; vertical-align: top; padding: 12px; border: none;">
                    <h4 style="font-weight: bold; margin: 0 0 8px 0; font-size: 15px; color: #333;">Customer Info:</h4>
                    <table style="width: 100%; border: none; border-collapse: collapse;">
                        <tr>
                            <td style="border: none; padding: 3px 0; vertical-align: top;">
                                <strong>Name:</strong> {{ $order->user->name ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: none; padding: 3px 0; vertical-align: top;">
                                <strong>Phone:</strong> {{ $order->phone }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: none; padding: 3px 0; vertical-align: top;">
                                <strong>Address:</strong> {{ $order->shipping_address }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Products Table with Borders -->
        <table style="border: 1px solid #dddddd;">
            <thead>
                <tr style="background-color: #f8f9fa; border-bottom: 1px solid #dddddd;">
                    <th style="border: 1px solid #dddddd; padding: 10px;">Product</th>
                    <th style="border: 1px solid #dddddd; padding: 10px; text-align: right;">Price</th>
                    <th style="border: 1px solid #dddddd; padding: 10px; text-align: center;">Quantity</th>
                    <th style="border: 1px solid #dddddd; padding: 10px; text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $calculatedSubtotal = 0;
                @endphp
                @foreach ($order->orderItems as $item)
                    @php
                        $itemSub = $item->price * $item->quantity;
                        $calculatedSubtotal += $itemSub;
                    @endphp
                    <tr>
                        <td style="border: 1px solid #dddddd; padding: 10px; vertical-align: middle;">
                            <table style="width: 100%; border: none; border-collapse: collapse;">
                                <tr>
                                    <td style="width: 55px; border: none; padding: 0; vertical-align: middle;">
                                        @if ($item->product && $item->product->image)
                                            <img src="{{ public_path('storage/' . $item->product->image) }}"
                                                class="product-img">
                                        @else
                                            <div
                                                style="width: 45px; height: 45px; background: #f8f9fa; border: 1px solid #dddddd; text-align: center; line-height: 45px; border-radius: 6px;">
                                                <small style="font-size: 10px; color: #777777;">No Img</small>
                                            </div>
                                        @endif
                                    </td>
                                    <td style="border: none; padding-left: 10px; vertical-align: middle;">
                                        <span
                                            style="font-weight: 600;">{{ $item->product->name ?? 'Product Deleted' }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td
                            style="border: 1px solid #dddddd; padding: 10px; text-align: right; vertical-align: middle;">
                            ${{ number_format($item->price, 2) }}
                        </td>
                        <td
                            style="border: 1px solid #dddddd; padding: 10px; text-align: center; vertical-align: middle;">
                            {{ $item->quantity }}
                        </td>
                        <td
                            style="border: 1px solid #dddddd; padding: 10px; text-align: right; vertical-align: middle; font-weight: bold;">
                            ${{ number_format($itemSub, 2) }}
                        </td>
                    </tr>
                @endforeach
            <tbody>
        </table>

        <!-- Subtotal, Discount & Grand Total Section -->
        <div style="width: 300px; margin-left: auto; margin-top: 25px;">
            <table style="border: none;">
                @php
                    $discountVal = $calculatedSubtotal - $order->total_amount;
                @endphp

                @if ($discountVal > 0)
                    <tr>
                        <td style="padding: 5px 0; border: none; color: #555;">Subtotal:</td>
                        <td style="padding: 5px 0; border: none; text-align: right; font-weight: bold;">${{ number_format($calculatedSubtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0; border: none; color: #198754;">Discount:</td>
                        <td style="padding: 5px 0; border: none; text-align: right; font-weight: bold; color: #198754;">-${{ number_format($discountVal, 2) }}</td>
                    </tr>
                @endif

                <tr>
                    <td style="padding: 8px 0; border-top: 2px solid #000; font-weight: bold; font-size: 16px;">Total Amount:</td>
                    <td style="padding: 8px 0; border-top: 2px solid #000; text-align: right; font-weight: bold; font-size: 16px; color: #198754;">${{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div style="text-align: center; margin-top: 50px; color: #777777; font-size: 12px;">
            <p style="margin: 0;">Thank you for shopping with Ruiz Watches!</p>
        </div>
    </div>
</body>

</html>
