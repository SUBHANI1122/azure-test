@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f9f9f9;
    }

    .container {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .header {
        text-align: center;
        color: #004085;
    }

    .sub-header {
        font-weight: bold;
        color: #888;
        margin-bottom: 20px;
    }

    .doctor-info-section {
        display: flex;
        justify-content: space-around;
        align-items: flex-start;
        margin: 0;
    }

    .doctor-info {

        text-align: center;
    }

    .doctor-info h2 {
        margin-bottom: 5px;
    }

    .doctor-info p {
        margin: 0;
    }

    .logo {
        text-align: center;
        width: 40%;
    }

    .logo img {
        width: 250px;
        height: auto;
    }

    .patient-info,
    .clinic-notes,
    .medicines,
    .lab-tests,
    .footer {
        margin: 20px 0;
    }

    .divider {
        margin: 20px 0;
        border-top: 2px solid #0056b3;
    }

    .footer {
        text-align: center;
        color: #555;
    }

    .patient-info {
        display: flex;
        justify-content: space-between;
    }

    .patient-info p {
        margin: 0;
        padding-right: 20px;
    }
</style>

<div class="container">
    <div class="header">
        <h1>Medical Care & Physiotherapy Clinic</h1>
        <div class="sub-header"><u>Not Valid For Court</u></div>
    </div>

    <div class="doctor-info-section">
        <div class="doctor-info">
            <h2>Dr Ayesha Afraz</h2>
            <p>MBBS, RMP, FCPS-1 C.M.H Hospital</p>
            <p>Medical care & Physiotherapy Clinic <br> 3pm to 11pm</p>
        </div>
        <div class="logo">
            <img src="{{ url('images/logo.png') }}" alt="Clinic Logo" style="height: 250px;">
        </div>
        <div class="doctor-info">
            <h2>Dr Afraz Ahmad</h2>
            <p>Consultant Physiotherapist DPT(UOS), MS.PPT</p>
            <p>City Hospital Commissioner Road <br> 12pm To 2pm</p>
            <p>Islam Central Hospital Commissioner Road <br> 2pm to 5pm</p>
            <p>Medical Care & Physiotherapy Clinic <br> 6pm to 11pm</p>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Patient Information Section -->
    <div class="patient-info">
        <h3>Patient Information</h3>
        <p><strong>Name:</strong> {{ $appointment->patient->name }}</p>
        <p><strong>Age:</strong> {{ $appointment->patient->age }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->translatedFormat('l, jS F Y') }}</p>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="clinic-notes">
                <h3>Clinic Notes</h3>
                @if ($appointment->clinicNotes)
                <p><strong>Diabetes Mellitus:</strong> {{ $appointment->clinicNotes->dm ? 'Yes' : 'No' }}</p>
                <p><strong>Hypertension:</strong> {{ $appointment->clinicNotes->ht ? 'Yes' : 'No' }}</p>
                <p><strong>BP:</strong> {{ $appointment->clinicNotes->bp }}</p>
                <p><strong>Presenting Complaint:</strong> {{ $appointment->clinicNotes->pc }}</p>
                @else
                <p>No clinic notes available for this appointment.</p>
                @endif
            </div>
            <div class="lab-tests">
                <h3>Investigation</h3>
                <ul>
                    @foreach($appointment->labTests as $test)
                    <li>{{ $test->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="medicines">
                    <h3>Medicines</h3>
                    <table class="table">
                        <tr>
                            <th></th>
                            <th>Medicine</th>
                            <th>Dosage</th>
                            <th>Days</th>
                        </tr>
                        @foreach($appointment->medicines as $index => $medicine)
                        <tr>
                            <th>{{ $index + 1 }}</th>
                            <td>{{ $medicine->name }} - {{ $medicine->size }}</td>
                            <td>
                                @if($medicine->meal_timing == 'Before')
                                کھانے سے پہلے
                                @elseif($medicine->meal_timing == 'After')
                                کھانے کے بعد
                                @else
                                N/A
                                @endif
                                <br>
                                @if($medicine->morning)
                                صبح/
                                @endif
                                @if($medicine->afternoon)
                                دوپہر/
                                @endif
                                @if($medicine->evening)
                                شام
                                @endif
                            </td>
                            <td>دن کی خوراک {{ $medicine->pivot->days }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="row">
                <div>
                    <h3>Prescriptions</h3>
                    <ul>
                        @foreach($appointment->prescriptions as $index => $prescription)
                        <li>{{ $prescription->instructions ?: 'No instructions provided.' }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Footer Section -->
    <div class="footer">
        <p>Clinic Address: 123 Clinic Street, Health City</p>
        <p>Phone: (123) 456-7890</p>
    </div>
</div>
@endsection