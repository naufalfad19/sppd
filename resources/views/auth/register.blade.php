<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Au Register Forms by Colorlib</title>

    <!-- Icons font CSS-->
    <link href="{{ asset('files/assets/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('files/assets/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="{{ asset('files/assets/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('files/assets/vendor/datepicker/daterangepicker.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ asset('files/assets/css/main2.css') }}" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Registration Form</h2>
                    {{ Form::open(array('url' => route('regist'), 'files' => true)) }}
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">first name</label>
                                    {!! Form::text('first_name', null, ['class' => 'form-control input--style-4', 'placeholder'=>'','required'=>'required']) !!}
                                    @error('first_name')
                                      <div class="form-text text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">last name</label>
                                    {!! Form::text('last_name', null, ['class' => 'form-control input--style-4', 'placeholder'=>'']) !!}
                                    @error('last_name')
                                      <div class="form-text text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Username</label>
                                    {!! Form::text('username', null, ['class' => 'form-control input--style-4', 'placeholder'=>'','required'=>'required']) !!}
                                    @error('username')
                                      <div class="form-text text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Password</label>
                                    @if (Request::is('*edit'))
                                      {!! Form::password('password', ['class' => 'form-control input--style-4', 'placeholder'=>'']) !!}
                                    @else
                                      {!! Form::password('password', ['class' => 'form-control input--style-4', 'placeholder'=>'','required'=>'required']) !!}
                                    @endif
                                    @error('password')
                                      <div class="form-text text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Ulangi Password</label>
                                    {!! Form::password('password_confirmation', ['class' => 'form-control input--style-4', 'placeholder'=>'']) !!}
                                    @error('password_confirmation')
                                      <div class="form-text text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Email</label>
                                    {!! Form::text('email', null, ['class' => 'form-control input--style-4', 'placeholder'=>'','aria-describedby'=>'basic-addon1','required'=>'required']) !!}
                                    @error('email')
                                    <div class="form-text text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                      <div class="row row-space">
                        <div class="col-2">
                              <div class="input-group">
                                  <label class="label">Phone Number</label>
                                  {!! Form::text('no_hp', null, ['class' => 'form-control input--style-4', 'placeholder'=>'']) !!}
                                  @error('no_hp')
                                    <div class="form-text text-danger">{{$message}}</div>
                                  @enderror
                              </div>
                          </div>
                      </div>
                      <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Address</label>
                                    {!! Form::textarea('alamat', null, ['class' => 'form-control input--style-2', 'placeholder'=>'']) !!}
                                    @error('alamat')
                                      <div class="form-text text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" type="submit" name="button" id="user_create_f">Submit</button>
                        </div>
                      {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="{{ asset('files/assets/vendor/jquery/jquery.min.js') }}"></script>
    <!-- Vendor JS-->
    <script src="{{ asset('files/assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('files/assets/vendor/datepicker/moment.min.js') }}"></script>
    <script src="{{ asset('files/assets/vendor/datepicker/daterangepicker.js') }}"></script>

    <!-- Main JS-->
    <script src="{{ asset('files/assets/js/global.js') }}"></script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->