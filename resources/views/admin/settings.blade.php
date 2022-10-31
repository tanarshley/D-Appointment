<!-- doctor dashboard -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Admin | Settings</title>
        <!-- link app.css from public folder -->
        @include('cdn.bootstrap')
    </head>
    <body>

        <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="background-color: rgb(250, 250, 250); height: 75em; padding: 6px; width: 10%;">
                <div class="picture" style="margin-left: 12px;">
                    @if($LoggedAdmin->picture == "default-avatar.png")
                        <a href="{{ route('admin.profile') }}"><img src="{{ asset($LoggedAdmin->picture) }}" class="img-fluid" alt="{{ $LoggedAdmin->name }} photo"  style="width: 110px; height: 110px; border-radius: 50%; margin-bottom: 12px;"></a>
                        @else
                        <a href="{{ route('admin.profile') }}"><img src="{{ asset('/uploads/admins/'.$LoggedAdmin->picture) }}" class="img-fluid" alt="{{ $LoggedAdmin->name }} photo" style="width: 110px; height: 110px; border-radius: 50%; margin-bottom: 12px;"></a>
                    @endif
                </div>
                <a href = "{{ route('admin.dashboard') }}" class="nav-link" id="v-pills-home-tab" type="button" role="tab" aria-controls="v-pills-home" aria-selected="false">Dashboard</a>
                <a href="{{ route('admin.doctors') }}" class="nav-link" id="v-pills-doctors-tab" type="button" role="tab" aria-controls="v-pills-doctors" aria-selected="false">Doctors</a>
                <a href="{{ route('admin.patients') }}" class="nav-link" id="v-pills-patients-tab" type="button" role="tab" aria-controls="v-pills-patients" aria-selected="false">Patients</a>
                <a href="{{ route('admin.profile') }}" class="nav-link" id="v-pills-profile-tab" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                <a href="{{ route('admin.settings') }}" class="nav-link active" id="v-pills-settings-tab" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="true">Settings</a>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">
                    <div class="row">
                        <div class="col">
                            <h3 style="padding: 10px;">Account Settings</h3>
                        </div>

                        <div class="col" style="padding: 10px; position: absolute; float: right; left:77.3%; top: -10px;">
                            <p style="font-size: 20px; margin-top: 8px;">Hello, {{ $LoggedAdmin->name }}
                                <a href = "{{ route('admin.logout') }}" class="btn btn-outline-danger"
                                    style="position: relative; top: 12%; margin-left: 12px; padding: 10px;">Logout
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="container" style="width: 300%;">
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

                            <form action="{{ route('admin.updateAdminInformation', $LoggedAdmin->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name" style="margin-bottom: 4px; font-weight: 500;">Name</label>
                                    <input type="text" style="margin-bottom: 12px;" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value="{{ $LoggedAdmin->name }}">
                                    @if($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="email" style="margin-bottom: 4px; font-weight: 500;">Email Address</label>
                                    <input type="email" style="margin-bottom: 12px;" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" value="{{ $LoggedAdmin->email }}">
                                    @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group" style="margin-bottom: 4px; font-weight: 500;">
                                    <label for="username" style="margin-bottom: 4px;">Username</label>
                                    <input type="text" style="margin-bottom: 12px;" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" id="username" name="username" value="{{ $LoggedAdmin->username }}">
                                    @if($errors->has('username'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('username') }}
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
                            <form action="{{ route('admin.updateAdminPicture', $LoggedAdmin->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="picture" style="margin-bottom: 4px; font-weight: 500;">Select Picture</label>
                                    <input type="file" style="margin-bottom: 12px;" class="form-control" id="picture" name="picture">
                                </div>
                                <button type="submit" class="btn btn-primary col-4 float-end" style="margin-top: 12px;">Upload</button>
                            </form>
                        </div>
                    </div>

                    <!-- card for change password input -->
                    <div class="card" style="width: 50rem; margin-left: 16%; margin-top: 3%;">
                        <div class="card-body">
                            <h5 class="card-title">Change Password</h5>
                            <form action="{{ route('admin.updateAdminPassword', $LoggedAdmin->id) }}" method="POST">
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

        @include('cdn.js')
    </body>
<html>
