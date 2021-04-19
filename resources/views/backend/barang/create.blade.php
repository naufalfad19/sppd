<div class="row" id="create" style="display:none">
  <div class="col-md-12">
    <!--begin::Portlet-->
    <div class="kt-portlet">
      {{ Form::open(array('url' => route('kwitansi.add'))) }}
        <div class="kt-form kt-form--label-right">
          <div class="kt-portlet__body ">
            <div class="row">

              <div class="form-group row col-md-12">
                <label for="c_slug" class="col-2 col-form-label">@lang('satuanBarang.field.name')</label>
                <div class="col-10">
                  {!! Form::select('pegawai', $pegawai,null, ['class' => 'form-control kt-select2', 'id'=>'kt_select2_2','required'=>'required']) !!}
                  @error('pegawai')
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
