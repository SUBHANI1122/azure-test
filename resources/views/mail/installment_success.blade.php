<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installment Payment Successful</title>
</head>
<body>

    <h1>Dear {{ $ticket->first_name  . ' ' . $this->ticket->last_name }},</h1>

    <p>We are pleased to inform you that your installment payment has been successfully processed.</p>

    <p><strong>Installment Details:</strong></p>
    <ul>
        <li><strong>Installment ID:</strong> {{ $installment->id }}</li>
        <li><strong>Amount Paid:</strong> {{ $installment->amount }} EUR</li>
        <li><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($installment->due_date)->format('d M, Y') }}</li>
    </ul>

    <p>Thank you for your prompt payment!</p>

    <p>If you have any questions, feel free to contact our support team.</p>

    <p style="display:block">Regards,</p>
        <p>Medical Care & Physiotherapy Clinic</p>
</body>
</html>