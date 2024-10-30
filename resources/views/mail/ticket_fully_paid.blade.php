<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Fully Paid</title>
</head>
<body>
    <h1>Dear {{ $ticket->name }},</h1>

    <p>Congratulations! We are happy to inform you that all of your installments have been successfully paid, and your ticket is now fully paid.</p>

    <p><strong>Ticket Details:</strong></p>
    <ul>
        <li><strong>Ticket ID:</strong> {{ $ticket->id }}</li>
        <li><strong>Event/Service:</strong> {{ $ticket->event_name }}</li>
        <li><strong>Total Amount Paid:</strong> {{ $ticket->total_paid }} {{ $ticket->currency }}</li>
    </ul>

    <p>Thank you for completing the payment! We look forward to providing you with our service.</p>

    <p>If you have any questions, feel free to contact our support team.</p>

    <p style="display:block">Regards,</p>
    <p>Medical Care & Physiotherapy Clinic</p>
</body>
</html>