@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="pb-2 px-0">
                <div class="col-md-12 px-0">
                    <div class="card border-0 rounded-0">
                        <div class="card-header bg-success text-white rounded-0 py-3">
                            <h4 class="mb-0"> {{ __('Medical Care & Physiotherapy Clinic') }}
                                {{-- {{ $ticketNumbers }} --}}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card px-4">
                    {{-- <div class="card-header">{{ __('Naomh Columba Draw 2023 Entry  : ') }} {{$ticket->id}}
            </div> --}}

                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-sm-6 col-md-6 col-lg-6">
                                <img src="{{ asset('images/logo.png') }}" class="img-fluid" width="60px" height="60px"
                                    alt="logo image">

                            </div>
                            <div class="col-8 col-sm-6 col-md-6 col-lg-6">
                                <a class="btn btn-success btn-sm float-end " href="{{ route('dinner.dance.index') }}">Back</a>
                                <a class="btn btn-success btn-sm float-end" style="margin-right:5px"
                                    href="{{ route('dinner.dance.pdf', ['id' => $ticket->id]) }}">Downlod PDF</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-8 col-md-8 col-lg-8">
                                <div class="pt-5">
                                    <p class="pt-1 mb-0"><span class="fw-bold">Name</span>:
                                        {{ $ticket->first_name }}{{ $ticket->last_name }}</p>
                                    <p class="pt-1 mb-0"><span class="fw-bold">Email</span>: {{ $ticket->email }}</p>

                                </div>

                            </div>
                            <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="pt-0 pt-md-5">
                                    <p class="pt-1 mb-0"><span class="fw-bold">Phone</span>: {{ $ticket->phone }}</p>
                                    <p class="pt-1 mb-0"><span class="fw-bold">Address</span>: {{ $ticket->address }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-8 col-md-8 col-lg-8">
                                <div class="pt-0 pt-md-3">
                                    <p class="pt-1 mb-0"><span class="fw-bold">Venue</span>: Abbeyleix Manor Hotel</p>
                                    <p class="pt-1 mb-0"><span class="fw-bold">Time & Date</span>: 6:30 PM - 2ND November 2024</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="pt-0 pt-md-3">
                                    <p class="pt-1 mb-0"><span class="fw-bold">Ticket No</span>: {{ $ticket->serial_number }}</p>
                                    <p class="pt-1 mb-0"><span class="fw-bold">Dietary Requirements:</span> {{ $ticket->dietary_requiements }}</p>
                                </div>
                            </div>
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered  mb-5">
                                    <thead>
                                        <tr style="font-size: 14px">
                                            <th class="pt-1 pb-1 text-center" style="width:33%">Order Id</th>
                                            <th class="pt-1 pb-1 text-center" style="width:33%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="font-size: 14px">
                                            <td class="pt-1 pb-1 text-center">{{ $ticket->id }}</td>
                                            <td class="pt-1 pb-1 text-center text-success"><strong>{{ ucfirst($ticket->status) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="font-size: 14px">
                                        {{-- <th class="pt-1 pb-1 text-center">Quantity</th> --}}
                                        <th class="pt-1 pb-1 text-center">Amount Paid</th>
                                        <th class="pt-1 pb-1 text-center">Transaction ID</th>
                                        <th class="pt-1 pb-1 text-center">Credit type</th>
                                        <th class="pt-1 pb-1 text-center">Card Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size: 14px">
                                        {{-- <td class="pt-1 pb-1 text-center">{{ $ticket->quantity }}</td> --}}
                                        <td class="pt-1 pb-1 text-center">€ {{ $ticket->total_amount }}</td>
                                        <td class="pt-1 pb-1 text-center">{{ $ticket->transaction_id }}</td>
                                        <td class="pt-1 pb-1 text-center">{{ $ticket->card_brand }}</td>
                                        <td class="pt-1 pb-1 text-center">XXXXXXXXXXXX{{ $ticket->last4 }}</td>


                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        @endsection
