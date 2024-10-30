@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row pb-2">
        <div class="col-md-12 px-0">
            <div class="card border-0 rounded-0">
                <div class="card-header bg-success text-white rounded-0 py-3">
                    {{ __('Appoinments') }}
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
                        <th scope="col">Patient Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Address</th>
                        <th scope="col">Appoinment Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $index=>$ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->patient->name }}</td>
                        <td>{{ $ticket->patient->age }}</td>
                        <td>{{ $ticket->patient->address }}</td>
                        <td>{{ $ticket->appointment_date }}</td>
                        <td>
                            <a href="{{ route('ticketDetail', ['id' => $ticket->id]) }}"
                                class="text-decoration-none text-success" style="font-size:14px">View Details</a>
                            @if (Auth::user()->type == 'doctor')
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAppointmentDetailsModal" data-id="{{ $ticket->id }}">
                                Add Items
                            </button>
                            @endif


                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Add Appointment Details Modal -->
    <div class="modal fade" id="addAppointmentDetailsModal" tabindex="-1" aria-labelledby="addAppointmentDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="addAppointmentDetailsForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAppointmentDetailsModalLabel">Add Details to Appointment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="appointment_id" id="appointment_id">

                        <!-- Clinic Notes Section -->
                        <h6 class="text-primary mt-3">Clinic Notes</h6>
                        <hr>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">DM</label>
                            <div class="col-md-4">
                                <input type="checkbox" name="dm" id="dm" class="form-check-input">
                                <label for="dm" class="form-check-label">Diabetes Mellitus</label>
                            </div>

                            <label class="col-md-2 col-form-label">HT</label>
                            <div class="col-md-4">
                                <input type="checkbox" name="ht" id="ht" class="form-check-input">
                                <label for="ht" class="form-check-label">Hypertension</label>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">BP</label>
                            <div class="col-md-4">
                                <input type="text" name="bp" class="form-control" placeholder="e.g., 130/90">
                            </div>

                            <label class="col-md-2 col-form-label">PC</label>
                            <div class="col-md-4">
                                <input type="text" name="pc" class="form-control" placeholder="Presenting Complaint">
                            </div>
                        </div>

                        <!-- Medicines Section -->
                        <!-- Medicines Section -->
                        <h6 class="text-primary mt-4">Medicines</h6>
                        <hr>
                        <div class="mb-3">
                            @foreach($medicines as $medicine)
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="medicines[]" value="{{ $medicine->id }}" id="medicine_{{ $medicine->id }}">
                                        <label class="form-check-label" for="medicine_{{ $medicine->id }}">{{ $medicine->name }} - {{ $medicine->size }}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="days[{{ $medicine->id }}]" class="form-control" placeholder="Days" min="1">
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Lab Tests Section -->
                        <h6 class="text-primary mt-4">Lab Tests</h6>
                        <hr>
                        <div class="mb-3">
                            @foreach($lab_tests as $test)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="lab_tests[]" value="{{ $test->id }}" id="test_{{ $test->id }}">
                                <label class="form-check-label" for="test_{{ $test->id }}">{{ $test->name }}</label>
                            </div>
                            @endforeach
                        </div>


                        <!-- Prescriptions Section -->
                        <h6 class="text-primary mt-4">Prescription</h6>
                        <hr>
                        <div class="mb-3">
                            <textarea name="prescription" class="form-control" rows="3" placeholder="Enter prescription details here..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('button[data-bs-target="#addAppointmentDetailsModal"]').on('click', function() {
            // Get the ID from the data-id attribute
            var appointmentId = $(this).data('id');

            // Set the value of the hidden input
            $('#appointment_id').val(appointmentId);
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#addAppointmentDetailsForm').on('submit', function(e) {
            e.preventDefault();

            // Create a new FormData object
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: '/appointments/add-details',
                data: formData,
                processData: false, // Prevent jQuery from automatically transforming the data into a query string
                contentType: false, // Prevent jQuery from overriding the Content-Type
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: `Appointment`,
                            text: `Prescriptions Added Successfully!`,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                        $('#addAppointmentDetailsModal').modal('hide');
                        window.location.reload();
                    }
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    if (errors) {
                        Object.values(errors).forEach(error => {
                            Swal.fire({
                                icon: 'error',
                                title: `Appointment`,
                                text: error[0],
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: `Appointment`,
                            text: `An unexpected error occurred. Please try again.`,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                }
            });
        });

    });
</script>


@endsection