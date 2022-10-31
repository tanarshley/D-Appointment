<!-- doctor Appointments -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Doctor | Appointments</title>
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
                <a href = "{{ route('doctor.dashboard') }}" class="nav-link" id="v-pills-home-tab" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Dashboard</a>
                <a href="{{ route('doctor.appointments') }}" class="nav-link active" id="v-pills-appointments-tab" type="button" role="tab" aria-controls="v-pills-appointments" aria-selected="false">Appointments</a>
                <a href="{{ route('doctor.history') }}" class="nav-link" id="v-pills-history-tab" type="button" role="tab" aria-controls="v-pills-history" aria-selected="false">History</a>
                <a href="{{ route('doctor.profile') }}" class="nav-link" id="v-pills-profile-tab" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                <a href="{{ route('doctor.settings') }}" class="nav-link" id="v-pills-settings-tab" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-appointments" role="tabpanel" aria-labelledby="v-pills-appointments-tab" tabindex="0">
                    <div class="row">
                        <div class="col">
                            <h3 style="padding: 10px;">Your Appointments</h3>
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

                    <div class="container" style="padding: 10px;">
                        <h3>Appointments</h3>
                        <table class="table table-bordered text-center">
                            <thead style="background-color: #0E86D4; color: white; border-bottom: none;">
                                <tr>
                                    <th>Appointment ID</th>
                                    <th>Patient ID</th>
                                    <th>Patient Name</th>
                                    <th>Appointment Date</th>
                                    <th>Appointment Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($allAppointments as $allAppointment)
                                <tr>
                                    <td>{{ $allAppointment->appointment_id }}</td>
                                    <td>{{ $allAppointment->patient_id }}</td>
                                    <td>{{ $allAppointment->patient_name }}</td>
                                    <td>{{ $allAppointment->appointment_date }}</td>
                                    <td>{{ date('h:i A', strtotime($allAppointment->appointment_time)) }}</td>
                                    <td>{{ $allAppointment->appointment_status }}</td>
                                    <td>
                                        <!-- view appointment -->
                                        @if($allAppointment->appointment_status == 'pending')
                                            <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmAppointment{{ $allAppointment->appointment_id }}">Confirm Request</a>
                                        @endif
                                        @if($allAppointment->appointment_status == 'confirmed')
                                            <a type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#viewPatientAppointment{{ $allAppointment->appointment_id }}">View</a>
                                            <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#doneAppointment{{ $allAppointment->appointment_id }}">Done</a>
                                        @endif
                                    </td>
                                </tr>

                                 <!--  View Doctor Patient Appointment Modal -->
                                 <div class="modal fade" id="confirmAppointment{{ $allAppointment->appointment_id }}" tabindex="-1" aria-labelledby="confirmAppointmentLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmAppointmentLabel">{{ $allAppointment->patient_name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('doctor.confirmAppointmentRequest', $allAppointment->appointment_id) }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="patient_name">Patient Name</label>
                                                        <input type="text" class="form-control" id="patient_name" name="patient_name" value="{{ $allAppointment->patient_name }}" readonly>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 12px;">
                                                        <label for="appointment_date">Appointment date</label>
                                                        <input type="date" class="form-control" id="date" name="appointment_date" value="{{ $allAppointment->appointment_date }}" readonly>
                                                    </div>

                                                    <div class="form-group" style="margin-top: 12px;">
                                                        <label for="appointment_time">Appointment time</label>
                                                        <input type="time" class="form-control" id="time" name="appointment_time" value="{{ $allAppointment->appointment_time }}" readonly>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 12px;">
                                                        <label for="appointment_status">Appointment status</label>
                                                        <input type="text" class="form-control" id="appointment_status" name="appointment_status" value="{{ $allAppointment->appointment_status }}" readonly>
                                                    </div>
                                                    <hr>
                                                    <button type="submit" class="btn btn-primary float-end" data-bs-dismiss="modal"  style="margin-top: 12px;">Confirm</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--  View Doctor Patient Appointment Modal -->
                                <div class="modal fade" id="viewPatientAppointment{{ $allAppointment->appointment_id }}" tabindex="-1" aria-labelledby="viewAppointmentLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewAppointmentLabel">{{ $allAppointment->patient_name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('doctor.confirmAppointmentRequest', $allAppointment->appointment_id) }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="patient_name">Patient Name</label>
                                                        <input type="text" class="form-control" id="patient_name" name="patient_name" value="{{ $allAppointment->patient_name }}" readonly>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 12px;">
                                                        <label for="appointment_date">Appointment date</label>
                                                        <input type="date" class="form-control" id="date" name="appointment_date" value="{{ $allAppointment->appointment_date }}" readonly>
                                                    </div>

                                                    <div class="form-group" style="margin-top: 12px;">
                                                        <label for="appointment_time">Appointment time</label>
                                                        <input type="time" class="form-control" id="time" name="appointment_time" value="{{ $allAppointment->appointment_time }}" readonly>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 12px;">
                                                        <label for="appointment_status">Appointment status</label>
                                                        <input type="text" class="form-control" id="appointment_status" name="appointment_status" value="{{ $allAppointment->appointment_status }}" readonly>
                                                    </div>
                                                    <hr>
                                                    <button type="button" class="btn btn-dark float-end" data-bs-dismiss="modal"  style="margin-top: 12px;">Close</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--  View Doctor Patient done Appointment Modal -->
                                <div class="modal fade" id="doneAppointment{{ $allAppointment->appointment_id }}" tabindex="-1" aria-labelledby="doneAppointmentLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="doneAppointmentLabel">{{ $allAppointment->patient_name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('doctor.doneAppointment', $allAppointment->appointment_id) }}" method="POST">
                                                    @csrf
                                                    <input type="text" name="patient_id" value="{{ $allAppointment->patient_id }}" hidden>
                                                    <input type="text" name="doctor_id" value="{{ $allAppointment->doctor_id }}" hidden>
                                                    <input type="text" name="doctor_name" value="{{ $allAppointment->doctor_name }}" hidden>

                                                    <div class="form-group">
                                                        <label for="patient_name">Patient Name</label>
                                                        <input type="text" class="form-control" id="patient_name" name="patient_name" value="{{ $allAppointment->patient_name }}" readonly>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 12px;">
                                                        <label for="appointment_date">Appointment date</label>
                                                        <input type="date" class="form-control" id="date" name="appointment_date" value="{{ $allAppointment->appointment_date }}" readonly>
                                                    </div>

                                                    <div class="form-group" style="margin-top: 12px;">
                                                        <label for="appointment_time">Appointment time</label>
                                                        <input type="time" class="form-control" id="time" name="appointment_time" value="{{ $allAppointment->appointment_time }}" readonly>
                                                    </div>
                                                    <div class="form-group" style="margin-top: 12px;">
                                                        <label for="appointment_status">Appointment status</label>
                                                        <input type="text" class="form-control" id="appointment_status" name="appointment_status" value="{{ $allAppointment->appointment_status }}" readonly>
                                                    </div>

                                                    <div class="form-group" style="margin-bottom: 12px; margin-top: 12px;">
                                                        <label for="exampleFormControlTextarea1">Remarks</label>
                                                        <textarea class="form-control" name="remarks" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                    </div>
                                                    <hr>
                                                    <button type="submit" class="btn btn-success float-end" style="margin-top: 12px;">Mark as done</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @include('cdn.js')
    </body>
<html>
