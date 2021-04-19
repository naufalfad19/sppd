
@php
  $name = __('inventoris.title');
@endphp
@extends('layouts.L1')

@section('title') {{$name}} @lang('global.app_detail') @stop

@section('subheader-name') {{$name}} @lang('global.app_detail') @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
    {{$name}} @lang('global.app_detail')
  </a>
@stop

@section('subheader-btn')
  @if(Sentinel::getUser()->hasAccess(['inventoris.index']))
  <a href="{{route('inventoris.index')}}?status=available" class="btn btn-default btn-bold">
    @lang('global.app_back_to_list')
  </a>
  @endif
  @if(Sentinel::getUser()->hasAccess(['inventoris.updt']))
  <a href="javascript:void(0)" onclick="editInventoris({{$data->id.','.$data->barang_id.','.$data->satuan_id}})" class="btn btn-success btn-bold">
    @lang('global.app_edit')
  </a>
  @endif
  @if(Sentinel::getUser()->hasAccess(['inventoris.destroy']))
  <a href="javascript:void(0)" onclick="confirmdelete({{$data->id}})" class="btn btn-danger btn-bold">
    @lang('global.app_delete')
  </a>
  @endif
@stop

@section('content')

<div class="kt-portlet kt-portlet--mobile">
  <div class="kt-portlet__body">
    <!--begin: Datatable -->
    <table class="table table-striped table-checkable" id="tbl_inventoris">
      <thead>
        <tr>
          <th>@lang('inventoris.field.barang')</th>
          <th>: {{$data->barang->name}}</th>
          <th>@lang('inventoris.field.satker')</th>
          <th>: {{$data->satker->name}}</th>
          <th></th>
          <th></th>
        </tr>
        <tr>
          <th>@lang('inventoris.field.satuan')</th>
          <th>: {{$data->satuan->name}}</th>
          <th>@lang('inventoris.field.total')</th>
          <th>: {{$data->masuk()->sum('total')-$data->keluarDinkes()->sum('total')}}</th>
          <th></th>
          <th></th>
        </tr>
      </thead>


    </table>
    <!--end: Datatable -->
  </div>
</div>

<div class="kt-portlet kt-portlet--mobile">
  <div class="kt-portlet__head kt-portlet__head--lg">
    <div class="kt-portlet__head-label">
      <span class="kt-portlet__head-icon">
        <i class="kt-font-brand flaticon2-line-chart"></i>
      </span>
      <h3 class="kt-portlet__head-title">
        @lang('global.app_list') @lang('inventoris.title') Masuk
      </h3>
    </div>
    <div class="kt-portlet__head-toolbar">

    </div>
  </div>

  <div class="kt-portlet__body">
    <table class="table table-striped- table-bordered table-hover table-checkable" id="tbl_inventorisDetailMasuk">
      <thead>
        <tr>
          <th>@lang('inventoris.field.sumber')</th>
          <th>@lang('inventoris.field.banyak')</th>
          <th>@lang('inventoris.field.tanggal')</th>
          @if(Sentinel::getUser()->hasAccess(['inventorisDetail.updt']) || Sentinel::getUser()->hasAccess(['inventorisDetail.destroy']))
          <th>@lang('global.app_action')</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach($data->masuk as $detail)
          <tr>
            <td>{{$detail->sumber->name}}</td>
            <td>{{$detail->total}}</td>
            <td>{{$detail->tanggal}}</td>
            @if(Sentinel::getUser()->hasAccess(['inventorisDetail.updt']) || Sentinel::getUser()->hasAccess(['inventorisDetail.destroy']))
              <td>
                @if(Sentinel::getUser()->hasAccess(['inventorisDetail.updt']))
                <a class="btn btn-success btn-sm" href="javascript::void(0)" onclick="editmodal({{$detail}})">@lang('global.app_edit')</a>
                @endif
                @if(Sentinel::getUser()->hasAccess(['inventorisDetail.destroy']))
                <a class="btn btn-danger btn-sm" href="javascript::void(0)" onclick="confirmdeletedetail({{$detail->id}})">@lang('global.app_delete')</a>
                @endif
              </td>
            @endif
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="kt-portlet kt-portlet--mobile">
  <div class="kt-portlet__head kt-portlet__head--lg">
    <div class="kt-portlet__head-label">
      <span class="kt-portlet__head-icon">
        <i class="kt-font-brand flaticon2-line-chart"></i>
      </span>
      <h3 class="kt-portlet__head-title">
        @lang('global.app_list') @lang('inventoris.title') Keluar
      </h3>
    </div>
    <div class="kt-portlet__head-toolbar">

    </div>
  </div>

  <div class="kt-portlet__body">
    <table class="table table-striped- table-bordered table-hover table-checkable" id="tbl_inventorisDetailKeluar">
      <thead>
        <tr>
          <th>@lang('inventoris.field.tanggal')</th>
          <th>@lang('inventoris.field.banyak')</th>
          <th>@lang('inventoris.field.satker')</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data->keluarDinkes() as $detail)
          <tr>
            <td>{{$detail->tanggal}}</td>
            <td>{{$detail->total}}</td>
            <td>{{$detail->inventoris->satker->name}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!--begin::Modal-->
<div class="modal fade" id="f_modal_create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      {{ Form::open(array('url' => route('inventorisDetail.add',$data->id), 'files' => true, 'id'=>'form_inventorisDetail_create')) }}
        <div class="modal-body">
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">@lang('inventoris.field.tanggal'):</label>
              </div>
              <div class="kt-form__control">
                <input type="date" name="tanggal" class="form-control" placeholder="Enter number" id="d_tanggal_create">
                @error('total')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">@lang('inventoris.field.sumber'):</label>
              </div>
              <div class="kt-form__control">
                {!! Form::select('sumber', $sumber, null, ['class' => 'form-control kt-select2 myselect2', 'id'=>'s_sumber_create']) !!}
                @error('sumber')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
              <div class="kt-form__control kt-margin-t-10" id="field_sumber_lainnya_create">
                <input type="text" name="sumber_lain" class="form-control" placeholder="Enter Sumber Lainnya" id="i_sumber_lainnya_create">
                @error('sumber_lain')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
          <div class="col-md-12">
              <div class="kt-form__group--inline">
                <div class="kt-form__label">
                  <label class="kt-label m-label--single">@lang('inventoris.field.total'):</label>
                </div>
                <div class="kt-form__control">
                  <input type="number" min="1" name="total" class="form-control" placeholder="Enter number" id="n_total_create">
                  @error('total')
                    <div class="form-text text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="d-md-none kt-margin-b-10"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="btn_form" type="submit" class="btn btn-primary">Save changes</button>
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
<!--end::Modal-->

<!--begin::Modal-->
<div class="modal fade" id="f_modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      {{ Form::open(array('method'=>'PATCH','url' => '#', 'files' => true, 'id'=>'form_inventorisDetail_edit')) }}
        <div class="modal-body">
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">@lang('inventoris.field.tanggal'):</label>
              </div>
              <div class="kt-form__control">
                <input type="date" name="tanggal" class="form-control" placeholder="Enter number" id="d_tanggal_update">
                @error('total')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">@lang('inventoris.field.sumber'):</label>
              </div>
              <div class="kt-form__control">
                {!! Form::select('sumber', $sumber, null, ['class' => 'form-control kt-select2 myselect2', 'id'=>'s_sumber_update']) !!}
                @error('sumber')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
              <div class="kt-form__control kt-margin-t-10" id="field_sumber_lainnya_update">
                <input type="text" name="sumber_lain" class="form-control" placeholder="Enter Sumber Lainnya" id="i_sumber_lainnya_update">
                @error('sumber_lain')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
          <div class="col-md-12">
              <div class="kt-form__group--inline">
                <div class="kt-form__label">
                  <label class="kt-label m-label--single">@lang('inventoris.field.total'):</label>
                </div>
                <div class="kt-form__control">
                  <input type="number" min="1" name="total" class="form-control" placeholder="Enter number" id="n_total_update">
                  @error('total')
                    <div class="form-text text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="d-md-none kt-margin-b-10"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="btn_form" type="submit" class="btn btn-primary">Save changes</button>
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
<!--end::Modal-->

<!--begin::Modal-->
<div class="modal fade" id="f_modal_edit_inventoris" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      {{ Form::open(array('method'=>'PATCH', 'url' => '#', 'files' => true, 'id'=>'form_edit_inventoris')) }}
        <div class="modal-body">
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">@lang('inventorisRequest.field.barang'):</label>
              </div>
              <div class="kt-form__control">
                {!! Form::select('barang', $barang, null, ['class' => 'form-control kt-select2 myselect2', 'id'=>'s_barang_update_inventoris']) !!}
                @error('barang')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">@lang('inventorisRequest.field.satuan'):</label>
              </div>
              <div class="kt-form__control">
                {!! Form::select('satuan', $satuan, null, ['class' => 'form-control kt-select2 myselect2', 'id'=>'s_satuan_update_inventoris']) !!}
                @error('satuan')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="btn_form" type="submit" class="btn btn-primary">Save changes</button>
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
<!--end::Modal-->

{!! Form::open(['method'=>'DELETE', 'route' => ['inventoris.destroy', 0], 'style' => 'display:none','id'=>'deleted_f']) !!}
{!! Form::close() !!}
@stop

@section('tcss')
<link href="{{asset('theme/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('tjs')
  <script src="{{asset('theme/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    $('#field_sumber_lainnya_create').hide();
    $('#field_sumber_lainnya_update').hide();
    jQuery(document).ready(function() {
      var table = $('#tbl_inventorisDetailMasuk').DataTable({
        responsive: true,
        searchDelay: 500,
        processing: true,
        @if(Sentinel::getUser()->hasAccess(['inventorisDetail.add']))
        dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
        buttons: [
            {
                text: "@lang('inventoris.add_detail')",
                className: "btn btn-outline-primary",
                action: function ( e, dt, node, config ) {
                    openmodalcreate();
                }
            }
        ]
        @endif
      });

      var table = $('#tbl_inventorisDetailKeluar').DataTable({
        responsive: true,
        searchDelay: 500,
        processing: true,
        dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
        buttons: [

        ]
      });
    });

    $('#f_modal_create').on('shown.bs.modal', function () {
        $(".myselect2").select2({
            placeholder: "Select a state",
        });
        $('.myselect2').val(0).change();
    });

    $('#f_modal_create .myselect2').on('select2:select', function (e) {
        var id = e.params.data.id;
        if(id=="xxx"){
          $('#field_sumber_lainnya_create').show();
        }else{
          $('#field_sumber_lainnya_create').hide();
        }
    });

    $('#f_modal_update .myselect2').on('select2:select', function (e) {
        var id = e.params.data.id;
        if(id=="xxx"){
          $('#field_sumber_lainnya_update').show();
        }else{
          $('#field_sumber_lainnya_update').hide();
        }
    });

    $('#f_modal_edit_inventoris').on('shown.bs.modal', function () {
        $(".myselect2").select2({
            placeholder: "Select a state",
        });
    });

    $('#f_modal_edit').on('shown.bs.modal', function () {
        $(".myselect2").select2({
            placeholder: "Select a state",
        });
    });

    function openmodalcreate() {
      emptyform();
      $('#f_modal_create').modal('show');
    }

    function editmodal(detail) {
      emptyform();
      $("#s_sumber_update").val(detail.sumber_id).trigger('change');
      $("#n_total_update").val(detail.total);
      $("#d_tanggal_update").val(detail.tanggal);
      $('#f_modal_edit').modal('show');
      var base = "{{url('/')}}";
      $('#form_inventorisDetail_edit').attr('action', base+"/detail-inventoris/{{$data->id}}/"+detail.id);
    }

    function emptyform() {
      $('#field_sumber_lainnya_create').hide();
      $('#i_sumber_lainnya_create').val('');
      $("#d_tanggal_create").val('');
      $("#s_sumber_create").val(0).trigger('change');
      $("#n_total_create").val(0);

      $('#field_sumber_lainnya_update').hide();
      $('#i_sumber_lainnya_update').val('');
      $("#d_tanggal_update").val(0).trigger('change');
      $("#s_sumber_update").val(0).trigger('change');
      $("#n_total_update").val(0);
    }

    function confirmdelete(id) {
      swal.fire({
          title: "@lang('global.app_delete_ask')",
          text: "@lang('global.app_deleted_description')",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: "@lang('global.app_delete_confirm')",
          cancelButtonText: "@lang('global.app_delete_cancel')",
          reverseButtons: true
      }).then(function(result){
          if (result.value) {
              swal.fire(
                  "@lang('global.app_deleted_confirm_massage_1')",
                  "@lang('global.app_deleted_confirm_massage_2')",
                  'success'
              )
              $('#deleted_f').attr('action', "{{route('inventoris.index')}}/"+id);
              $('#deleted_f').submit();
          } else if (result.dismiss === 'cancel') {
              swal.fire(
                  "@lang('global.app_deleted_cancel_massage_1')",
                  "@lang('global.app_deleted_cancel_massage_2')",
                  'error'
              )
              event.preventDefault();
          }
      });
    }

    function confirmdeletedetail(id) {
      swal.fire({
          title: "@lang('global.app_delete_ask')",
          text: "@lang('global.app_deleted_description')",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: "@lang('global.app_delete_confirm')",
          cancelButtonText: "@lang('global.app_delete_cancel')",
          reverseButtons: true
      }).then(function(result){
          if (result.value) {
              swal.fire(
                  "@lang('global.app_deleted_confirm_massage_1')",
                  "@lang('global.app_deleted_confirm_massage_2')",
                  'success'
              )
              var base = "{{url('/')}}";
              $('#deleted_f').attr('action', base+"/detail-inventoris/{{$data->id}}/"+id);
              $('#deleted_f').submit();
          } else if (result.dismiss === 'cancel') {
              swal.fire(
                  "@lang('global.app_deleted_cancel_massage_1')",
                  "@lang('global.app_deleted_cancel_massage_2')",
                  'error'
              )
              event.preventDefault();
          }
      });
    }

    function editInventoris(id, barang, satuan) {
      $("#s_barang_update_inventoris").val(barang).trigger('change');
      $("#s_satuan_update_inventoris").val(satuan).trigger('change');
      $('#f_modal_edit_inventoris').modal('show');
      var base = "{{url('/')}}";
      $('#form_edit_inventoris').attr('action', base+'/inventoris/'+id);
    }
  </script>
@endsection
