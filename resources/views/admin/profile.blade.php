<!-- doctor dashboard -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Admin | Profile</title>
        <!-- link app.css from public folder -->
        @include('cdn.bootstrap')
    </head>
    <body style="overflow: hidden;">

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
                <a href="{{ route('admin.profile') }}" class="nav-link active" id="v-pills-profile-tab" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="true">Profile</a>
                <a href="{{ route('admin.settings') }}" class="nav-link" id="v-pills-settings-tab" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
                    <div class="row">
                        <div class="col">
                            <h3 style="padding: 10px;">Admin's Profile</h3>
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

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <!-- get profile_pic from public folder -->
                                    @if($LoggedAdmin->picture == "default-avatar.png")
                                        <img src="{{ asset($LoggedAdmin->picture) }}" class="img-fluid" alt="{{ $LoggedAdmin->name }} photo" style="width: 184px; height: 184px; border-radius: 50%;">
                                        @else
                                        <img src="{{ asset('/uploads/admins/'.$LoggedAdmin->picture) }}" class="img-fluid" alt="{{ $LoggedAdmin->name }} photo" style="width: 184px; height: 184px; border-radius: 50%;">
                                    @endif
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <h4 class="card-title">Personal Information</h4>
                                        </div>
                                    </div>

                                    <p class="card-text" style="font-size: 1.1rem;"><span style="font-weight: 500;">Username:</span> {{ $LoggedAdmin->username }}</p>
                                    <p class="card-text" style="font-size: 1.1rem;"><span style="font-weight: 500;">Name:</span> {{ $LoggedAdmin->name }}</p>
                                    <p class="card-text" style="font-size: 1.1rem;"><span style="font-weight: 500;">Email Address:</span> {{ $LoggedAdmin->email }}</p>
                                    <p class="float-end" style="font-style: italic; color: gray;">
                                        Admin since {{ date('M d, Y', strtotime($LoggedAdmin->created_at)) }}
                                    </p>
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
