<!-- doctor register -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Admin | Register</title>
        <!-- link app.css from public folder -->
        @include('cdn.bootstrap')
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-8" style="margin-top: 6%;">
                    <div class="card" style="border: none;">
                        <div class="card-header-light text-center" style="border: none;">
                            <h4>Welcome to Admin Side</h4>
                        </div>

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{session ('error')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="card-body">
                            <form action="{{ route('admin.adminRegisterProcess') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group" style="margin-bottom: 3%;">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}">
                                    @if($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group" style="margin-bottom: 3%;">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" value="{{ old('username') }}">
                                    @if($errors->has('username'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('username') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group" style="margin-bottom: 3%;">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}">
                                    @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group" style="margin-bottom: 3%;">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
                                    @if($errors->has('password'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('password') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group" style="margin-bottom: 3%;">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}">
                                    @if($errors->has('password_confirmation'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('password_confirmation') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group" style="margin-top: 10px;">
                                    <button type="submit" class="col-12 btn btn-primary btn-block">Register</button>
                                </div>

                                <!--login-->
                                <div class="form-group" style="margin-top: 10px;">
                                    <a href="{{ route('doctor.login') }}" class="col-12 btn btn-light btn-block">Already have an account? Login</a>
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
