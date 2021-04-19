<div class="kt-section__body">
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Nomor SPPD</label>
    <label class="col-xl-1 col-lg-1 col-form-label">:</label>
    <div class="col-lg-9 col-xl-6">
    {!! Form::text('no_sppd', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
    @error('no_sppd')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Tanggal Berangkat</label>
    <label class="col-xl-1 col-lg-1 col-form-label">:</label>
    <div class="col-lg-2 col-xl-2">
    {!! Form::date('tanggal_pergi', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
    @error('tanggal_pergi')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
    <label class="col-xl-1 col-lg-1 col-form-label">Tanggal Kembali</label>
    <label class="col-xl-1 col-lg-1 col-form-label">:</label>
    <div class="col-lg-2 col-xl-2">
    {!! Form::date('tanggal_pulang', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
    @error('tanggal_pulang')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Tujuan SPPD</label>
    <label class="col-xl-1 col-lg-1 col-form-label">:</label>
    <div class="col-lg-9 col-xl-6">
    {!! Form::textarea('tujuan', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
    @error('tujuan')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Tempat Berangkat</label>
    <label class="col-xl-1 col-lg-1 col-form-label">:</label>
    <div class="col-lg-2 col-xl-2">
    {!! Form::text('tempat_berangkat', null, ['class' => 'form-control', 'placeholder'=>'Padang']) !!}
    @error('tempat_berangkat')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
    <label class="col-xl-1 col-lg-1 col-form-label">Tempat tujuan</label>
    <label class="col-xl-1 col-lg-1 col-form-label">:</label>
    <div class="col-lg-2 col-xl-2">
    {!! Form::text('tempat_tujuan', null, ['class' => 'form-control', 'placeholder'=>'']) !!}
    @error('tempat_tujuan')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Dibuat di</label>
    <label class="col-xl-1 col-lg-1 col-form-label">:</label>
    <div class="col-lg-9 col-xl-6">
    {!! Form::text('dibuat_di', null, ['class' => 'form-control', 'placeholder'=>'Padang','required'=>'required','value'=>'Padang']) !!}
    @error('dibuat_di')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Pembebanan Anggaran</label>
    <label class="col-xl-1 col-lg-1 col-form-label">:</label>
    <div class="col-lg-9 col-xl-6">
    {!! Form::select('pengemban_anggaran', $pengemban_anggaran,null, ['class' => 'form-control kt-select2', 'placeholder'=>'', 'id'=>'kt_select2_2','required'=>'required']) !!}
    @error('pengemban_anggaran')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Sumber Dana</label>
    <label class="col-xl-1 col-lg-1 col-form-label">:</label>
    <div class="col-lg-9 col-xl-6">
    {!! Form::select('sumber_dana', $sumber_dana,null, ['class' => 'form-control kt-select2', 'placeholder'=>'', 'id'=>'kt_select2_1','required'=>'required']) !!}
    @error('sumber_dana')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Angkutan</label>
    <label class="col-xl-1 col-lg-1 col-form-label">:</label>
    <div class="col-lg-9 col-xl-6">
    {!! Form::select('angkutan', $angkutan,null, ['class' => 'form-control kt-select2', 'placeholder'=>'', 'id'=>'kt_select2_1','required'=>'required']) !!}
    @error('angkutan')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Mata Anggaran</label>
    <label class="col-xl-1 col-lg-1 col-form-label">:</label>
    <div class="col-lg-9 col-xl-6">
    {!! Form::text('mata_anggaran', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
    @error('mata_anggaran')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Keterangan</label>
    <label class="col-xl-1 col-lg-1 col-form-label">:</label>
    <div class="col-lg-9 col-xl-6">
    {!! Form::textarea('keterangan', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
    @error('keterangan')
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
