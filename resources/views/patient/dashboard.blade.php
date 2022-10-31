<!-- patient appointments -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Patient | Appointments</title>
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
                <a href = "{{ route('patient.dashboard') }}" class="nav-link active" id="v-pills-home-tab" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Appointments</a>
                <a href="{{ route('patient.appointment') }}" class="nav-link" id="v-pills-create-tab" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Set Appointment</a>
                <a href="{{ route('patient.history') }}" class="nav-link" id="v-pills-history-tab" type="button" role="tab" aria-controls="v-pills-history" aria-selected="false">History</a>
                <a href="{{ route('patient.doctors') }}" class="nav-link" id="v-pills-doctors-tab"  type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Doctors</a>
                <a href="{{ route('patient.profile') }}" class="nav-link" id="v-pills-profile-tab" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Profile</a>
                <a href="{{ route('patient.settings') }}" class="nav-link" id="v-pills-settings-tab" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                    <div class="row">
                        <div class="col">
                            <h3 style="padding: 10px;">Your Appointments</h3>
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
                        <table class="table table-striped text-center" style="width: 100%; margin-top: 20px;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Doctor Name</th>
                                    <th scope="col">Appointment Date</th>
                                    <th scope="col">Appointment Time</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($getAppointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->appointment_id }}</td>
                                        <td>{{ $appointment->doctor_name }}</td>
                                        <td>{{ $appointment->appointment_date }}</td>
                                        <td>{{ date('h:i A', strtotime($appointment->appointment_time))}}</td>
                                        <td>{{ $appointment->appointment_status }}</td>
                                        <td>
                                            @if($appointment->appointment_status == 'pending')
                                                <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelAppointment{{ $appointment->appointment_id }}">Cancel</a>
                                                <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateAppointment{{ $appointment->appointment_id }}">View</a>
                                            @endif
                                            @if($appointment->appointment_status == 'confirmed')
                                                <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewAppointment{{ $appointment->appointment_id }}">View Appointment</a>
                                            @endif
                                        </td>
                                    </tr>

        <!--  view Appointment Modal -->
        <div class="modal fade" id="viewAppointment{{ $appointment->appointment_id }}" tabindex="-1" aria-labelledby="viewAppointmentLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewAppointmentLabel">Appoinment to Dr. {{ $appointment->doctor_name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="alert alert-info" role="alert">
                                <strong>Reminder:</strong> Please arrived at the clinic at least 10 minutes before the appointment time, Thank you.
                            </div>
                                <input type="text" value="{{ $appointment->doctor_id }}" name="doctor_id" hidden>

                                <div class="form-group">
                                    <label for="doctor_name">Selected Doctor</label>
                                    <input type="text" class="form-control" id="doctor_name" name="doctor_name" value="{{ $appointment->doctor_name }}" readonly>
                                </div>
                                <div class="form-group" style="margin-top: 12px;">
                                    <label for="appointment_date">Appointment date</label>
                                    <input type="date" class="form-control" id="date" name="appointment_date" value="{{ $appointment->appointment_date }}" readonly>
                                </div>

                                <div class="form-group" style="margin-top: 12px;">
                                    <label for="appointment_time">Current time</label>
                                    <input type="time" class="form-control" id="time" name="appointment_time" value="{{ $appointment->appointment_time }}" readonly>
                                </div>
                                <div class="form-group" style="margin-top: 12px;">
                                    <label for="appointment_status">Appointment status</label>
                                    <input type="text" class="form-control" id="appointment_status" name="appointment_status" value="{{ $appointment->appointment_status }}" readonly>
                                </div>
                                <div class="alert alert-warning" role="alert" style="margin-top: 12px;">
                                    <strong>Note:</strong> Going to the clinic 25 minutes late will be considered as cancelled appointment.
                                </div>
                                <hr>
                            <button type="button" class="btn btn-light float-end" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--  update Appointment Modal -->
            <div class="modal fade" id="updateAppointment{{ $appointment->appointment_id }}" tabindex="-1" aria-labelledby="updateAppointmentLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateAppointmentLabel">Appoinment to {{ $appointment->doctor_name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('patient.updateAppointmentProcess', $appointment->appointment_id) }}" method="POST">
                                @csrf

                                <input type="text" value="{{ $appointment->doctor_id }}" name="doctor_id" hidden>

                                <div class="form-group">
                                    <label for="doctor_name">Selected Doctor</label>
                                    <input type="text" class="form-control" id="doctor_name" name="doctor_name" value="{{ $appointment->doctor_name }}" readonly>
                                </div>
                                <div class="form-group" style="margin-top: 12px;">
                                    <label for="appointment_date">Appointment Date</label>
                                    <input type="date" class="form-control" id="date" name="appointment_date" value="{{ $appointment->appointment_date }}">
                                </div>

                                <div class="form-group" style="margin-top: 12px;">
                                    <label for="appointment_time">Current Time</label>
                                    <input type="time" class="form-control" id="time" name="appointment_time" value="{{ $appointment->appointment_time }}" readonly>
                                </div>

                                <div class="form-group" style="margin-top: 12px;">
                                    <p>Choose time</p>
                                    <div class="row">
                                        <div class="col">
                                            <p>Morning</p>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="appointment_time" id="time1" value="9:00:00" required>
                                                <label class="form-check-label" for="time1">
                                                    09:00 - 10:00
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="appointment_time" id="time2" value="10:00:00" required>
                                                <label class="form-check-label" for="time2">
                                                    10:00 - 11:00
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="appointment_time" id="time3" value="11:00:00" required>
                                                <label class="form-check-label" for="time3">
                                                    11:00 - 12:00
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <p>Afternoon</p>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="appointment_time" id="time4" value="12:00:00" required>
                                                <label class="form-check-label" for="time4">
                                                    13:00 - 14:00
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="appointment_time" id="time5" value="13:00:00" required>
                                                <label class="form-check-label" for="time5">
                                                    14:00 - 15:00
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="appointment_time" id="time6" value="14:00:00" required>
                                                <label class="form-check-label" for="time6">
                                                    15:00 - 16:00
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: 12px;">
                                    <label for="appointment_status">Appointment Status</label>
                                    <input type="text" class="form-control" id="appointment_status" name="appointment_status" value="{{ $appointment->appointment_status }}" readonly>
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-primary float-end" style="margin-top: 12px;">Update Appointment</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="cancelAppointment{{ $appointment->appointment_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cancel Appointment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('patient.cancelAppointmentProcess', $appointment->appointment_id) }}" method="POST">
                                @csrf

                                <input type="hidden" name="appointment_id" value="{{ $appointment->appointment_id }}">
                                <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                                <input type="hidden" name="doctor_id" value="{{ $appointment->doctor_id }}">
                                <input type="hidden" name="appointment_date" value="{{ $appointment->appointment_date }}">
                                <input type="hidden" name="appointment_time" value="{{ $appointment->appointment_time }}">
                                <input type="hidden" name="appointment_status" value="{{ $appointment->appointment_status }}">

                                <!--reasons selection radio button-->
                                <div class="form-group">
                                    <label for="reason" style="margin-bottom: 12px;">Please select a reason for cancelling the appointment.</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="reason" id="reason" value="Not Available">
                                        <label class="form-check-label" for="reason">Not Available</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="reason" id="reason" value="Not Interested">
                                        <label class="form-check-label" for="reason">Not Interested</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="reason" id="reason" value="Not Interested">
                                        <label class="form-check-label" for="reason">Emergency</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="reason" id="reason" value="Not Interested">
                                        <label class="form-check-label" for="reason">Important matters</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="reason" id="reason" value="Others">
                                        <label class="form-check-label" for="reason">Others</label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 12px; margin-top: 12px;">
                                    <label for="exampleFormControlTextarea1">If Others. Please specify your short reason below.</label>
                                    <textarea class="form-control" name="specify_reason" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger float-end">Cancel Appointment</button>
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
        <script>
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!
            var yyyy = today.getFullYear();

            if(dd<10){
                dd='0'+dd
            }
            if(mm<10){
                mm='0'+mm
            }
            today = yyyy+'-'+mm+'-'+dd;
            document.getElementById("date").setAttribute("min", today);

            var nextMonth = new Date();
            nextMonth.setMonth(nextMonth.getMonth() + 1);
            var dd = nextMonth.getDate();
            var mm = nextMonth.getMonth()+1; //January is 0!
            var yyyy = nextMonth.getFullYear();
            if(dd<10){
                dd='0'+dd
            }
            if(mm<10){
                mm='0'+mm
            }
            nextMonth = yyyy+'-'+mm+'-'+dd;
            document.getElementById("date").setAttribute("max", nextMonth);
        </script>
    </body>
<html>
