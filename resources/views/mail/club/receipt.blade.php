<!DOCTYPE html>
<html>

<head>
    <title>{{ __('Medical Care & Physiotherapy Clinic') }}</title>
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
        <p style="">Thank you for registering with Medical Care & Physiotherapy Clinic.</p>
        <table class="table mt-3">
            <tr>
                <td><strong>Name:</strong> {{ $ticket->first_name }} {{ $ticket->last_name }}</td>
                <td><strong>Registration No:</strong> {{ $ticket->id }}</td>
            </tr>
            <tr>
                <td><strong>Registration Date:</strong> {{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y') }}</td>
                @if ($ticket->status == 'paid')
                <td><strong>Status:</strong> <strong style="color: blue;">Paid</strong></td>
                @else
                <td><strong>Status:</strong> <strong style="color: orange;">Partialy Paid</strong></td>
                @endif
            </tr>
        </table>

        <table class="table mt-2">
            <tr class="borderless">
                <td><strong>Telephone:</strong> {{ $ticket->phone }}</td>
                {{-- <td class="borderless"></td> --}}
            </tr>
            <tr class="borderless">
                <td><strong>Email:</strong> {{ $ticket->email }}</td>
                {{-- <td class="borderless"></td> --}}
            </tr>
        </table>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Player Name</th>
                    <th>Date Of Birth</th>
                    <th>Age Group</th>
                    <th>Amount €</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ticket->ticket_details as $index=>$child)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $child->name }}</td>
                    <td >{{ \Carbon\Carbon::parse($child->dob)->format('Y-m-d') }}</td>
                    <td>{{ $child->academy }}</td>
                    <td>€ {{ academy_price()[$child->academy] }}</td>
                </tr>
                @endforeach
            </tbody>
            @if($ticket->ticket_details->count() > 1)
            <tbody>
                <tr>
                    <td colspan="3" class="text-right borderless">Discount €10 for every sibling:</td>
                    <td>€ {{ $ticket->discount }}</td>
                </tr>
            </tbody>
            @endif
            <tbody>
                <tr>
                    <td colspan="3" class="text-right borderless">Total Paid:</td>
                    <td>€{{ $ticket->total_amount }}</td>
                </tr>
            </tbody>
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
        <p style="display:block">Regards,</p>
        <p>Medical Care & Physiotherapy Clinic</p>
    </div>

</body>

</html>
