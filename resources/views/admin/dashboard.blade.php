<!-- doctor dashboard -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Admin | Dashboard</title>
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
                <a href = "{{ route('admin.dashboard') }}" class="nav-link active" id="v-pills-home-tab" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Dashboard</a>
                <a href="{{ route('admin.doctors') }}" class="nav-link" id="v-pills-doctors-tab" type="button" role="tab" aria-controls="v-pills-doctors" aria-selected="false">Doctors</a>
                <a href="{{ route('admin.patients') }}" class="nav-link" id="v-pills-patients-tab" type="button" role="tab" aria-controls="v-pills-patients" aria-selected="false">Patients</a>
                <a href="{{ route('admin.profile') }}" class="nav-link" id="v-pills-profile-tab" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                <a href="{{ route('admin.settings') }}" class="nav-link" id="v-pills-settings-tab" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                    <div class="row">
                        <div class="col">
                            <h3 style="padding: 10px;">Dashboard</h3>
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
                    <div class="row">
                        <div class="col-3">
                            <div class="card">
                                <div class="card-header" style="background-color: #0E86D4; color: white; border-bottom: none;">
                                    <h5>Registered Doctors</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text" style="font-size: 2em;">{{ $getTotalDoctors}} </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card">
                                <div class="card-header" style="background-color: #0E86D4; color: white; border-bottom: none;">
                                    <h5>Registered Patients</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text" style="font-size: 2em;">{{ $getTotalPatients}} </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 4%">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h3>Recent Doctors</h3>
                                </div>
                                <div class="col">
                                    <a class="float-end" href="{{ route('admin.doctors') }}" style="text-decoration: none;">View all</a>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead style="background-color: #0E86D4; color: white; border-bottom: none;">
                                    <tr>
                                        <th style="display: none;">ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Speciality</th>
                                        <th>Date Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctors as $doctor)
                                        <tr>
                                            <td style="display: none;">{{ $doctor->id }}</td>
                                            <td>{{ $doctor->doctor_name }}</td>
                                            <td>{{ $doctor->doctor_email }}</td>
                                            <td>{{ $doctor->doctor_phone }}</td>
                                            <td>{{ $doctor->doctor_speciality }}</td>
                                            <td>{{ date('d/m/Y', strtotime($doctor->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h3>Recent Patients</h3>
                                </div>
                                <div class="col">
                                    <a class="float-end" href="{{ route('admin.patients') }}" style="text-decoration: none;">View all</a>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead style="background-color: #0E86D4; color: white; border-bottom: none;">
                                    <tr>
                                        <th style="display: none;">ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Birthdate</th>
                                        <th>Phone</th>
                                        <th>Date Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patients as $patient)
                                        <tr>
                                            <td style="display: none;">{{ $patient->patient_id }}</td>
                                            <td>{{ $patient->name }}</td>
                                            <td>{{ $patient->email }}</td>
                                            <td>{{ $patient->date_of_birth }}</td>
                                            <td>{{ $patient->phone_number }}</td>
                                            <td>{{ date('d/m/Y', strtotime($patient->created_at)) }}</td>
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
