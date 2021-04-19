<div class="kt-section__body">
  <div class="form-group row validated">
    <label class="col-xl-3 col-lg-3 col-form-label">@lang('role.r_field.r_slug')</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
      @error('slug')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">@lang('role.r_field.r_name')</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
      @error('name')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
</div>
