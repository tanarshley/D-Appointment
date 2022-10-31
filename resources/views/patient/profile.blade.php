<!-- patient profile -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Patient | Profile</title>
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
                <a href="{{ route('patient.doctors') }}" class="nav-link" id="v-pills-doctors-tab"  type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Doctors</a>
                <a href="{{ route('patient.profile') }}" class="nav-link active" id="v-pills-profile-tab" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Profile</a>
                <a href="{{ route('patient.settings') }}" class="nav-link" id="v-pills-settings-tab" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
                    <div class="row" style="margin-left: 0px; margin-right: 0px; width: 110%;">
                        <div class="col">
                            <h3 style="padding: 10px;">Your Profile</h3>
                        </div>

                        <div class="col" style="width: 60.3em;">
                            <p style="font-size: 20px; margin-top: 8px;" class="float-end">Hello, {{ $LoggedPatient->name }}
                                <a href = "{{ route('patient.logout') }}" class="btn btn-outline-danger"
                                    style="position: relative; top: 12%; margin-left: 12px; padding: 10px;">Logout
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="container">
                        <div class="card" style="width: 110%;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <!-- get profile_pic from public folder -->
                                        @if($LoggedPatient->profile_picture == "default-avatar.png")
                                            <img src="{{ asset($LoggedPatient->profile_picture) }}" class="img-fluid" alt="{{ $LoggedPatient->name }} photo" style="width: 200px; height: 200px; border-radius: 50%; margin-bottom: 12px;">
                                            @else
                                            <img src="{{ asset('/uploads/patients/'.$LoggedPatient->profile_picture) }}" class="img-fluid" alt="{{ $LoggedPatient->name }} photo" style="width: 200px; height: 200px; border-radius: 50%; margin-bottom: 12px;">
                                        @endif
                                    </div>
                                    <div class="col-8">
                                        <div class="row">
                                            <div class="col">
                                                <h4 class="card-title">Personal Information</h4>
                                            </div>
                                            <div class="col">
                                                <a href="{{ route('patient.settings') }}" class="btn btn-outline-primary float-end" style="margin-top: -5px;"><i class="bi bi-pencil-square"></i>&nbsp; Edit Profile</a>
                                            </div>
                                        </div>

                                        <p class="card-title" style="font-size: 1.1rem;"><span style="font-weight: 500;">Name:</span> {{ $LoggedPatient->name }}</p>
                                        <p class="card-text" style="font-size: 1.1rem;"><span style="font-weight: 500;">Email:</span> {{ $LoggedPatient->email }}</p>
                                        <p class="card-text" style="font-size: 1.1rem;"><span style="font-weight: 500;">Birthdate:</span> {{ $LoggedPatient->date_of_birth }}</p>
                                        <p class="card-text" style="font-size: 1.1rem;"><span style="font-weight: 500;">Home Address:</span> {{ $LoggedPatient->address }}</p>
                                        <p class="card-text" style="font-size: 1.1rem;"><span style="font-weight: 500;">Phone:</span> {{ $LoggedPatient->phone_number }}</p>
                                        <p class="float-end" style="font-style: italic; color: gray;">
                                            Patient since {{ date('M d, Y', strtotime($LoggedPatient->created_at)) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('cdn.js')
    </body>
<html>
