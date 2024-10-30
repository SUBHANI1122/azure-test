@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row pb-2">
        <div class="col-md-12 px-0">
            <div class="card border-0 rounded-0">
                <div class="card-header bg-success text-white rounded-0 py-3">
                    {{ __('Dinner Dance Tickets') }}
                    <button type="button" class="btn text-white btn-lg mobile-menu">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>

                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center px-5 py-5">
        <div class="table-responsive">
            <table class="table table-bordered" id="entries-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Type</th>
                        <th scope="col">Ticket No</th>
                        <th scope="col">Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $index=>$ticket)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <a href="">
                            <th>{{ $ticket->id }}</th>
                        </a>
                        <td>{{ $ticket->first_name }}</td>
                        <td>{{ $ticket->last_name }}</td>
                        <td>{{ $ticket->email }}</td>
                        <td>{{ $ticket->phone }}</td>
                        <td>{{ $ticket->type ?? 'Medical Care & Physiotherapy Clinic' }}</td>
                        <td>{{ $ticket->ticket_numbers }}</td>
                        <td>{{ $ticket->total_amount }}</td>
                        <td>
                            <a href="{{ route('dinner.dance.detail', ['id' => $ticket->id]) }}"
                                class="text-decoration-none text-success" style="font-size:14px">View Details</a>
                            <button type="button" class="btn btn-default btn-sm resend-email-btn" data-ticket-id="{{ $ticket->id }}" data-ticket-type="dinnerDanceReceipt" title="Resend Email">
                                <i class="fas fa-envelope"></i>
                            </button>

                            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#childrenModal-{{ $ticket->id }}">
                            View Details
                            </button> --}}
                            {{-- @include('admin.childModal') --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection
