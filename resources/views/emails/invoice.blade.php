<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
</head>

<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Hello {{ $order->user->name ?? 'Valued Customer' }},</h2>
    <p>Thank you for shopping with Ruiz Watches!</p>
    <p>Your order <strong>{{ $order->order_code }}</strong> has been approved and processed successfully.</p>
    <p>Please find your attached invoice PDF for your records.</p>
    <br>
    <p>Best regards,<br><strong>Ruiz Watches Team</strong></p>
</body>

</html>
