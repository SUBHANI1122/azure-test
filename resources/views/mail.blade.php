<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="pb-2 px-0">
            <div class="col-md-12 px-0">
                <div class="card border-0 rounded-0">
                    <!-- <div class="card-header bg-success text-white rounded-0 py-3">
                        <h4 class="mb-0"> {{ __('Naomh Columba Draw 2023 Entry Ticket No:') }}
                            {{ $ticketNumbers }}
                        </h4>

                    </div> -->
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card px-4">
                <!-- <div class="card-header">{{ __('Naomh Columba Draw 2023 Entry  : ') }} {{ $ticketData->id }}
                </div> -->

                <div class="card-body">
                    <div class="row">
                        {{-- <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                            <img src="{{ public_path('images/logo1.png') }}" class="img-fluid" width="111"
                                height="111" alt="logo image">
                        </div> --}}


                        <div class="row">
                            <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                <div class="pt-5">
                                    <p class="pt-1 mb-0"> <strong> Name</strong>: {{ $ticketData->first_name }}
                                        {{ $ticketData->last_name }}</p>
                                    <p class="pt-1 mb-0"><strong>Email</strong>: {{ $ticketData->email }}</p>

                                </div>

                            </div>
                            <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="pt-5">
                                    <p class="pt-1 mb-0"><strong>Phone</strong>: {{ $ticketData->phone }}</p>
                                    <p class="pt-1 mb-0"><strong>Address</strong>: {{ $ticketData->address }}</p>

                                </div>
                            </div>

                            <div class="col-12 p-3 my-1 mt-2 border">
                                <p class="pt-1 mb-0"><strong>Order Id</strong>:{{ $ticketData->id }}
                                </p>
                                <p class="pt-1 mb-0"><strong>Quantity</strong>: {{ $ticketData->quantity }}</p>
                                <p class="pt-1 mb-0"><strong>Ticket Number</strong>:
                                    {{ $ticketNumbers }}
                                </p>
                                {{-- <p class="pt-1 mb-0"><strong>Status :</strong><strong
                                        style ='color:green;'>Paid</strong>
                                </p> --}}
                                <p class="pt-1 mb-0"><strong>Amount Paid</strong>: {{ $ticketData->total_amount }}</p>
                                <p class="pt-1 mb-0"><strong>Transaction ID</strong>: {{ $ticketData->transaction_id }}
                                </p>
                                <p class="pt-1 mb-0"><strong>Credit type</strong>: {{ $ticketData->card_brand }}</p>
                                <p class="pt-1 mb-0"><strong>Card Number</strong>: XXXXXXXXXXXX{{ $ticketData->last4 }}
                                </p>
                            </div>
                            <div class="col-12 p-3 my-1 border">
                                <p class="mb-0"><strong>Conditions</strong></p>
                                <p class="text-muted">(1) You should purchase your ticket through the club or
                                    on-line.</p>
                                <p class="text-muted"> (2) You will be issued with an official receipt.</p>
                                <p class="text-muted"> (3) Your entry will be assigned a unique Draw ID Number which
                                    you can obtain from the club coordinator.</p>
                                <p class="text-muted"> (4) The draw dates will be advertised on local and on-line
                                    media.</p>
                                <p class="text-muted"> (5) Results will be posted on local and on-line media.</p>

                            </div>
                        </div>
                        {{-- <div class="table-responsive">
                                <table class="table table-bordered  mb-5">
                                    <thead>
                                        <tr style="font-size: 14px">
                                            <th class="pt-1 pb-1 text-center" style="width:33%">Ticket Number</th>
                                            <th class="pt-1 pb-1 text-center" style="width:33%">Order Id</th>
                                            <th class="pt-1 pb-1 text-center" style="width:33%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="font-size: 14px">
                                            <td class="pt-1 pb-1 text-center">
                                               {{$ticketNumbers}}
                                            </td>
                                            <td class="pt-1 pb-1 text-center">{{$ticketData->id}}</td>
                                            <td class="pt-1 pb-1 text-center text-success"><strong>Paid</strong></td>
                                        </tr>
                                    </tbody>

                            </div> --}}
                    </div>
                    {{-- <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="font-size: 14px">
                                        <th class="pt-1 pb-1 text-center">Quantity</th>
                                        <th class="pt-1 pb-1 text-center">Amount Paid</th>
                                        <th class="pt-1 pb-1 text-center">Transaction ID</th>
                                        <th class="pt-1 pb-1 text-center">Credit type</th>
                                        <th class="pt-1 pb-1 text-center">Card Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size: 14px">
                                        <td class="pt-1 pb-1 text-center">{{$ticketData->quantity}}</td>
                                        <td class="pt-1 pb-1 text-center"> € {{$ticketData->total_amount}}</td>
                                        <td class="pt-1 pb-1 text-center">{{$ticketData->transaction_id}}</td>
                                        <td class="pt-1 pb-1 text-center">{{$ticketData->card_brand}}</td>
                                        <td class="pt-1 pb-1 text-center">XXXXXXXXXXXX{{$ticketData->last4}}</td>


                                    </tr>
                                </tbody>
                            </table>
                        </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
