<!-- doctor dashboard -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Admin | Doctors</title>
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
                <a href="{{ route('admin.doctors') }}" class="nav-link active" id="v-pills-doctors-tab" type="button" role="tab" aria-controls="v-pills-doctors" aria-selected="true">Doctors</a>
                <a href="{{ route('admin.patients') }}" class="nav-link" id="v-pills-patients-tab" type="button" role="tab" aria-controls="v-pills-patients" aria-selected="false">Patients</a>
                <a href="{{ route('admin.profile') }}" class="nav-link" id="v-pills-profile-tab" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                <a href="{{ route('admin.settings') }}" class="nav-link" id="v-pills-settings-tab" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-doctors" role="tabpanel" aria-labelledby="v-pills-doctors-tab" tabindex="0">
                    <div class="row">
                        <div class="col">
                            <h3 style="padding: 10px;">Doctors</h3>
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
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <h4 class="title">List of all Registered Doctors</h4>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addDoctorModal">Add New Doctor</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped text-center">
                                    <thead>
                                        <th scope="col" style="display: none;">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email Address</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Speciality</th>
                                        <th scope="col">Registered Since</th>
                                        <th scope="col">Modified at</th>
                                        <th scope="col">Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($doctors as $doctor)
                                            <tr>
                                                <td style="display: none;">{{ $doctor->doctor_id }}</td>
                                                <td>{{ $doctor->doctor_name }}</td>
                                                <td>{{ $doctor->doctor_email }}</td>
                                                <td>{{ $doctor->doctor_phone }}</td>
                                                <td>{{ $doctor->doctor_speciality }}</td>
                                                <!-- format created_at date -->
                                                <td>{{ date('d/m/Y', strtotime($doctor->created_at)) }}</td>
                                                <td>{{ date('d/m/Y', strtotime($doctor->updated_at)) }}</td>
                                                <td>
                                                    <a type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewDoctorModal{{ $doctor->doctor_id}}">View</a>
                                                    <a type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#ConfirmRemoveModal{{ $doctor->doctor_id }}">Remove</a>
                                                </td>
                                            </tr>

                                                                                         <!--  View Doctor info for deletion Modal -->
                                                                                         <div class="modal fade" id="viewDoctorModal{{ $doctor->doctor_id }}" tabindex="-1" aria-labelledby="viewDoctorModalLabel" aria-hidden="true">
                                                                                            <div class="modal-dialog">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="viewDoctorModalLabel">{{ $doctor->doctor_name }}</h5>
                                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                            <input type="text" name="id" value="{{ $doctor->doctor_id }}" hidden readonly>

                                                                                                            <div class="profile-img text-center">
                                                                                                                @if($doctor->doctor_picture == "default-avatar.png")
                                                                                                                    <img src="{{ asset($doctor->doctor_picture) }}" class="img-fluid" alt="{{ $doctor->doctor_name }} photo"  style="width: 110px; height: 110px; border-radius: 50%; margin-bottom: 12px;">
                                                                                                                    @else
                                                                                                                    <img src="{{ asset('/uploads/doctors/'.$doctor->doctor_picture) }}" class="img-fluid" alt="{{ $doctor->doctor_name }} photo" style="width: 110px; height: 110px; border-radius: 50%; margin-bottom: 12px;">
                                                                                                                @endif
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                                <label for="doctor_name">Doctor Name</label>
                                                                                                                <input type="text" class="form-control" id="name" name="doctor_name" value="{{ $doctor->doctor_name }}" readonly>
                                                                                                            </div>
                                                                                                            <div class="form-group" style="margin-top: 12px;">
                                                                                                                <label for="doctor_email">Email Address</label>
                                                                                                                <input type="email" class="form-control" id="email" name="doctor_email" value="{{ $doctor->doctor_email }}" readonly>
                                                                                                            </div>

                                                                                                            <div class="form-group" style="margin-top: 12px;">
                                                                                                                <label for="doctor_phone">Phone number</label>
                                                                                                                <input type="text" class="form-control" id="phone" name="doctor_phone" value="{{ $doctor->doctor_phone }}" readonly>
                                                                                                            </div>

                                                                                                            <div class="form-group" style="margin-top: 12px;">
                                                                                                                <label for="doctor_speciality">Speciality</label>
                                                                                                                <input type="text" class="form-control" id="speciality" name="doctor_speciality" value="{{ $doctor->doctor_speciality }}" readonly>
                                                                                                            </div>
                                                                                                            <hr>
                                                                                                            <button type="button" class="btn btn-light col-12"  data-bs-dismiss="modal" style="margin-top: 12px;">Close</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                             <!--  View Doctor info for deletion Modal -->
                                            <div class="modal fade" id="ConfirmRemoveModal{{ $doctor->doctor_id }}" tabindex="-1" aria-labelledby="ConfirmRemoveModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="ConfirmRemoveModalLabel">{{ $doctor->doctor_name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger" role="alert">
                                                                Deleting this doctor will also delete all the appointments and records associated with this doctor.
                                                           </div>
                                                            <form action="{{ route('admin.confirmRemoveDoctor', $doctor->doctor_id) }}" method="POST">
                                                                @csrf

                                                                <input type="text" name="id" value="{{ $doctor->doctor_id }}" hidden readonly>

                                                                <div class="profile-img text-center">
                                                                    @if($doctor->doctor_picture == "default-avatar.png")
                                                                        <img src="{{ asset($doctor->doctor_picture) }}" class="img-fluid" alt="{{ $doctor->doctor_name }} photo"  style="width: 110px; height: 110px; border-radius: 50%; margin-bottom: 12px;">
                                                                        @else
                                                                        <img src="{{ asset('/uploads/doctors/'.$doctor->doctor_picture) }}" class="img-fluid" alt="{{ $doctor->doctor_name }} photo" style="width: 110px; height: 110px; border-radius: 50%; margin-bottom: 12px;">
                                                                    @endif
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="doctor_name">Doctor Name</label>
                                                                    <input type="text" class="form-control" id="name" name="doctor_name" value="{{ $doctor->doctor_name }}" readonly>
                                                                </div>
                                                                <div class="form-group" style="margin-top: 12px;">
                                                                    <label for="doctor_email">Email Address</label>
                                                                    <input type="email" class="form-control" id="email" name="doctor_email" value="{{ $doctor->doctor_email }}" readonly>
                                                                </div>

                                                                <div class="form-group" style="margin-top: 12px;">
                                                                    <label for="doctor_phone">Phone number</label>
                                                                    <input type="text" class="form-control" id="phone" name="doctor_phone" value="{{ $doctor->doctor_phone }}" readonly>
                                                                </div>

                                                                <div class="form-group" style="margin-top: 12px;">
                                                                    <label for="doctor_speciality">Speciality</label>
                                                                    <input type="text" class="form-control" id="speciality" name="doctor_speciality" value="{{ $doctor->doctor_speciality }}" readonly>
                                                                </div>

                                                                <button type="submit" class="btn btn-danger col-12" style="margin-top: 4%;">Confirm delete account</button>
                                                                <button type="button" class="btn btn-light col-12"  data-bs-dismiss="modal" style="margin-top: 12px;">Cancel</button>
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
                                <!--  View Doctor info for deletion Modal -->
                    <div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addDoctorModalLabel">New Doctor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.addNewDoctor') }}" method="POST">
                                            @csrf
                                        <div class="form-group">
                                            <label for="doctor_name">Doctor Name</label>
                                            <input type="text" class="form-control" id="name" name="doctor_name">
                                        </div>

                                        <div class="form-group" style="margin-top: 12px;">
                                            <label for="doctor_email">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="doctor_email">
                                        </div>

                                        <div class="form-group" style="margin-top: 12px;">
                                            <label for="doctor_phone">Phone number</label>
                                            <input type="text" class="form-control" id="phone" name="doctor_phone">
                                        </div>

                                        <div class="form-group" style="margin-top: 12px;">
                                            <label for="doctor_speciality">Speciality</label>
                                            <input type="text" class="form-control" id="speciality" name="doctor_speciality">
                                        </div>

                                        <div class="form-group" style="margin-top: 12px;">
                                            <label for="doctor_password">Password</label>
                                            <input type="password" class="form-control" id="password" name="doctor_password">
                                        </div>

                                        <div class="form-group" style="margin-top: 12px;">
                                            <label for="doctor_password_confirmation">Confirm Password</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="doctor_password_confirmation">
                                        </div>

                                        <button type="submit" class="btn btn-primary col-12" style="margin-top: 18px;">Create Account</button>
                                        <button type="button" class="btn btn-light col-12"  data-bs-dismiss="modal" style="margin-top: 12px;">Cancel</button>
                                    </form>
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
