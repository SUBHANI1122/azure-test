<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Action Required: Installment Payment Failure</title>
</head>
<body>
    <h1>Hello {{ $name }},</h1>

    <p>
        We regret to inform you that your installment payment for ticket #{{ $ticketId }} has failed.
        The payment amount was <strong>${{ number_format($installmentAmount, 2) }}</strong>, which was due on <strong>{{ \Carbon\Carbon::parse($dueDate)->format('F j, Y') }}</strong>.
    </p>

    <p>
        This may have occurred because your card requires additional authentication (3D Secure) for every payment.
        Please contact your bank to enable this feature so you can proceed with your installment payments.
    </p>

    <p>
        If you have any questions or need assistance, feel free to reach out to our support team at support@example.com.
    </p>

    <p>Thank you for your understanding!</p>
    
    <p>Best regards,</p>
    <p>Your Company Name</p>
</body>
</html>
