@php
  $name = __('inventorisRequest.title');
  $status = 0;
  if(isset($_GET['status'])){
    if($_GET['status']=='proses'){
      $status = 0;
    }
    elseif($_GET['status']=='terima'){
      $status = 1;
    }
    elseif($_GET['status']=='tolak'){
      $status = 2;
    }
  }
@endphp

@extends('layouts.L1')

@section('title') Donasi @stop

@section('subheader-name') Donasi @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
  Donasi
  </a>
@stop

@section('subheader-btn')
  @if (Sentinel::getUser()->hasAccess(['inreq.create']))
    <a href="{{route('inreq.create')}}" class="btn btn-label-brand btn-bold">Lakukan Donasi</a>
  @endif
@stop

@section('content')
<div class="kt-portlet kt-portlet--mobile">
  <div class="kt-portlet__head kt-portlet__head--lg">
    <div class="kt-portlet__head-label">
      <span class="kt-portlet__head-icon">
        <i class="kt-font-brand flaticon2-line-chart"></i>
      </span>
      <h3 class="kt-portlet__head-title">
        Donasi
      </h3>
    </div>
    <div class="kt-portlet__head-toolbar">
      <div class="kt-portlet__head-wrapper">
        <div class="kt-portlet__head-actions">
          <div class="dropdown dropdown-inline">
            <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="la la-download"></i> @lang('global.app_export.e_title')
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <ul class="kt-nav">
                <li class="kt-nav__section kt-nav__section--first">
                  <span class="kt-nav__section-text">@lang('global.app_export.e_option')</span>
                </li>
                <li class="kt-nav__item">
                  <a href="javascript::void(0)" class="kt-nav__link" id="btn-print">
                    <i class="kt-nav__link-icon la la-print"></i>
                    <span class="kt-nav__link-text">@lang('global.app_export.e_print')</span>
                  </a>
                </li>
                <li class="kt-nav__item">
                  <a href="javascript::void(0)" class="kt-nav__link" id="btn-copy">
                    <i class="kt-nav__link-icon la la-copy"></i>
                    <span class="kt-nav__link-text">@lang('global.app_export.e_copy')</span>
                  </a>
                </li>
                <li class="kt-nav__item">
                  <a href="javascript::void(0)" class="kt-nav__link" id="btn-excel">
                    <i class="kt-nav__link-icon la la-file-excel-o"></i>
                    <span class="kt-nav__link-text">@lang('global.app_export.e_excel')</span>
                  </a>
                </li>
                <li class="kt-nav__item">
                  <a href="javascript::void(0)" class="kt-nav__link" id="btn-csv">
                    <i class="kt-nav__link-icon la la-file-text-o"></i>
                    <span class="kt-nav__link-text">@lang('global.app_export.e_csv')</span>
                  </a>
                </li>
                <li class="kt-nav__item">
                  <a href="javascript::void(0)" class="kt-nav__link" id="btn-pdv">
                    <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                    <span class="kt-nav__link-text">@lang('global.app_export.e_pdf')</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="kt-portlet__body">
    <!--begin: Datatable -->
    <table class="table table-striped- table-bordered table-hover table-checkable" id="tbl_inreq">
      <thead>
        <tr>
          <th>No</th>
          <th>@lang('inventorisRequest.field.tanggal')</th>
          <th>Donatur</th>
          <th>@lang('inventorisRequest.field.total')</th>
          <th>@lang('inventorisRequest.show.status')</th>
          <th>@lang('global.app_action')</th>
        </tr>
      </thead>


    </table>
    <!--end: Datatable -->
  </div>
</div>
{!! Form::open(['method'=>'DELETE', 'route' => ['inreq.destroy', 0], 'style' => 'display:inline','id'=>'form-delete']) !!}
{!! Form::close() !!}
@stop

@section('tcss')
<link href="{{asset('theme/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('tjs')
<script src="{{asset('theme/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script type="text/javascript">
  var id_awal = 0;
  jQuery(document).ready(function() {
    var table = $('#tbl_inreq').DataTable({
      responsive: true,
      buttons: [
        {
          extend: 'print',
          className: 'btn-inverse',
          exportOptions: {
              columns: [0,1,2,4,5]
          }
        },
        'copy',
        {
            extend: 'excel',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0,1,2,4,5]
            }
        },
        'csvHtml5',
        {
            extend: 'pdf',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0,1,2,4,5]
            }
        }
			],
      searchDelay: 500,
      processing: true,
      // serverSide: true,
      ajax: {
          url: "{{url('api/request-inventoris')}}?data=all&status={{$status}}",
          dataSrc: ''
      },
      columns: [
        {data: 'id'},
        {data: 'tanggal'},
        {data: 'satker'},
        {data: 'total'},
				{data: 'status'},
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
              @if(Sentinel::getUser()->hasAccess(['inreq.show']))
                   ` <a class="btn btn-success btn-sm" href="`+base+'/request-inventoris/'+data+`{{isset($_GET['status']) ? '?status='.$_GET['status'] : ''}}">@lang('global.app_detail')</a>`+
              @endif
                   ``;
            if(full.status == "Diproses"){
              hasil = hasil +
              @if(Sentinel::getUser()->hasAccess(['inreq.destroy']))
              ` <a class="btn btn-danger btn-sm" onclick="delete_inreq(`+data+`)" href="javascript::void(0)">@lang('global.app_delete')</a>`+
              @endif
              ``;
            }
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
    $('#btn-print').on('click', function(e) {
			e.preventDefault();
			table.button(0).trigger();
		});
    $('#btn-copy').on('click', function(e) {
			e.preventDefault();
			table.button(1).trigger();
		});
    $('#btn-excel').on('click', function(e) {
			e.preventDefault();
			table.button(2).trigger();
		});
    $('#btn-csv').on('click', function(e) {
			e.preventDefault();
			table.button(3).trigger();
		});
    $('#btn-pdf').on('click', function(e) {
			e.preventDefault();
			table.button(4).trigger();
		});
  });
  function delete_inreq(id) {
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
            $('#form-delete').attr('action', "{{route('inreq.index')}}/"+id);
            $('#form-delete').submit();
        } else if (result.dismiss === 'cancel') {
            swal.fire(
                "@lang('global.app_deleted_cancel_massage_1')",
                "@lang('global.app_deleted_cancel_massage_2')",
                'error'
            )
            return false;
        }
    });
  }
</script>
@stop
