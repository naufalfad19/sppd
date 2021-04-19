<div class="kt-section__body">
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">No Surat</label>
    <label class="col-xl-1 col-lg-1 col-form-label">:</label>
    <div class="col-lg-9 col-xl-6">
    {!! Form::text('no_surat', $no_surat, ['readonly', 'class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
    @error('no_surat')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Menimbang :</label>
    <label class="col-xl-1 col-lg-1 col-form-label">a</label>
    <div class="col-lg-9 col-xl-6">
    {!! Form::textarea('menimbang_a', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
    @error('menimbang_a')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label"></label>
    <label class="col-xl-1 col-lg-1 col-form-label">b</label>
    <div class="col-lg-9 col-xl-6">
    {!! Form::textarea('menimbang_b', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
    @error('menimbang_b')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Dasar :</label>
    <label class="col-xl-1 col-lg-1 col-form-label"></label>
    <div class="col-lg-9 col-xl-6">
    {!! Form::textarea('dasar', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
    @error('dasar')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Tujuan :</label>
    <label class="col-xl-1 col-lg-1 col-form-label"></label>
    <div class="col-lg-9 col-xl-6">
    {!! Form::textarea('tujuan', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
    @error('tujuan')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Pengaju :</label>
    <label class="col-xl-1 col-lg-1 col-form-label"></label>
    <div class="col-lg-9 col-xl-6">
    {!! Form::text('id_user', $id_user, ['readonly','class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
    @error('id_user')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Jenis Surat Perintah :</label>
    <label class="col-xl-1 col-lg-1 col-form-label"></label>
    <div class="col-lg-9 col-xl-6">
    {!! Form::select('jenis_perintah', $jenis_perintah,null, ['class' => 'form-control kt-select2', 'id'=>'kt_select2_2','required'=>'required']) !!}
    @error('jenis')
        <div class="form-text text-danger">{{$message}}</div>
    @enderror
    </div>
</div>

<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Kop Surat:</label>
    <label class="col-xl-1 col-lg-1 col-form-label"></label>
    <div class="col-lg-9 col-xl-6">
    <div class="row">
        <div class="col-6">
        <div class="row">
            <div class="col-1">
                {!! Form::radio('kop_surat', 1, ['class' => 'form-control', 'placeholder'=>'', 'value' => '1']) !!}
                @error('kop_surat')
                    <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="col-11">
                <label for="">Kop Surat</label>
            </div>
        </div>
        </div>
        <div class="col-6">
        <div class="row">
            <div class="col-1">
                {!! Form::radio('kop_surat', 2, ['class' => 'form-control', 'placeholder'=>'', 'value' => '2']) !!}
                @error('kop_surat')
                    <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="col-11">
                <label for="">Tanpa Kop Surat</label>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-xl-3 col-lg-3 col-form-label">Tanda Tangan:</label>
    <label class="col-xl-1 col-lg-1 col-form-label"></label>
    <div class="col-lg-9 col-xl-6">
    <div class="row">
        <div class="col-6">
        <div class="row">
            <div class="col-1">
                {!! Form::radio('ttd', 1, ['class' => 'form-control', 'placeholder'=>'', 'value' => '1']) !!}
                @error('ttd')
                    <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="col-11">
                <label for="">kakanwil</label>
            </div>
        </div>
        </div>
        <div class="col-6">
        <div class="row">
            <div class="col-1">
                {!! Form::radio('ttd', 2, ['class' => 'form-control', 'placeholder'=>'', 'value' => '2']) !!}
                @error('ttd')
                    <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="col-11">
                <label for="">Selain Kakanwil</label>
            </div>
        </div>
        </div>
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
