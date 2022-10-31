<!-- patient doctors -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Patient | History</title>
        <!-- link app.css from public folder -->
        @include('cdn.bootstrap')
    </head>
    <body style="overflow: hidden;">

        <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="background-color: rgb(250, 250, 250); height: 75em; padding: 6px; width: 12%;">
                <div class="picture" style="margin-left: 0px;">
                    @if($LoggedPatient->profile_picture == "default-avatar.png")
                        <a href="{{ route('patient.profile') }}"><img src="{{ asset($LoggedPatient->profile_picture) }}" class="img-fluid" alt="{{ $LoggedPatient->name }} photo"  style="width: 110px; height: 110px; border-radius: 50%; margin-bottom: 12px; margin-left: 14%;"></a>
                        @else
                        <a href="{{ route('patient.profile') }}"><img src="{{ asset('/uploads/patients/'.$LoggedPatient->profile_picture) }}" class="img-fluid" alt="{{ $LoggedPatient->name }} photo" style="width: 110px; height: 110px; border-radius: 50%; margin-bottom: 12px; margin-left: 14%;"></a>
                    @endif
                </div>
                <a href = "{{ route('patient.dashboard') }}" class="nav-link" id="v-pills-home-tab" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Appointments</a>
                <a href="{{ route('patient.appointment') }}" class="nav-link" id="v-pills-create-tab" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Set Appointment</a>
                <a href="{{ route('patient.history') }}" class="nav-link active" id="v-pills-history-tab" type="button" role="tab" aria-controls="v-pills-history" aria-selected="false">History</a>
                <a href="{{ route('patient.doctors') }}" class="nav-link" id="v-pills-doctors-tab"  type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Doctors</a>
                <a href="{{ route('patient.profile') }}" class="nav-link" id="v-pills-profile-tab" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Profile</a>
                <a href="{{ route('patient.settings') }}" class="nav-link" id="v-pills-settings-tab" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-create" role="tabpanel" aria-labelledby="v-pills-create-tab" tabindex="0">
                    <div class="row">
                        <div class="col">
                            <h3 style="padding: 10px;">Appointment History</h3>
                        </div>

                        <div class="col" style="padding: 10px; position: absolute; float: right; left:77.3%; top: -10px;">
                            <p style="font-size: 20px; margin-top: 8px;">Hello, {{ $LoggedPatient->name }}
                                <a href = "{{ route('patient.logout') }}" class="btn btn-outline-danger"
                                    style="position: relative; top: 12%; margin-left: 12px; padding: 10px;">Logout
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="container" style="width: 180%;">
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

                        <div class="alert alert-info" role="alert">
                            <strong>Notice:</strong> Cancelled appointments will all be deleted after 5 days.
                        </div>
                        <table class="table table-striped">
                            <thead style="text-align:center;">
                                <tr>
                                    <th scope="col">Appointment #</th>
                                    <th scope="col">Doctor</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Cancellation Reason</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Others</th>
                                </tr>
                            </thead>
                            <tbody style="text-align:center;">
                                @foreach($getAppointments as $getAllMyAppointment)
                                <tr>
                                    <td>{{ $getAllMyAppointment->appointment_id }}</td>
                                    <td>{{ $getAllMyAppointment->doctor_name }}</td>
                                    <td>{{ $getAllMyAppointment->appointment_date }}</td>
                                    <td>{{ date('h:i A', strtotime($getAllMyAppointment->appointment_time))}}</td>
                                    <td>{{ $getAllMyAppointment->appointment_status }}</td>

                                    @if($getAllMyAppointment->appointment_status == 'cancelled')
                                        <td>{{ $getAllMyAppointment->reason }}</td>
                                    @endif

                                    @if($getAllMyAppointment->appointment_status == 'done')
                                        <td>{{ $getAllMyAppointment->reason = 'N/A' }}</td>
                                    @endif


                                    @if($getAllMyAppointment->appointment_status == 'cancelled' && $getAllMyAppointment->specify_reason == null)
                                        <td>{{ $getAllMyAppointment->remarks = 'N/A' }}</td>
                                        <td>N/A</td>
                                    @endif

                                    @if($getAllMyAppointment->appointment_status == 'cancelled' && $getAllMyAppointment->specify_reason != null)
                                        <td>{{ $getAllMyAppointment->specify_reason }}</td>
                                    @endif

                                    @if($getAllMyAppointment->appointment_status == 'done' && $getAllMyAppointment->remarks == null)
                                        <td>N/A</td>
                                        <td>{{ $getAllMyAppointment->reason = 'N/A' }}</td>
                                    @endif

                                    @if($getAllMyAppointment->appointment_status == 'done' && $getAllMyAppointment->remarks != null)
                                        <td>{{ $getAllMyAppointment->remarks }}</td>
                                        <td>{{ $getAllMyAppointment->reason = 'N/A' }}</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

        @include('cdn.js')
    </body>
<html>
