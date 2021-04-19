
@php
  $name = __('inventorisRequest.title');
  $status = "proses";
  if(isset($_GET['status'])){
    $status = $_GET['status'];
  }
  $cek=0;
@endphp
@extends('layouts.L1')

@section('title') @lang('global.app_detail') Donasi @stop

@section('subheader-name') @lang('global.app_detail') Donasi @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript:void(0)" class="kt-subheader__breadcrumbs-link">
    @lang('global.app_detail') Donasi
  </a>
@stop

@section('subheader-btn')
  @if(Sentinel::getUser()->hasAccess(['inreq.index']))
  <a href="{{route('inreq.index')}}{{Sentinel::getUser()->hasAccess('inreq.all-data') ? '?status='.$status : ''}}" class="btn btn-default btn-bold">
    @lang('global.app_back_to_list')
  </a>
  @endif

  @if(Sentinel::getUser()->hasAccess(['inreq.destroy']) && $data->status==0)
  <a href="javascript:void(0)" onclick="confirmdelete({{$data->id}})" class="btn btn-danger btn-bold">
    @lang('global.app_delete')
  </a>
  @endif

  @if($data->status==1)
  <a href="{{url('request-inventoris/cetak/'.$data->id)}}" target="_blank" class="btn btn-success btn-bold">
    Print
  </a>
  @endif
@stop

@section('content')

<div class="kt-portlet kt-portlet--mobile">
  <div class="kt-portlet__body">
    <!--begin: Datatable -->
    <table class="table table-striped table-checkable" id="tbl_inreq">
      <thead>
        <tr>
          <th>@lang('inventorisRequest.show.tanggal_request')</th>
          <th>: {{$data->tanggal}}</th>
          <th>@lang('inventorisRequest.show.status')</th>
          <th>: @if($data->status==0) Diproses @elseif($data->status==1) Disetujui @else Ditolak @endif</th>
          <th></th>
          <th></th>
        </tr>
        <tr>
          <th>@lang('inventorisRequest.field.satker')</th>
          <th>: {{$data->satker->name}}</th>
          <th>@lang('inventorisRequest.field.update')</th>
          <th>: {{$data->updated_at}}</th>
          <th></th>
          <th></th>
        </tr>
      </thead>


    </table>
    <!--end: Datatable -->
    <br><hr>
    <table class="table table-striped- table-bordered table-hover table-checkable" id="tbl_inreqde">
      <thead>
        <tr>
          <th>@lang('inventorisRequest.field.barang')</th>
          <th>@lang('inventorisRequest.field.satuan')</th>
          <th>@lang('inventorisRequest.field.total')</th>
          <th>@lang('inventorisRequest.show.status')</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data->details as $detail)
          <tr>
            <td>{{$detail->barang->name}}</td>
            <td>{{$detail->satuan->name}}</td>
            <td>{{$detail->total}}</td>
            <td>@if($detail->status==0) Diproses @elseif($detail->status==1) Disetujui @else Ditolak ({{$detail->pesan}}) @endif</td>
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
      {{ Form::open(array('url' => '#', 'files' => true, 'id'=>'form_inreqde_create')) }}
        <div class="modal-body">
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">@lang('inventorisRequest.field.barang'):</label>
              </div>
              <div class="kt-form__control">
                {!! Form::select('barang', $barang, null, ['class' => 'form-control kt-select2 myselect2', 'id'=>'s_barang_create']) !!}
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
                {!! Form::select('satuan', $satuan, null, ['class' => 'form-control kt-select2 myselect2', 'id'=>'s_satuan_create']) !!}
                @error('satuan')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
          <div class="col-md-12">
              <div class="kt-form__group--inline">
                <div class="kt-form__label">
                  <label class="kt-label m-label--single">@lang('inventorisRequest.field.total'):</label>
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
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      {{ Form::open(array('method'=>'PATCH', 'url' => '#', 'files' => true, 'id'=>'form_inreqde_edit')) }}
        <div class="modal-body">
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">@lang('inventorisRequest.field.barang'):</label>
              </div>
              <div class="kt-form__control">
                {!! Form::select('barang', $barang, null, ['class' => 'form-control kt-select2 myselect2', 'id'=>'s_barang_update', Sentinel::getUser()->hasAccess('inventoris.all-data') ? 'disabled' : '']) !!}
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
                {!! Form::select('satuan', $satuan, null, ['class' => 'form-control kt-select2 myselect2', 'id'=>'s_satuan_update', Sentinel::getUser()->hasAccess('inventoris.all-data') ? 'disabled' : '']) !!}
                @error('satuan')
                  <div class="form-text text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
          <div class="col-md-12">
              <div class="kt-form__group--inline">
                <div class="kt-form__label">
                  <label class="kt-label m-label--single">@lang('inventorisRequest.field.total'):</label>
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
<div class="modal fade" id="f_modal_reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pesan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      {{ Form::open(array('method'=>'PUT', 'url' => '#', 'files' => true, 'id'=>'form_inreqde_reject')) }}
        <div class="modal-body">
          <div class="col-md-12">
              <div class="kt-form__group--inline">
                <div class="kt-form__label">
                  <label class="kt-label m-label--single">@lang('inventorisRequest.field.pesan'):</label>
                </div>
                <div class="kt-form__control">
                  <textarea  name="pesan" class="form-control" id="n_pesan_update">
                  </textarea>
                  @error('pesan')
                    <div class="form-text text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="d-md-none kt-margin-b-10"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="btn_form" type="submit" class="btn btn-danger">@lang('global.app_descline')</button>
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
<!--end::Modal-->


<!--begin::Modal-->
<div class="modal fade" id="f_modal_acc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sumber</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      {{ Form::open(array('method'=>'PATCH', 'url' => '#', 'files' => true, 'id'=>'form_inreqde_acc')) }}
        <div class="modal-body">
          <div class="col-md-12">
            <div class="kt-form__group--inline">
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="tbl">
              <thead>
              <tr>
			        	<th >No</th>
                <th >total</th>
                <th >Sumber</th>
			        	<th >Nama Barang</th>
                <th >Satuan</th>
			        	<th >Pilih</th>
			        </tr>
              </thead>

            </table>
            <!--end: Datatable -->
            </div>
            <div class="d-md-none kt-margin-b-10"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="btn_form" type="submit" class="btn btn-success">@lang('global.app_acc')</button>
        </div>
        {{ Form::close() }}
    </div>
  </div>
</div>
<!--end::Modal-->



{!! Form::open(['method'=>'DELETE', 'route' => ['inreq.destroy', 0], 'style' => 'display:none','id'=>'deleted_f']) !!}
{!! Form::close() !!}
{!! Form::open(['method'=>'PATCH', 'route' => ['inreq.acc', 0], 'style' => 'display:none','id'=>'acc_f']) !!}
{!! Form::close() !!}
{!! Form::open(['method'=>'PATCH', 'route' => ['inreq.acc_one', 0], 'style' => 'display:none','id'=>'accOne_f']) !!}
{!! Form::close() !!}
{!! Form::open(['method'=>'PUT', 'route' => ['inreq.reject', 0], 'style' => 'display:none','id'=>'reject_f']) !!}
{!! Form::close() !!}


@stop

@section('tcss')
<link href="{{asset('theme/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('tjs')
  <script src="{{asset('theme/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    jQuery(document).ready(function() {
      var table = $('#tbl_inreqde').DataTable({
        responsive: true,
        searchDelay: 500,
        processing: true,
        @if($data->status==0)
        dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
        buttons: [
          @if(Sentinel::getUser()->hasAccess(['inreq.acc']))
          {
            text: "Terkirim",
            className: "btn btn-outline-success",
            action: function ( e, dt, node, config ) {
              confirmAcc({{$data->id}});
            }
          },
          @endif
          @if(Sentinel::getUser()->hasAccess(['inreq.reject']))
          {
            text: "Batalkan",
            className: "btn btn-outline-danger",
            action: function ( e, dt, node, config ) {
              openmodalreject();
            }
          },
          @endif
        ]
        @endif
      });
    });



    $('#f_modal_create').on('shown.bs.modal', function () {
        $(".myselect2").select2({
            placeholder: "Select a state",
        });
        $('.myselect2').val(0).change();
    });

    $('#f_modal_edit').on('shown.bs.modal', function () {
        $(".myselect2").select2({
            placeholder: "Select a state",
        });
    });

    function openmodalcreate() {
      emptyform();
      $('#f_modal_create').modal('show');
      $('#form_inreqde_create').attr('action', "{{route('inreqde.add',$data->id)}}");
    }

    function openmodalreject() {
      emptyform();
      $('#f_modal_reject').modal('show');
      $('#form_inreqde_edit').attr('action', "{{route('inreq.reject',$data->id)}}");
    }

    function openmodalacc() {
      emptyform();
      $('#f_modal_acc').modal('show');
      $('#form_inreqde_edit').attr('action', "{{route('inreq.reject',$data->id)}}");
    }

    function editmodal(detail) {
      emptyform();
      $("#s_barang_update").val(detail.barang_id).trigger('change');
      $("#s_satuan_update").val(detail.satuan_id).trigger('change');
      $("#n_total_update").val(detail.total);
      $('#f_modal_edit').modal('show');
      var base = "{{url('/')}}";
      $('#form_inreqde_edit').attr('action', base+'/detail-request-inventoris/'+detail.id);
    }

    function rejectOnemodal(detail) {
      emptyform();
      $("#n_pesan_update").val(detail.pesan);
      $('#f_modal_reject').modal('show');
      var base = "{{url('/')}}";
      $('#form_inreqde_reject').attr('action', "reject_one/"+detail.id);
    }

    function accOnemodal(detail) {
      let base_url = "{{url('/')}}";
      $('#f_modal_acc').modal('show');
      jQuery(document).ready(function() {
      var table = $('#tbl').DataTable({
        responsive: true,
        searchDelay: 500,
        processing: true,

        ajax: {
            url: base_url+"/api/acc-inventoris/"+detail.barang_id+"/"+detail.satuan_id,
            dataSrc: ''
        },
        columns: [
          {data: 'id'},
          {data: 'total'},
          {data: 'sumber_name'},
          {data: 'barang_name'},
          {data: 'satuan_name'},
		  		{data: 'id', responsivePriority: -1},
        ],
        columnDefs: [
          {
            targets: -1,
            title: "@lang('global.app_action')",
            orderable: false,
            render: function(data, type, full, meta) {
              var base = "{{url('/')}}";
              var hasil = ``+
                     ` <input type="radio" name="sumber" value="`+data+`"/>`+
                     ``;
              return hasil
            },
          },
        ],
      });
      table.on( 'order.dt search.dt', function () {
         table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
             cell.innerHTML = i+1;
         } );
      } ).draw();
    });
    $("#tbl").DataTable().destroy()
      var base = "{{url('/')}}";
      $('#form_inreqde_acc').attr('action', "acc_one/"+detail.id);
    }

    function emptyform() {
      $("#s_sumber_update").val(0).trigger('change');
      $("#s_barang_create").val(0).trigger('change');
      $("#s_satuan_create").val(0).trigger('change');
      $("#n_total_create").val(0);
      $("#s_barang_update").val(0).trigger('change');
      $("#s_satuan_update").val(0).trigger('change');
      $("#n_total_update").val(0);
      $("#n_pesan_update").val();
      $("#s_keterangan_update").val(0).trigger('change');
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
              $('#deleted_f').attr('action', "{{route('inreq.index')}}/"+id);
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

    function confirmAcc(id) {
      swal.fire({
          title: "Terima Donasi Ini?",
          text: "Donasi yang diterima akan masuk ke dalam inventori",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: "@lang('global.app_acc_confirm')",
          cancelButtonText: "@lang('global.app_acc_cancel')",
          reverseButtons: true
      }).then(function(result){
          if (result.value) {
              swal.fire(
                  "@lang('global.app_acc_confirm_massage_1')",
                  "Barang telah dikirim",
                  'success'
              )
              $('#acc_f').attr('action', "{{route('inreq.index')}}/"+id);
              $('#acc_f').submit();
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
    function confirmAccOne(id) {
      swal.fire({
          title: "@lang('global.app_acc_ask')",
          text: "@lang('global.app_acc_description')",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: "@lang('global.app_acc_confirm')",
          cancelButtonText: "@lang('global.app_acc_cancel')",
          reverseButtons: true
      }).then(function(result){
          if (result.value) {
              swal.fire(
                  "@lang('global.app_acc_confirm_massage_1')",
                  "@lang('global.app_acc_confirm_massage_2')",
                  'success'
              )
              $('#accOne_f').attr('action', "acc_one/"+id);
              $('#accOne_f').submit();
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

    function confirmReject(id) {
      swal.fire({
          title: "@lang('global.app_acc_ask')",
          text: "@lang('global.app_acc_description')",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: "@lang('global.app_reject_confirm')",
          cancelButtonText: "@lang('global.app_acc_cancel')",
          reverseButtons: true
      }).then(function(result){
          if (result.value) {
              swal.fire(
                  "@lang('global.app_reject_confirm_massage_1')",
                  "@lang('global.app_reject_confirm_massage_2')",
                  'success'
              )
              $('#reject_f').attr('action', "{{route('inreq.index')}}/"+id);
              $('#reject_f').submit();
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
              $('#deleted_f').attr('action', base+'/detail-request-inventoris/'+id);
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
  </script>
@endsection
