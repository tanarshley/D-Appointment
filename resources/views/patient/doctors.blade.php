<!-- patient doctors -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Patient | Doctors</title>
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
                <a href="{{ route('patient.history') }}" class="nav-link" id="v-pills-history-tab" type="button" role="tab" aria-controls="v-pills-history" aria-selected="false">History</a>
                <a href="{{ route('patient.doctors') }}" class="nav-link active" id="v-pills-doctors-tab"  type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Doctors</a>
                <a href="{{ route('patient.profile') }}" class="nav-link" id="v-pills-profile-tab" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Profile</a>
                <a href="{{ route('patient.settings') }}" class="nav-link" id="v-pills-settings-tab" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-doctors" role="tabpanel" aria-labelledby="v-pills-doctors-tab" tabindex="0">
                    <div class="row">
                        <div class="col">
                            <h3 style="padding: 10px;">Our Doctors</h3>
                        </div>

                        <div class="col" style="padding: 10px; position: absolute; float: right; left:77.3%; top: -10px;">
                            <p style="font-size: 20px; margin-top: 8px;">Hello, {{ $LoggedPatient->name }}
                                <a href = "{{ route('patient.logout') }}" class="btn btn-outline-danger"
                                    style="position: relative; top: 12%; margin-left: 12px; padding: 10px;">Logout
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="container">
                    <div class="row">
                            @foreach ($doctors as $doctor)
                                <div class="col">
                                    <div class="card text-center" style="width: 18rem;">
                                        @if($doctor->doctor_picture == "default-avatar.png")
                                            <a href="{{ route('patient.profile') }}" style="text-decoration: none;"><img src="{{ asset($doctor->doctor_picture) }}" class="img-fluid" alt="{{ $doctor->doctor_name }} photo" style="width: 110px; height: 110px; border-radius: 50%; margin-bottom: 12px; margin-top: 5%;">
                                        @else
                                            <a href="{{ route('patient.profile') }}" style="text-decoration: none;"><img src="{{ asset('/uploads/doctors/'.$doctor->doctor_picture) }}" class="img-fluid" alt="{{ $doctor->doctor_name }} photo" style="width: 110px; height: 110px; border-radius: 50%; margin-bottom: 12px; margin-top: 5%;"></a>
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">Dr. {{ $doctor->doctor_name }}</h5>
                                            <p class="card-text" style="margin-bottom: 14px;">{{ $doctor->doctor_speciality }}</p>
                                            <a type="button" class="btn btn-primary col-12" data-bs-toggle="modal" data-bs-target="#doctor{{ $doctor->doctor_id }}">
                                                View Profile
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal for doctor profile -->
                                <div class="modal fade" id="doctor{{ $doctor->doctor_id }}" tabindex="-1" role="dialog" aria-labelledby="doctor{{ $doctor->doctor_id }}Label"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="doctor{{ $doctor->doctor_id }}Label">Dr. {{ $doctor->doctor_name }}'s Profile</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col">
                                                        @if($doctor->doctor_picture == "default-avatar.png")
                                                        <img src="{{ asset($doctor->doctor_picture) }}" class="img-fluid" alt="{{ $doctor->doctor_name }} photo" style="width: 110px; height: 110px; border-radius: 50%; margin-bottom: 12px; margin-top: 5%;">
                                                    @else
                                                        <img src="{{ asset('/uploads/doctors/'.$doctor->doctor_picture) }}" class="img-fluid" alt="{{ $doctor->doctor_name }} photo" style="width: 70%; height: 70%; margin-left: 30px; margin-top: 20px; border">
                                                    @endif
                                                    </div>
                                                    <div class="col">
                                                        <label for="name">Name:</label>
                                                        <p id="name" style="font-weight: 500;">{{ $doctor->doctor_name }}</p>
                                                        <label for="email">Email:</label>
                                                        <p id="email" style="font-weight: 500;">{{ $doctor->doctor_email }}</p>
                                                        <label for="phone">Phone:</label>
                                                        <p id="phone" style="font-weight: 500;">{{ $doctor->doctor_phone }}</p>
                                                        <label for="specialize">Specialization:</label>
                                                        <p id="specialize" class="alert alert-info" style="padding: 4px; margin: 0; font-weight: 500;">{{ $doctor->doctor_speciality }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-light float-end" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('cdn.js')
    </body>
<html>
