@extends('layouts.form')
@section('content')
<style>
    #loading_overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.5);
        z-index: 1000;
    }

    .loading_spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 8px solid transparent;
        border-top-color: #007bff;
        animation: spin 1s infinite linear;
    }

    .procedure {
        display: none;
        /* Hide by default */
    }

    @keyframes spin {
        0% {
            transform: translate(-50%, -50%) rotate(0deg);
        }

        100% {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }

    .iti {
        width: 100% !important;
    }
</style>
<section class="booking-formsection">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="booking-section pb-5">
                    {{-- <h1 class="text-white text-center mt-0 mb-0 p-5" style="border-bottom: 2px solid">ENTRY PRICE
                        €100 FOR
                        THE 10 WEEKS
                    </h1> --}}
                    <div id="loading_overlay">
                        <div class="loading_spinner"></div>
                    </div>
                    <form action="{{ route('storeDetails') }}" method="POST"
                        class="require-validation booking-form mt-3 pb-3" data-cc-on-file="false" id="payment-form">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="alert alert-success mb-5">
                                    <p class="text-color mb-1 fw-semibold">This form is for patient registration.</p>
                                    <p class="text-color mb-1">Please add the following details:</p>
                                    <ul>
                                        <li>Patient Name</li>
                                        <li>Phone Number</li>
                                        <li>Address</li>
                                    </ul>
                                    <p class="text-color">Select the doctor, submit the form, and a printout will be generated. Please collect it and give it to the patient.</p>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="row form-heading mt-3">
                                <h3 class="mt-0 text-white  d-flex align-items-center">
                                    <span class="pe-4 ps-2"><img src="{{ asset('images/user-vector.png') }}"></span>
                                    Patient
                                    Information
                                </h3>
                            </div>
                        </div>
                        <div class="row mt-0 pt-1">
                            <div class="col-12 col-sm-6 col-md-12">
                                <label for="search_patient" class="text-color mb-1 ps-1">Search Patient by Phone:</label>
                                <input type="text" class="form-control" id="search_patient" placeholder="Enter Phone Number to Search" />
                                <small class="text-muted">Search for an existing patient by phone number.</small>
                            </div>
                        </div>
                        <br>
                        <div class="row mt-0 pt-1">
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="text-color mb-1 ps-1">Patien Name:<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" id="name" name="name"
                                        placeholder="Enter Patien Name" required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="text-color mb-1 ps-1">Phone Number:<span
                                            class="text-danger">*</span></label><br>
                                    <input type="text" class="form-control" style="width:100%" name="phone"
                                        id="phone_number" placeholder="Phone Number" required pattern="[0-9+]*"
                                        inputmode="numeric" value="{{ old('phone') }}">
                                    <br>
                                    <span class="text-danger custom-error-message"
                                        style="display: none; font-size:13px">Invalid phone
                                        number. Please enter a valid phone number.</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3 mb-5">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="text-color mb-1 ps-1">Age:<span
                                            class="text-danger">*</span></label><br>
                                    <input type="number" class="form-control" style="width:100%" name="age"
                                        id="age" placeholder="Enter Age"
                                        value="{{ old('age') }}">
                                    <br>
                                    <span class="text-danger custom-error-message"
                                        style="display: none; font-size:13px">Invalid phone
                                        number. Please enter a valid phone number.</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address" class="text-color mb-1 ps-1">Address:</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('address') }}" id="address" name="address"
                                        placeholder="Enter Patient Address">
                                </div>
                            </div>

                        </div>


                        <div class="d-flex">
                            <div class="row form-heading mt-5">
                                <h3 class="mt-0 text-white  d-flex align-items-center">
                                    <span class="pe-4 ps-2"><img src="{{ asset('images/Group-1.png') }}"></span>
                                    Doctor Details
                                </h3>
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class=" col-12 col-sm-12 col-md-12">
                                <div class='form-group required'>
                                    <label for="dob" class="text-color">Select Doctor:<span
                                            class="text-danger">*</span></label>
                                    <select name="doctor_id" class="form-control child-academy"
                                        id="doctor_id" required>
                                        <option value="" selected disabled>Please Select An Doctor
                                        </option>
                                        <option value="1">Dr Afraz</option>
                                        <option value="2">DR Ayesha</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-12 col-sm-12 col-md-12">
                                <div class='form-group required'>
                                    <label for="department" class="text-color">Select Department:<span class="text-danger">*</span></label>
                                    <select name="department_id" class="form-control" id="department_id" required>
                                        <option value="" selected disabled>Please Select A Department</option>
                                        <option value="Medical Care and Physiotherapy">Medical Care and Physiotherapy</option>
                                        <option value="skin Aesthetic">Skin Aesthetic</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="row form-heading mt-5">
                                <h3 class="mt-0 text-white  d-flex align-items-center">
                                    <span class="pe-4 ps-2"><img src="{{ asset('images/Group-1.png') }}"></span>
                                    Payment Details
                                </h3>
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-md-4 procedure">
                                <div class="form-group">
                                    <label for="address" class="text-color mb-1 ps-1">Procedure Charges:</label>
                                    <input type="number" class="form-control" id="procedure_amount" name="procedure_amount"
                                        placeholder="Enter Doctor Fee">
                                </div>
                            </div>
                            <div class="col-md-4 procedure">
                                <div class="form-group">
                                    <label for="address" class="text-color mb-1 ps-1">Procedure Charges:</label>
                                    <input type="number" class="form-control" id="procedure_amount" name="procedure_amount"
                                        placeholder="Enter Doctor Fee">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address" class="text-color mb-1 ps-1">Doctor Fee:</label>
                                    <input type="number" class="form-control" id="amount" name="amount"
                                        placeholder="Enter Doctor Fee">
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 clearfix">
                            <button type="submit" id="submit_button"
                                class="btn  btn-lg booking-btn text-white float-end">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {

        $('#department_id').on('change', function() {
            if ($(this).val() === 'skin Aesthetic') {
                $('.procedure').show(); // Show procedure fields
            } else {
                $('.procedure').hide(); // Hide procedure fields
            }
        });
        $('#search_patient').on('blur', function() {
            let phoneNumber = $(this).val();

            // Check if the phone number starts with "0" and replace it with "+92"
            if (phoneNumber.startsWith("0")) {
                phoneNumber = phoneNumber.replace(/^0/, '+92');
                $(this).val(phoneNumber); // Update the input field with the modified phone number
            }
            if (phoneNumber) {
                $.ajax({
                    url: "{{ route('searchPatient') }}",
                    type: "GET",
                    data: {
                        phone: phoneNumber
                    },
                    success: function(response) {
                        if (response.success) {
                            // Fill the form fields with retrieved patient data
                            $('#name').val(response.patient.name);
                            $('#email1').val(response.patient.email);
                            $('#phone_number').val(response.patient.phone);
                            $('#age').val(response.patient.age);
                            $('#address').val(response.patient.address);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: `Patient Not Found`,
                                text: `Patient not found. Please continue with new patient entry.`,
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: `Error`,
                            text: `Error occurred while searching for patient please try again or add new customer.`,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            }
        });
    });
</script>

@endsection