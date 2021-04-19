<div class="kt-section__body">
    <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">NIP</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('nip', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
      @error('nip')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
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
    <label class="col-xl-3 col-lg-3 col-form-label">Pangkat</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::select('id_pangkat', $id_pangkat,null, ['class' => 'form-control kt-select2', 'id'=>'kt_select2_2','required'=>'required']) !!}
      @error('id_pangkat')
          <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Jabatan</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('jabatan', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
      @error('jabatan')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Tempat Lahir</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('tempat_lahir', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
      @error('tempat_lahir')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Tanggal Lahir</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::date('tanggal_lahir', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
      @error('tanggal_lahir')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>


@section('tjs')
  <script src="{{asset('theme/js/pages/custom/user/edit-user.js')}}" type="text/javascript"></script>
  <script src="{{asset('theme/js/pages/crud/forms/widgets/select2.js')}}" type="text/javascript"></script>
@endsection

@section('tcss')
  <link href="{{asset('theme/css/pages/wizard/wizard-4.css')}}" rel="stylesheet" type="text/css" />
@endsection
