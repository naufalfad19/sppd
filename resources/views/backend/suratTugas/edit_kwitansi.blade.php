<div class="row" id="create" style="display:none">
<div class="col-md-12">
    <!--begin::Portlet-->
    <div class="kt-portlet">
    {{ Form::open(array('url' => route('kwitansi.store',$data->id), 'method' => 'post')) }}
        <div class="kt-form kt-form--label-right">
        <div class="kt-portlet__body ">
            <div class="row">
                <div class="form-group row col-md-12">
                    <label for="c_slug" class="col-2 col-form-label">Nama Pegawai</label>
                    <div class="col-10">
                    {!! Form::select('kwitansi_pegawai', $kwitansi_pegawai,null, ['class' => 'form-control kt-select2', 'id'=>'kt_select2_1','required'=>'required']) !!}
                    @error('kwitansi_pegawai')
                        <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                    </div>
                </div>
                <div class="form-group row col-md-12">
                    <label for="c_slug" class="col-2 col-form-label">Uang Harian</label>
                    <div class="col-10">
                    <input class="form-control" name="uang_harian" type="number" value="" id="c_name">
                    @error('uang_harian')
                        <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                    </div>
                </div>
                <div class="form-group row col-md-12">
                    <label for="c_slug" class="col-5 col-form-label"></label>
                    <div class="col-7">
                    <b>Biaya Transport & Akomodasi</b>
                    </div>
                </div>
                <div class="form-group row col-md-12">
                    <label for="c_slug" class="col-2 col-form-label">Transportasi</label>
                    <div class="col-10">
                    <input class="form-control" name="tiket" type="number" value="" id="c_name">
                    @error('tiket')
                        <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                    </div>
                </div>
                <div class="form-group row col-md-12">
                    <label for="c_slug" class="col-2 col-form-label">Taxi</label>
                    <div class="col-10">
                    <input class="form-control" name="taxi" type="number" value="" id="c_name">
                    @error('taxi')
                        <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                    </div>
                </div>
                <div class="form-group row col-md-12">
                    <label for="c_slug" class="col-2 col-form-label">Penginapan</label>
                    <div class="col-10">
                    <input class="form-control" name="penginapan" type="number" value="" id="c_name">
                    @error('penginapan')
                        <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                    </div>
                </div>
                <div class="form-group row col-md-12">
                    <label for="c_slug" class="col-2 col-form-label">Uang Muka/ Sudah Dibayar Semula</label>
                    <div class="col-10">
                    <input class="form-control" name="uang_muka" type="number" value="" id="c_name">
                    @error('uang_muka')
                        <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                    </div>
                </div>
            </div>
            <div class="text-center">
            <button onclick="$('#create').hide('500');" type="button" class="btn btn-default">@lang('global.app_cancel')</button>
            <button class="btn btn-success" type="submit">@lang('global.app_save')</button>
            </div>
        </div>
        </div>
    {!! Form::close() !!}
    </div>
    <!--end::Portlet-->
</div>
</div>
