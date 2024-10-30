<!DOCTYPE html>
<html>

<head>
    <title>Upcoming Invoice Notification</title>
</head>

<body>
    <h1>Dear Customer,</h1>
    <p>Your upcoming installment for invoice <strong>#{{ $invoice['id'] }}</strong> is due soon.</p>
    <p>Total Amount Due: €{{ number_format($invoice['amount_due'] / 100, 2) }}</p>
    <p>Due Date: {{ \Carbon\Carbon::createFromTimestamp($invoice['next_payment_attempt'])->toFormattedDateString() }}</p>
    <p>Please ensure your payment details are up to date to avoid any disruptions.</p>
    <p>Thank you for your continued support!</p>
</body>

</html>