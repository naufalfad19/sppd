<div class="kt-section__body">

  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">@lang('user.field.avatar.title')</label>
    <div class="col-lg-9 col-xl-6">
      <div class="kt-avatar kt-avatar--outline kt-avatar--circle-" id="kt_user_edit_avatar">
        @if (Request::is('*edit'))
        <div class="kt-avatar__holder" style="background-image: url({{$data->avatar ? url('img/profile-pict/'.$data->avatar) : asset('https://static.thenounproject.com/png/17241-200.png')}});"></div>
        @else
        <div class="kt-avatar__holder" style="background-image: url({{asset('https://static.thenounproject.com/png/17241-200.png')}});"></div>
        @endif
        <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="@lang('user.field.avatar.change')">
          <i class="fa fa-pen"></i>
          <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
        </label>
        <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="@lang('user.field.avatar.cancel')">
          <i class="fa fa-times"></i>
        </span>
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">@lang('user.field.first_name')</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
      @error('first_name')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">@lang('user.field.last_name')</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
      @error('last_name')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">@lang('user.field.email')</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('email', null, ['class' => 'form-control', 'placeholder'=>'','aria-describedby'=>'basic-addon1','required'=>'required']) !!}
      @error('email')
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
    <label class="col-xl-3 col-lg-3 col-form-label">@lang('user.field.no_hp')</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('no_hp', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
      @error('no_hp')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
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

  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">@lang('user.field.alamat')</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::textarea('alamat', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
      @error('alamat')
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
