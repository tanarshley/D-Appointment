<!-- doctor login -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Admin | Login</title>
        <!-- link app.css from public folder -->
        @include('cdn.bootstrap')
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('photos/admin-login-picture.svg') }}" alt="admin-login-picture" style="margin-top: 6%; margin-left: -10%; position: absolute; width: 65%; height: 65%;">
                    <h1 style="position: absolute; top: 40px; color: rgb(0, 111, 190);">Doctors Appointment System | Admin Side</h1>
                </div>
                <div class="col-md-4 offset-md-8" style="margin-top: 12%;">
                    <div class="card" style="border: none;">
                        <div class="card-header-light text-center" style="border: none;">
                            <h4>Administrator</h4>
                        </div>
                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card-body">
                            <form action="{{ route('admin.adminLoginProcess') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" value="{{ old('username') }}">
                                    @if($errors->has('username'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('username') }}
                                        </div>
                                    @endif
                                </div><br>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
                                    @if($errors->has('password'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('password') }}
                                        </div>
                                    @endif
                                </div>
                                <!-- forgot password -->
                                <div class="form-group" style="padding-top: 2%; padding-bottom: 9%;">
                                    <a href="" class="text-muted float-end" style="text-decoration: none;">Forgot Password?</a>
                                </div>
                                <div class="form-group" style="margin-top: 10px;">
                                    <button type="submit" class="col-12 btn btn-primary btn-block">Login Admin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('cdn.js')
    </body>
</html>
