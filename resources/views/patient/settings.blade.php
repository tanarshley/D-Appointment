<!-- patient settings -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Patient | Settings</title>
        <!-- link app.css from public folder -->
        @include('cdn.bootstrap')
    </head>
    <body>

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
                <a href="{{ route('patient.profile') }}" class="nav-link" id="v-pills-profile-tab" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Profile</a>
                <a href="{{ route('patient.settings') }}" class="nav-link active" id="v-pills-settings-tab" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">
                    <div class="row" style="width: 114%;">
                        <div class="col">
                            <h3 style="padding: 10px;">Account Settings</h3>
                        </div>

                        <div class="col" style="width: 56em;">
                            <p style="font-size: 20px; margin-top: 8px;" class="float-end">Hello, {{ $LoggedPatient->name }}
                                <a href = "{{ route('patient.logout') }}" class="btn btn-outline-danger"
                                    style="position: relative; top: 12%; margin-left: 12px; padding: 10px;">Logout
                                </a>
                            </p>
                        </div>
                    </div>
                     <div class="container" style="margin-left: 18%;">

                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="width: 80%; margin-left: -4%;">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="width: 80%; margin-left: -4%;">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('pictureUpdated'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="width: 80%; margin-left: -4%;">
                            {{ session('pictureUpdated') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if(session('errorUpload'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="width: 80%; margin-left: -4%;">
                                {{ session('errorUpload') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('passwordUpdated'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="width: 80%; margin-left: -4%;">
                            {{ session('passwordUpdated') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if(session('incorrectOldPassword'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="width: 80%; margin-left: -4%;">
                                {{ session('incorrectOldPassword') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <!-- card for personal information input-->
                        <div class="card" style="width: 50rem;">
                            <div class="card-body">
                                <h5 class="card-title">Personal Information</h5>
                                <form action="{{ route('patient.updateInformation', $LoggedPatient->patient_id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name" style="margin-bottom: 4px; font-weight: 500;">Name</label>
                                        <input type="text" style="margin-bottom: 12px;" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value="{{ $LoggedPatient->name }}">
                                        @if($errors->has('name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="email" style="margin-bottom: 4px; font-weight: 500;">Email</label>
                                        <input type="email" style="margin-bottom: 12px;" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" value="{{ $LoggedPatient->email }}">
                                        @if($errors->has('email'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group" style="margin-bottom: 4px; font-weight: 500;">
                                        <label for="dob">Date of birth</label>
                                        <input type="date" style="margin-bottom: 12px;" class="form-control {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" id="dob" name="date_of_birth" value="{{ $LoggedPatient->date_of_birth }}">
                                        @if($errors->has('date_of_birth'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('date_of_birth') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group" style="margin-bottom: 4px; font-weight: 500;">
                                        <label for="phone" style="margin-bottom: 4px;">Phone</label>
                                        <input type="text" style="margin-bottom: 12px;" class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" id="phone" name="phone_number" value="{{ $LoggedPatient->phone_number }}">
                                        @if($errors->has('phone_number'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('phone_number') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group" style="margin-bottom: 4px; font-weight: 500;">
                                        <label for="address" style="margin-bottom: 4px;">Address</label>
                                        <input type="text" style="margin-bottom: 12px;" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address" name="address" placeholder="Street No, Street Name, City" value="{{ $LoggedPatient->address }}">
                                        @if($errors->has('address'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('address') }}
                                            </div>
                                        @endif
                                    </div>

                                    <button type="submit" class="btn btn-primary col-4 float-end" style="margin-top: 12px;">Update information</button>
                                </form>
                            </div>
                        </div>

                        <!-- card for image upload -->
                        <div class="card" style="width: 50rem; margin-top: 3%;">
                            <div class="card-body">
                                <h5 class="card-title">Upload Image</h5>
                                <form action="{{ route('patient.updatePicture', $LoggedPatient->patient_id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="image" style="margin-bottom: 4px; font-weight: 500;">Select Picture</label>
                                        <input type="file" style="margin-bottom: 12px;" class="form-control" id="profile_picture" name="profile_picture">
                                    </div>
                                    <button type="submit" class="btn btn-primary col-4 float-end" style="margin-top: 12px;">Upload</button>
                                </form>
                            </div>
                        </div>

                        <!-- card for change password input -->
                        <div class="card" style="width: 50rem; margin-top: 3%;">
                            <div class="card-body">
                                <h5 class="card-title">Change Password</h5>
                                <form action="{{ route('patient.updatePatientPassword', $LoggedPatient->patient_id) }}" method="POST">
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
