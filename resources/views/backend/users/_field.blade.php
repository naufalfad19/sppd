<div class="kt-section__body">


  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Nama</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
      @error('name')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">@lang('user.field.username')</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('username', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
      @error('username')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">@lang('user.field.role')</label>
    <div class="col-lg-9 col-xl-6">
      @if (Request::is('*edit'))
        {!! Form::select('role', $role, $data->roles() ? $data->roles()->first()->id : 0, ['class' => 'form-control kt-select2', 'id'=>'kt_select2_1','required'=>'required']) !!}
        @error('role')
          <div class="form-text text-danger">{{$message}}</div>
        @enderror
      @else
        {!! Form::select('role', $role,null, ['class' => 'form-control kt-select2', 'id'=>'kt_select2_1','required'=>'required']) !!}
        @error('role')
          <div class="form-text text-danger">{{$message}}</div>
        @enderror
      @endif
    </div>
  </div>

  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">@lang('user.field.password')</label>
    <div class="col-lg-9 col-xl-6">
      @if (Request::is('*edit'))
        {!! Form::password('password', ['class' => 'form-control', 'placeholder'=>'']) !!}
      @else
        {!! Form::password('password', ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
      @endif
      @error('password')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">@lang('user.field.c_password')</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder'=>'']) !!}
      @error('password_confirmation')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>


</div>

@section('tjs')
  <script src="{{asset('theme/js/pages/custom/user/edit-user.js')}}" type="text/javascript"></script>
  <script src="{{asset('theme/js/pages/crud/forms/widgets/select2.js')}}" type="text/javascript"></script>
@endsection

@section('tcss')
  <link href="{{asset('theme/css/pages/wizard/wizard-4.css')}}" rel="stylesheet" type="text/css" />
@endsection
