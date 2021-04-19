<div class="kt-section__body">
    <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Nama Kepala Kantor Wilayah</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('nama_kkw', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
      @error('nama_kkw')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">NIP Kepala Kantor Wilayah</label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('nip_kkw', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
      @error('nip_kkw')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Nama Kepala Bagian Tata Usaha </label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('nama_kbtu', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
      @error('nama_kbtu')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">NIP Kepala Bagian Tata Usaha </label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('nip_kbtu', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
      @error('nip_kbtu')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Nama Pejabat Pembuat Komitmen </label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('nama_ppk', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
      @error('nama_ppk')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">NIP Pejabat Pembuat Komitmen </label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('nip_ppk', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
      @error('nip_ppk')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Nama Bendahara Pengeluaran </label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('nama_bp', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
      @error('nama_bp')
        <div class="form-text text-danger">{{$message}}</div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">NIP Bendahara Pengeluaran </label>
    <div class="col-lg-9 col-xl-6">
      {!! Form::text('nip_bp', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
      @error('nip_bp')
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
