@extends('layouts.form')
@section('content')
<style>
    .header-banner {
        padding: 20px 0;
    }

    .container-fluid {
        padding: 0;
        margin: 0;
    }

    .footer-section {
        padding: 20px 0;
        background-color: #88cceb;
    }

    .social-links {
        margin-right: 10px;
    }

</style>
<div class="parent-section">
    {{-- <div class="container-fluid px-0 bg-color position-fixed top-0">
        <!-- Header Section -->
        <div class="row d-flex align-items-center py-2 header-section">
            <div class="col-12 col-md-5 col-lg-4">
                <h2 class="text-center text-md-start mt-0 mb-0 text-white ps-4">Medical Care & Physiotherapy Clinic FC</h2>
            </div>
            <div class="col-12 col-md-7 col-lg-8">
                <h2 class="text-center text-md-end text-white mt-0 mb-0 header-bottom pe-4">
                    Email us at <a href="mailto:hello@cloverunited.ie" class="text-white text-decoration-none"
                        style="font-size: 14px">hello@cloverunited.ie</a> for more information
                </h2>
            </div>
        </div>
        <div class="container py-4 px-0 bg-">
            <div class="row d-flex align-items-center">
                <div class="col-3">
                    <a href="{{ route('bookingForm') }}">
                        <img src="{{ asset('images/logo.png') }}" class="img-fluid header-logo" width="111"
                            height="111" alt="logo image">
                    </a>
                </div>
                <div class="col-5">
                    <div class="text-header">
                        <h2 class="text-center text-white mt-3 mb-0 company-name fw-semibold">
                            Medical Care & Physiotherapy Clinic Membership
                        </h2>
                    </div>
                </div>
                <div class="col-4 text-end">
                    <a href="https://www.fai.ie/" target="_blank">
                        <img src="{{ asset('images/FAI-Crest_0.png') }}" class="img-fluid header-logo" width="111"
                            height="111" alt="logo image">
                    </a>
                    <a href="https://kkleague.com/homepage.aspx?oid=1028" target="_blank">
                        <img src="{{ asset('images/kilkenylogo.png') }}" class="img-fluid header-logo" width="111"
                            height="111" alt="logo image">
                    </a>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="conatiner-fluid booking-formsection1 py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="text-center bg-white" style="padding: 80px 0">
                        <div class="mb-4 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="75" height="75"
                                fill="#88cceb" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z">
                                </path>
                            </svg>
                        </div>
                        <div class="col-12">
                            <p class="text-center text-color mb-0">Thank you for your support and joining Medical Care & Physiotherapy Clinic.
                            </p>
                            <p class="text-center text-color mb-0">You will receive an email receipt shortly confirming
                                details.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="container-fluid footer-section position-fixed bottom-0">
        <div class="row">
            <div class="col-12 text-center">
                <a href="https://www.facebook.com/Clover-Utd-Rathdowney-966280610059539" target="_blank"
                    class="social-links">
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
                <p class="text-white mt-3" style="font-size: 14px; line-height: 35px;">©2024 Medical Care & Physiotherapy Clinic</p>
            </div>
        </div>
    </div> --}}
</div>
@endsection