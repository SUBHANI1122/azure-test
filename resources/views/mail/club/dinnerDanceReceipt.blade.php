<!DOCTYPE html>
<html>

<head>
    <title>{{ __('Dinner Dance') }}</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }



        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            /* text-align: center; */
            font-size: 14px;
        }

        .table .borderless {
            border: none !important;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .mt-2 {
            margin-top: 20px;
        }

        .mt-3 {
            margin-top: 30px;
        }

        .pb-1 {
            padding-bottom: 10px;
        }

        .pt-1 {
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <table class="header" style="display: inline-block; background-color: #DC3545; color: #FFFFFF; padding: 10px; text-align: left;" width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td width="20%">
                    <img src="{{ asset('images/logo.png') }}" alt="logo image" width="50%" height="auto" style="display: block; margin-right: 20px; max-width: 100%; border: 0; line-height: 0; vertical-align: middle;">
                </td>
                <td width="80%">
                    <h2 style="margin: 0; padding-top: 20px; color: #FFFFFF;">Medical Care & Physiotherapy Clinic</h2>
                </td>
            </tr>
        </table>

        <p style="display: block;
    padding: 0px;
    margin-top: 35px;">Dear <strong>{{ $ticket->first_name }},</strong></p>
        <p style="">Thank you for joining us at the Medical Care & Physiotherapy Clinic 50<sup>th</sup>Anniversary dinner dance. Please bring this email receipt as proof of purchase on the night.</p>
        <table class="table mt-3">
            <tr>
                <td><strong>Name:</strong> {{ $ticket->first_name }} {{ $ticket->last_name }}</td>
                <td><strong>Ticket No:</strong> {{ $ticket->serial_number }}</td>
            </tr>
            <tr>
                <td><strong>Registration Date:</strong> {{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y') }}</td>
                @if ($ticket->status == 'paid')
                <td><strong>Status:</strong> <strong style="color: blue;">Paid</strong></td>
                @else
                <td><strong>Status:</strong> <strong style="color: orange;">Due</strong></td>
                @endif
            </tr>
        </table>

        <table class="table mt-2">
            <tr>
                <td><strong>Telephone:</strong> {{ $ticket->phone }}</td>
                <td><strong>Email:</strong> {{ $ticket->email }}</td>
                <td><strong>Address:</strong> {{ $ticket->address }}</td>
            </tr>
            <tr>
                <td colspan="3"><strong>Dietary Requirements:</strong> {{ $ticket->dietary_requiements }}</td>
            </tr>
        </table>
        <table class="table mt-2">
            <tr class="borderless">
                <td><strong>Venue:</strong>Abbeyleix Manor Hotel</td>
            </tr>
            <tr class="borderless">
                <td><strong>Time & Date:</strong> 6:30 PM - 2ND November 2024</td>
            </tr>
        </table>

        <h3>Payment details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Amount Paid</th>
                    <th>Transaction ID</th>
                    <th>Credit type</th>
                    <th>Card Number</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>€ {{ $ticket->total_amount }}</td>
                    <td>{{ $ticket->transaction_id }}</td>
                    <td>{{ $ticket->card_brand }}</td>
                    <td>XXXXXXXXXXXX{{ $ticket->last4 }}</td>
                </tr>
            </tbody>
        </table>
        <p style="display:block">Kind regards,</p>
        <p>Medical Care & Physiotherapy Clinic</p>
    </div>

</body>

</html>
