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

        .header {
            background-color: #dc3545;
            color: #ffffff;
            padding: 5px;
            text-align: left;
            /* height: 100px; */
        }

        .header img {
            float: left;
            margin-right: 20px;
            width: 80px;
            height: 80px;
        }

        .header h2 {
            margin: 0;
            /* padding-bottom: 20px; */
            padding-top: 20px;
            display: inline-block;
            vertical-align: top;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
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
        <div class="header">
            <img src="{{ public_path('images/logo.png') }}" alt="logo image">
            <h3>Medical Care & Physiotherapy Clinic</h3>
        </div>
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
                    <td>{{ \Carbon\Carbon::parse($child->dob)->format('Y-m-d') }}</td>
                    <td>{{ $child->academy }}</td>
                    <td>€ {{ academy_price()[$child->academy] }}</td>
                </tr>
                @endforeach
            </tbody>
            @if($ticket->ticket_details->count() > 1)
            <tbody>
                <tr>
                    <td colspan="4" class="text-right borderless">Discount €10 for every sibling:</td>
                    <td>€ {{ $ticket->discount }}</td>
                </tr>
            </tbody>
            @endif
            <tbody>
                <tr>
                    <td colspan="4" class="text-right borderless">Total Amount:</td>
                    <td>€{{ $ticket->total_amount }}</td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td colspan="4" class="text-right borderless">Total Paid:</td>
                    <td>€{{ $ticket->status != 'paid' ? $ticket->initial_payment   : $ticket->total_amount}}</td>
                </tr>

            </tbody>
        </table>
        @if ($ticket->status != 'paid')
        <h3>Installments</h3>
        <p style="font-size: 14px;">
            This registration is being processed through an installment payment plan.
            A 25% deposit of the total amount has been deducted with the initial payment.
            The remaining balance will be automatically deducted in installments on their respective due dates as outlined below.
        </p>
        <table class="table text-center">
            <thead>
                <tr>
                    <th>Installments</th>
                    <th>Amount</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ticket->installments as $installment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>€ {{ $installment->amount }}</td>
                    <td>{{$installment->due_date }}</td>
                    <td>{{$installment->status }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif

        <h3>Payment details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Amount Paid</th>
                    <th>Transaction ID</th>
                    <th>Credit type</th>
                    <th>Card Number</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>€{{ $ticket->status != 'paid' ? $ticket->initial_payment   : $ticket->total_amount}}</td>
                    <td>{{ $ticket->transaction_id }}</td>
                    <td>{{ $ticket->card_brand }}</td>
                    <td>XXXXXXXXXXXX{{ $ticket->last4 }}</td>
                    <td class="pt-1 pb-1 text-center">{{ \Carbon\Carbon::parse($ticket->created_at)->format('Y-m-d') }}</td>
                </tr>
            </tbody>
        </table>
        <p style="display:block">Regards,</p>
        <p>Medical Care & Physiotherapy Clinic</p>
    </div>

</body>

</html>