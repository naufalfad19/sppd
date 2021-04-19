
@php
    $name = 'Tambah Surat Tugas';
    if($data->jenis_perintah==1){
        $jenis_perintah = 'sppd';
    }
    elseif($data->jenis_perintah==2){
        $jenis_perintah = 'non_sppd';
    }
    elseif($data->jenis_perintah==3){
        $jenis_perintah = 'dalam_kota';
    }
@endphp
@extends('layouts.L1')

@section('title') {{$name}}  @stop

@section('subheader-name') {{$name}}  @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript:void(0)" class="kt-subheader__breadcrumbs-link">
    {{$name}} 
  </a>
@stop


@section('content')

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__body">
        <div class="tab-content">
        <div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
            <div class="kt-form kt-form--label-right">
            <div class="kt-form__body">
                <div class="kt-section kt-section--first">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="tbl_inventorisDetailMasuk">
                        <thead>
                            <tr>
                            <th>Nama Pegawai</th>
                            @if(Sentinel::getUser()->hasAccess(['tugasde.updt']) || Sentinel::getUser()->hasAccess(['tugasde.destroy']))
                            <th>@lang('global.app_action')</th>
                            @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data->details as $detail)
                            <tr>
                                <td>{{$detail->pegawai->name}}</td>
                                @if(Sentinel::getUser()->hasAccess(['tugasde.updt']) || Sentinel::getUser()->hasAccess(['tugasde.destroy']))
                                <td>
                                    @if(Sentinel::getUser()->hasAccess(['tugasde.destroy']))
                                    <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirmdeletedetail({{$detail->id}})">@lang('global.app_delete')</a>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                <a href="{{route('tugas.index')}}?jenis_perintah={{$jenis_perintah}}" class="btn btn-success btn-bold">
                    Selesai
                </a>
                @if(Sentinel::getUser()->hasAccess(['tugas.cetak']))
                <a href="{{route('tugas.cetak',$data->id)}}" class="btn btn-primary btn-bold" target="blank">
                    Cetak Surat Tugas
                </a>
                @endif
                @if(Sentinel::getUser()->hasAccess(['tugas.cetak']) && $data->jenis_perintah==1)
                <a href="{{route('perintah.create',$data->id)}}" class="btn btn-primary btn-bold">
                    Buat Surat SPPD
                </a>
                @endif
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>


<!--begin::Modal-->
<div class="modal fade" id="f_modal_create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pegawai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      {{ Form::open(array('url' => route('tugasde.add',$data->id), 'files' => true, 'id'=>'form_inventorisDetail_create')) }}
        <div class="modal-body">
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">Nama Pegawai:</label>
              </div>
              <div class="kt-form__control">
                {!! Form::select('pegawai', $pegawai, null, ['class' => 'form-control kt-select2 myselect2', 'id'=>'s_pegawai_create']) !!}
                @error('pegawai')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
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


{!! Form::open(['method'=>'DELETE', 'route' => ['tugasde.destroy', 0], 'style' => 'display:none','id'=>'deleted_f']) !!}
{!! Form::close() !!}

{!! Form::open(['method'=>'DELETE', 'route' => ['kwitansi.destroy', 0], 'style' => 'display:none','id'=>'deleted_k']) !!}
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
                text: "Tambah Pegawai",
                className: "btn btn-outline-primary",
                action: function ( e, dt, node, config ) {
                    openmodalcreate();
                }
            }
        ]
        @endif
      });

    });

    jQuery(document).ready(function() {
      var table = $('#tbl_kwitansi').DataTable({
        responsive: true,
        searchDelay: 500,
        processing: true,
        @if(Sentinel::getUser()->hasAccess(['inventorisDetail.add']))
        dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
        buttons: [
            {
                text: "Tambah Kwitansi",
                className: "btn btn-outline-primary",
                action: function ( e, dt, node, config ) {
                    openmodalcreatekwitansi();
                }
            }
        ]
        @endif
      });

    });

    $('#f_modal_create').on('shown.bs.modal', function () {
        $(".myselect2").select2({
            placeholder: "Select a state",
            allowClear: true
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

    $('#f_modal_create_keluar').on('shown.bs.modal', function () {
        $(".myselect2").select2({
            placeholder: "Select a state",
        });
        $('.myselect2').val(0).change();
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

    function openmodalcreatekeluar() {
      emptyform();
      $('#f_modal_create_keluar').modal('show');
    }

    function openmodalcreatekwitansi() {
      $('#create').toggle(500);
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
      //form create inventoris masuk
      $('#field_sumber_lainnya_create').hide();
      $('#i_sumber_lainnya_create').val('');
      $("#s_sumber_create").val(0).trigger('change');
      $("#d_tanggal_create").val('');
      $("#n_total_create").val(0);

      //form update inventoris masuk
      $('#field_sumber_lainnya_update').hide();
      $('#i_sumber_lainnya_update').val('');
      $("#d_tanggal_update").val('');
      $("#s_sumber_update").val(0).trigger('change');
      $("#n_total_update").val(0);

      //form create inventoris keluar
      $("#k_keterangan_create").val('');

      //form update inventoris keluar
      $("#k_keterangan_update").val('');
      $("#d_tanggal_update_keluar").val('');
      $("#n_total_update_keluar").val(0);
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
              $('#deleted_f').attr('action', "{{route('tugas.index')}}/"+id);
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
              $('#deleted_f').attr('action', base+"/detail-surat-tugas/"+id);
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

    function confirmdeletekwitansi(id) {
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
              $('#deleted_k').attr('action', base+"/kwitansi/"+id);
              $('#deleted_k').submit();
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

    function confirmdeletekeluar(id) {
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
              $('#deleted_f').attr('action', base+"/keluar-inventoris/{{$data->id}}/"+id);
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
