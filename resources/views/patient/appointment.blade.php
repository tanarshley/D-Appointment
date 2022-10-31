<!-- patient doctors -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Patient | Appointment</title>
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
                <a href="{{ route('patient.appointment') }}" class="nav-link active" id="v-pills-create-tab" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Set Appointment</a>
                <a href="{{ route('patient.history') }}" class="nav-link" id="v-pills-history-tab" type="button" role="tab" aria-controls="v-pills-history" aria-selected="false">History</a>
                <a href="{{ route('patient.doctors') }}" class="nav-link" id="v-pills-doctors-tab"  type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Doctors</a>
                <a href="{{ route('patient.profile') }}" class="nav-link" id="v-pills-profile-tab" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Profile</a>
                <a href="{{ route('patient.settings') }}" class="nav-link" id="v-pills-settings-tab" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-create" role="tabpanel" aria-labelledby="v-pills-create-tab" tabindex="0">
                    <div class="row">
                        <div class="col">
                            <h3 style="padding: 10px;">Set Appointment</h3>
                        </div>

                        <div class="col" style="padding: 10px; position: absolute; float: right; left:77.3%; top: -10px;">
                            <p style="font-size: 20px; margin-top: 8px;">Hello, {{ $LoggedPatient->name }}
                                <a href = "{{ route('patient.logout') }}" class="btn btn-outline-danger"
                                    style="position: relative; top: 12%; margin-left: 12px; padding: 10px;">Logout
                                </a>
                            </p>
                        </div>
                    <!-- create appointment form -->
                    <div class="container" style="margin-left: 74px;">

                        <!-- alert message -->
                        <div class="alert alert-warning" role="alert" id="warningAlert" style="margin-left: 100px;">
                            <strong>Dear patients!</strong>
                            <ul>
                                <list>
                                    <li>Make sure you complete your profile before you set an appointment.</li>
                                    <li>Check your appointment application if correct.</li>
                                </list>
                            </ul>
                        </div>

                        @if(session('success'))
                            <!-- hide #warningAlert -->
                            <style>
                                #warningAlert {
                                    display: none;
                                }
                            </style>
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-left: 100px;">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" id="showAlert" aria-label="Close"></button>
                            </div>

                            @else
                            <style>
                                #warningAlert {
                                    display: block;
                                }
                            </style>
                        @endif


                        @if(session('error'))
                            <!-- hide #warningAlert -->
                            <style>
                                #warningAlert {
                                    display: none;
                                }
                            </style>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-left: 100px;">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

                            @else
                            <style>
                                #warningAlert {
                                    display: block;
                                }
                            </style>
                        @endif

                        <div class="card" style="margin-left: 100px;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title">Appointment Details</h5>
                                        <!--<img src="" id="doctorImage" class="rounded-circle" style="width: 100px; height: 100px;">-->
                                    </div>

                                    <div class="col" style="width: 45%;">
                                        <form action="{{ route('patient.setAppointment') }}" method="POST">
                                            @csrf

                                            <div class="form-group">
                                                <input type="text" name="patient_id" value="{{ $LoggedPatient->patient_id }}" hidden>
                                                <input type="text" name="patient_name" value="{{ $LoggedPatient->name }}" hidden>
                                            </div>
                                            <div class="form-group" style="margin-bottom: 12px;">
                                                <label for="doctor">Select Doctor</label>
                                                <select class="form-control" id="doctor" name="doctor_id">
                                                    <!-- check if there is any doctor -->
                                                    @if(count($doctors) > 0)
                                                        @foreach ($doctors as $doctor)
                                                            <option value="{{ $doctor->doctor_id }}">{{ $doctor->doctor_name }}</option>
                                                        @endforeach
                                                    @endif
                                                    @if(count($doctors) == 0)
                                                        <option value="0">No doctor available</option>
                                                    @endif
                                                </select>
                                                <!-- show doctor name by doctor id -->
                                                @if(count($doctors) > 0)
                                                    <input type="text" name="doctor_name" id="doctor_name" value="{{ $doctor->doctor_name }}" hidden>
                                                @endif

                                                @if(count($doctors) == 0)
                                                    <input type="text" name="doctor_name" id="doctor_name" value="0" hidden>
                                                @endif
                                            </div>
                                            <div class="form-group" style="margin-bottom: 12px;">
                                                <label for="date">Date</label>
                                                <input type="date" class="form-control {{ $errors->has('appointment_date') ? 'is-invalid' : '' }}" value="{{ old('appointment_date') }}" id="date" name="appointment_date">
                                                @if($errors->has('appointment_date'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('appointment_date') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- radio selection for appointment time -->
                                            <div class="form-group" style="margin-bottom: 12px;">
                                                <p class="text-center">----- Select Time -----</p>
                                                <div class="row">
                                                    <div class="col">
                                                        <p class="text-center">Morning</p>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="appointment_time" id="time1" value="09:00" required>
                                                            <label class="form-check-label" for="time1">
                                                                09:00 - 10:00
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="appointment_time" id="time2" value="10:00" required>
                                                            <label class="form-check-label" for="time2">
                                                                10:00 - 11:00
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="appointment_time" id="time3" value="11:00" required>
                                                            <label class="form-check-label" for="time3">
                                                                11:00 - 12:00
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <p class="text-center">Afternoon</p>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="appointment_time" id="time4" value="13:00" required>
                                                            <label class="form-check-label" for="time4">
                                                                1:00 - 2:00
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="appointment_time" id="time5" value="14:00" required>
                                                            <label class="form-check-label" for="time5">
                                                                2:00 - 3:00
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="appointment_time" id="time6" value="15:00" required>
                                                            <label class="form-check-label" for="time6">
                                                                3:00 - 4:00
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            <button type="submit" class="btn btn-primary col-12" style="margin-top: 16px;">Set Appointment</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        @include('cdn.js')
        <!--script to disable past date and only choose in the current month-->
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
            //set current date as default value
            document.getElementById("date").value = today;
        </script>
    </body>
<html>
