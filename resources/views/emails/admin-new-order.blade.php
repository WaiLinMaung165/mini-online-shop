<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>New Order Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .header {
            background: #111;
            color: #fff;
            padding: 15px;
            text-align: center;
            border-radius: 6px 6px 0 0;
        }

        .content {
            padding: 20px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th,
        .table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }

        .total {
            text-align: right;
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Ruiz Watches - Admin Notification</h2>
        </div>
        <div class="content">
            <h3>Hello Admin,</h3>
            <p>A new order has been placed on Ruiz Watches.</p>

            <ul>
                <li><strong>Order Code:</strong> {{ $order->order_code }}</li>
                <li><strong>Customer Name:</strong> {{ $order->user->name ?? 'N/A' }}</li>
                <li><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</li>
                <li><strong>Phone:</strong> {{ $order->phone }}</li>
                <li><strong>Shipping Address:</strong> {{ $order->shipping_address }}</li>
            </ul>

            <h4>Ordered Items:</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td style="width: 50px;">
                                @if ($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="Product"
                                        style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <span class="text-muted small">No Image</span>
                                @endif
                            </td>
                            <td>{{ $item->product->name ?? 'Product' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- <div class="total">
                <p>Total Amount: ${{ number_format($order->total_amount, 2) }}</p>
            </div> --}}

            <div style="margin-top: 20px; text-align: right; font-size: 14px;">
                <p style="margin: 5px 0;">Subtotal: <strong>${{ number_format($order->orderItems->sum(fn($item) => $item->price * $item->quantity), 2) }}</strong></p>

                @if(isset($order->discount_amount) && $order->discount_amount > 0)
                    <p style="margin: 5px 0; color: #d9534f;">Discount: <strong>-${{ number_format($order->discount_amount, 2) }}</strong></p>
                @endif

                <p style="margin: 5px 0; font-size: 16px; font-weight: bold;">Grand Total: ${{ number_format($order->total_amount, 2) }}</p>
            </div>

            <p style="margin-top: 30px;">Please check your admin panel to approve and process the order.</p>
        </div>
    </div>
</body>

</html>
