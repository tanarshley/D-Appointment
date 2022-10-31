<!-- doctor dashboard -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Doctor | Dashboard</title>
        <!-- link app.css from public folder -->
        @include('cdn.bootstrap')
    </head>
    <body style="overflow: hidden;">

        <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="background-color: rgb(250, 250, 250); height: 75em; padding: 6px; width: 10%;">
                <div class="picture" style="margin-left: 12px;">
                    @if($LoggedDoctor->doctor_picture == "default-avatar.png")
                        <a href="{{ route('doctor.profile') }}"><img src="{{ asset($LoggedDoctor->doctor_picture) }}" class="img-fluid" alt="{{ $LoggedDoctor->doctor_name }} photo"  style="width: 110px; height: 110px; border-radius: 50%; margin-bottom: 12px;"></a>
                        @else
                        <a href="{{ route('doctor.profile') }}"><img src="{{ asset('/uploads/doctors/'.$LoggedDoctor->doctor_picture) }}" class="img-fluid" alt="{{ $LoggedDoctor->doctor_name }} photo" style="width: 110px; height: 110px; border-radius: 50%; margin-bottom: 12px;"></a>
                    @endif
                </div>
                <a href = "{{ route('doctor.dashboard') }}" class="nav-link active" id="v-pills-home-tab" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Dashboard</a>
                <a href="{{ route('doctor.appointments') }}" class="nav-link" id="v-pills-appointments-tab" type="button" role="tab" aria-controls="v-pills-appointments" aria-selected="false">Appointments</a>
                <a href="{{ route('doctor.history') }}" class="nav-link" id="v-pills-history-tab" type="button" role="tab" aria-controls="v-pills-history" aria-selected="false">History</a>
                <a href="{{ route('doctor.profile') }}" class="nav-link" id="v-pills-profile-tab" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                <a href="{{ route('doctor.settings') }}" class="nav-link" id="v-pills-settings-tab" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                    <div class="row">
                        <div class="col">
                            <h3 style="padding: 10px;">Appointments Summary</h3>
                        </div>

                        <div class="col" style="padding: 10px; position: absolute; float: right; left:77.3%; top: -10px;">
                            <p style="font-size: 20px; margin-top: 8px;">Hello, Dr. {{ $LoggedDoctor->doctor_name }}
                                <a href = "{{ route('doctor.logout') }}" class="btn btn-outline-danger"
                                    style="position: relative; top: 12%; margin-left: 12px; padding: 10px;">Logout
                                </a>
                            </p>
                        </div>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="container" style="padding: 10px; width: 300rem;">
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-header" style="background-color: #0E86D4; color: white; border-bottom: none;">
                                        <h5>Total</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>{{ $totalPatients }}</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card">
                                    <div class="card-header" style="background-color: #0E86D4; color: white; border-bottom: none;">
                                        <h5>Today</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>{{ $todaysAppointment }}</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card">
                                    <div class="card-header" style="background-color: #0E86D4; color: white; border-bottom: none;">
                                        <h5>Confirmed</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>{{ $confirmedAppointments }}</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card">
                                    <div class="card-header" style="background-color: #0E86D4; color: white; border-bottom: none;">
                                        <h5>Done</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>{{ $successAppointments }}</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card">
                                    <div class="card-header" style="background-color: #0E86D4; color: white; border-bottom: none;">
                                        <h5>Pending</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>{{ $pendingAppointments }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <!-- latest appointments -->
                        <div class="row" style="margin-top: 24px;">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <h3 style="padding: 10px;">Latest sessions</h3>
                                    </div>
                                    <div class="col">
                                        <a href="{{ route('doctor.appointments') }}" class="btn btn-outline-primary float-end" style="margin-top: 10px;">View All</a>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead style="background-color: #0E86D4; color: white; border-bottom: none;">
                                        <tr>
                                            <th style="display: none;">#</th>
                                            <th style="display: none;">p#</th>
                                            <th>Patient</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($latestAppointments as $appointment)
                                            <tr>
                                                <td style="display: none;">{{ $appointment->appointment_id }}</td>
                                                <td style="display: none;">{{ $appointment->patient_id }}</td>
                                                <td>{{ $appointment->patient_name }}</td>
                                                <td>{{ date('M d, Y', strtotime($appointment->appointment_date)) }}</td>
                                                <td>{{ date('h:i A', strtotime($appointment->appointment_time)) }}</td>
                                                <td>{{ $appointment->appointment_status }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- appointments history -->
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <h3 style="padding: 10px;">Done sessions</h3>
                                    </div>
                                    <div class="col">
                                        <a href="{{ route('doctor.appointments') }}" class="btn btn-outline-primary float-end" style="margin-top: 10px;">View All</a>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead style="background-color: #0E86D4; color: white; border-bottom: none;">
                                        <tr>
                                            <th style="display: none;">#</th>
                                            <th style="display: none;"> p#</th>
                                            <th>Patient</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($doneAppointments as $doneAppointment)
                                            <tr>
                                                <td style="display: none;">{{ $doneAppointment->appointment_id }}</td>
                                                <td style="display: none;">{{ $doneAppointment->patient_id }}</td>
                                                <td>{{ $doneAppointment->patient_name }}</td>
                                                <td>{{ date('M d, Y', strtotime($doneAppointment->appointment_date)) }}</td>
                                                <td>{{ date('h:i A', strtotime($doneAppointment->appointment_time)) }}</td>
                                                <td>{{ $doneAppointment->appointment_status }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('cdn.js')
    </body>
<html>
