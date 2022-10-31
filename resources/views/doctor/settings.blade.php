<!-- doctor settings -->
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
    <body>

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
                <a href="{{ route('doctor.profile') }}" class="nav-link" id="v-pills-profile-tab" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                <a href="{{ route('doctor.settings') }}" class="nav-link active" id="v-pills-settings-tab" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>

            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">
                    <div class="row">
                        <div class="col">
                            <h3 style="padding: 10px;">Account Settings</h3>
                        </div>

                        <div class="col" style="padding: 10px; position: absolute; float: right; left:77.3%; top: -10px;">
                            <p style="font-size: 20px; margin-top: 8px;">Hello, Dr. {{ $LoggedDoctor->doctor_name }}
                                <a href = "{{ route('doctor.logout') }}" class="btn btn-outline-danger"
                                    style="position: relative; top: 12%; margin-left: 12px; padding: 10px;">Logout
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="container" style="padding: 10px;width: 200%; height: auto;">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="width: 65%; margin-left: 14%;">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="width: 65%; margin-left: 14%;">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('pictureUpdated'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="width: 65%; margin-left: 14%;">
                                {{ session('pictureUpdated') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('errorUpload'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="width: 65%; margin-left: 14%;">
                                {{ session('errorUpload') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('passwordUpdated'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="width: 65%; margin-left: 14%;">
                                {{ session('passwordUpdated') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('incorrectOldPassword'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="width: 65%; margin-left: 14%;">
                                {{ session('incorrectOldPassword') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <!-- card for personal information input-->
                        <div class="card" style="width: 50rem; margin-left: 16%;">
                            <div class="card-body">
                                <h5 class="card-title">Personal Information</h5>

                                <form action="{{ route('doctor.updateDoctorInformation', $LoggedDoctor->doctor_id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="doctor_name" style="margin-bottom: 4px; font-weight: 500;">Name</label>
                                        <input type="text" style="margin-bottom: 12px;" class="form-control {{ $errors->has('doctor_name') ? 'is-invalid' : '' }}" id="doctor_name" name="doctor_name" value="{{ $LoggedDoctor->doctor_name }}">
                                        @if($errors->has('doctor_name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('doctor_name') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="doctor_email" style="margin-bottom: 4px; font-weight: 500;">Email</label>
                                        <input type="email" style="margin-bottom: 12px;" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="doctor_email" name="doctor_email" value="{{ $LoggedDoctor->doctor_email }}">
                                        @if($errors->has('doctor_email'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('doctor_email') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group" style="margin-bottom: 4px; font-weight: 500;">
                                        <label for="doctor_phone" style="margin-bottom: 4px;">Phone</label>
                                        <input type="text" style="margin-bottom: 12px;" class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" id="doctor_phone" name="doctor_phone" value="{{ $LoggedDoctor->doctor_phone }}">
                                        @if($errors->has('doctor_phone'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('doctor_phone') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group" style="margin-bottom: 4px; font-weight: 500;">
                                        <label for="doctor_speciality" style="margin-bottom: 4px;">Specialization</label>
                                        <input type="text" style="margin-bottom: 12px;" class="form-control {{ $errors->has('doctor_speciality') ? 'is-invalid' : '' }}" id="doctor_speciality" name="doctor_speciality" value="{{ $LoggedDoctor->doctor_speciality }}">
                                        @if($errors->has('doctor_speciality'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('doctor_speciality') }}
                                            </div>
                                        @endif
                                    </div>

                                    <button type="submit" class="btn btn-primary col-4 float-end" style="margin-top: 12px;">Update information</button>
                                </form>
                            </div>
                        </div>

                        <!-- card for image upload -->
                        <div class="card" style="width: 50rem; margin-left: 16%; margin-top: 3%;">
                            <div class="card-body">
                                <h5 class="card-title">Upload Image</h5>
                                <form action="{{ route('doctor.updateDoctorPicture', $LoggedDoctor->doctor_id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="doctor_picture" style="margin-bottom: 4px; font-weight: 500;">Select Picture</label>
                                        <input type="file" style="margin-bottom: 12px;" class="form-control" id="doctor_picture" name="doctor_picture">
                                    </div>
                                    <button type="submit" class="btn btn-primary col-4 float-end" style="margin-top: 12px;">Upload</button>
                                </form>
                            </div>
                        </div>

                        <!-- card for change password input -->
                        <div class="card" style="width: 50rem; margin-left: 16%; margin-top: 3%;">
                            <div class="card-body">
                                <h5 class="card-title">Change Password</h5>
                                <form action="{{ route('doctor.updateDoctorPassword', $LoggedDoctor->doctor_id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="old_password" style="font-weight: 500;">Old Password</label>
                                        <input type="password" class="form-control {{ $errors->has('old_password') ? 'is-invalid' : '' }}" id="old_password" name="old_password">
                                        @if($errors->has('old_password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('old_password') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password" style="margin-top: 8px; font-weight: 500;">New Password</label>
                                        <input type="password" class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}" id="new_password" name="new_password">
                                        @if($errors->has('new_password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('new_password') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password" style="margin-top: 8px; font-weight: 500;">Confirm Password</label>
                                        <input type="password" class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}" id="confirm_password" name="confirm_password">
                                        @if($errors->has('confirm_password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('confirm_password') }}
                                            </div>
                                        @endif
                                    </div>

                                    <button type="submit" class="btn btn-primary col-4 float-end" style="margin-top: 12px;">Update password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('cdn.js')
    </body>
<html>
