<!-- doctor profile -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Doctor | Profile</title>
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
                <a href="{{ route('doctor.appointments') }}" class="nav-link" id="v-pills-appointments-tab" type="button" role="tab" aria-controls="v-pills-appointments" aria-selected="false">Appointments</a>
                <a href="{{ route('doctor.history') }}" class="nav-link" id="v-pills-history-tab" type="button" role="tab" aria-controls="v-pills-history" aria-selected="false">History</a>
                <a href="{{ route('doctor.profile') }}" class="nav-link active" id="v-pills-profile-tab" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                <a href="{{ route('doctor.settings') }}" class="nav-link" id="v-pills-settings-tab" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
                    <div class="row">
                        <div class="col">
                            <h3 style="padding: 10px;">Your Profile</h3>
                        </div>

                        <div class="col" style="padding: 10px; position: absolute; float: right; left:77.3%; top: -10px;">
                            <p style="font-size: 20px; margin-top: 8px;">Hello, Dr. {{ $LoggedDoctor->doctor_name }}
                                <a href = "{{ route('doctor.logout') }}" class="btn btn-outline-danger"
                                    style="position: relative; top: 12%; margin-left: 12px; padding: 10px;">Logout
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="container" style="padding: 10px;width: 270%; height: auto;">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <!-- get profile_pic from public folder -->
                                        @if($LoggedDoctor->doctor_picture == "default-avatar.png")
                                            <img src="{{ asset($LoggedDoctor->doctor_picture) }}" class="img-fluid" alt="{{ $LoggedDoctor->doctor_name }} photo" style="width: 184px; height: 184px; border-radius: 50%;">
                                            @else
                                            <img src="{{ asset('/uploads/doctors/'.$LoggedDoctor->doctor_picture) }}" class="img-fluid" alt="{{ $LoggedDoctor->doctor_name }} photo" style="width: 184px; height: 184px; border-radius: 50%;">
                                        @endif
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <h4 class="card-title">Personal Information</h4>
                                            </div>
                                            <div class="col">
                                                <a href="{{ route('doctor.settings') }}" class="btn btn-outline-primary float-end" style="margin-top: -5px;"><i class="bi bi-pencil-square"></i>&nbsp; Edit Profile</a>
                                            </div>
                                        </div>

                                        <p class="card-title" style="font-size: 1.1rem;"><span style="font-weight: 500;">Name:</span> {{ $LoggedDoctor->doctor_name }}</p>
                                        <p class="card-text" style="font-size: 1.1rem;"><span style="font-weight: 500;">Email:</span> {{ $LoggedDoctor->doctor_email }}</p>
                                        @if($LoggedDoctor->doctor_phone == null)
                                            <p class="card-text" style="font-size: 1.1rem;"><span style="font-weight: 500;">Phone:</span> <a href="{{ route('doctor.settings') }}" style="text-decoration: none;">+ Add your phone number</a></p>
                                        @else
                                        <p class="card-text" style="font-size: 1.1rem;"><span style="font-weight: 500;">Phone:</span> {{ $LoggedDoctor->doctor_phone }}</p>
                                        @endif
                                        <p class="card-text" style="font-size: 1.1rem;"><span style="font-weight: 500;">Specialization:</span> {{ $LoggedDoctor->doctor_speciality }}</p>
                                        <p class="float-end" style="font-style: italic; color: gray;">
                                            Patient since {{ date('M d, Y', strtotime($LoggedDoctor->created_at)) }}
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
