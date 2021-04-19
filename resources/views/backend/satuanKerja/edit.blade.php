<div class="row" id="edit" style="display:none">
  <div class="col-md-12">
    <!--begin::Portlet-->
    <div class="kt-portlet">
      {{ Form::open(array('method'=>'PATCH','url' => route('satker.updt',0), 'id'=>'form-update', 'files' => true)) }}
        <div class="kt-form">
          <div class="kt-portlet__body ">
            <div class="row">
              <div class="form-group row col-md-8 text-right">
                <label for="c_slug" class="col-2 col-form-label">@lang('satuanKerja.field.name')</label>
                <div class="col-10">
                  <input class="form-control" name="name" type="text" value="" id="e_name">
                  @error('name')
                    <div class="form-text text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="form-group row col-md-4 text-right">
                <label for="c_name" class="col-2 col-form-label">@lang('satuanKerja.field.status')</label>
                <div class="col-10">
                  <select class="form-control" name="status" id="e_status">
                    <option value="0">Not Available</option>
                    <option value="1">Available</option>
                  </select>
                  @error('status')
                    <div class="form-text text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="form-group row col-md-8">
                <label for="c_slug" class="col-2 col-form-label text-right">@lang('satuanKerja.field.logo')</label>
                <div class="col-5">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="e_logo" name="logo" accept=".png, .jpg, .gif, .jpeg">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                  </div>
                  @error('logo')
                    <div class="form-text text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="text-center">
              <button onclick="$('#edit').hide('500');" type="button" class="btn btn-default">@lang('global.app_cancel')</button>
              <button class="btn btn-success" type="submit">@lang('global.app_update')</button>
            </div>
          </div>
        </div>
      {{ Form::close() }}
    </div>
    <!--end::Portlet-->
  </div>
</div>
