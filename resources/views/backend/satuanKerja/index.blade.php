@php
  $name = __('satuanKerja.title');
@endphp

@extends('layouts.L1')

@section('title') Penerima Donasi @stop

@section('subheader-name') Penerima Donasi @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
    Penerima Donasi
  </a>
@stop

@section('subheader-btn')
  @if (Sentinel::getUser()->hasAccess(['satker.add']))
    <a href="javascript::void(0)" onclick="$('#create').toggle(500);$('#edit').hide(500);" class="btn btn-label-brand btn-bold">@lang('global.app_create') Penerima Donasi</a>
  @endif
@stop

@section('content')

@if (Sentinel::getUser()->hasAccess(['satker.add']))
  @include('backend.satuanKerja.create')
@endif
@if (Sentinel::getUser()->hasAccess(['satker.updt']))
  @include('backend.satuanKerja.edit')
@endif

<div class="kt-portlet kt-portlet--mobile">
  <div class="kt-portlet__head kt-portlet__head--lg">
    <div class="kt-portlet__head-label">
      <span class="kt-portlet__head-icon">
        <i class="kt-font-brand flaticon2-line-chart"></i>
      </span>
      <h3 class="kt-portlet__head-title">
        @lang('global.app_list') Penerima Donasi
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
    <table class="table table-striped- table-bordered table-hover table-checkable" id="tbl_satker">
      <thead>
        <tr>
          <th>NO</th>
          <th>@lang('satuanKerja.field.name')</th>
          <th>@lang('satuanKerja.field.status')</th>
          <th>@lang('global.app_action')</th>
        </tr>
      </thead>


    </table>
    <!--end: Datatable -->
  </div>
</div>
{!! Form::open(['method'=>'DELETE', 'route' => ['satker.destroy', 0], 'style' => 'display:inline','id'=>'form-delete']) !!}
{!! Form::close() !!}

<!--begin::Modal-->
<div class="modal fade" id="modal_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="show_label">Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <img src="https://dinkes.padang.go.id/assets/img/logo.png" alt="" id="img_path" width="230px">
          <br>
          <h4 id="satker_name">Dinas Kesehatan</h4>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--end::Modal-->
@stop

@section('tcss')
<link href="{{asset('theme/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('tjs')
<script src="{{asset('theme/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script type="text/javascript">
  var id_awal = 0;
  jQuery(document).ready(function() {
    var table = $('#tbl_satker').DataTable({
      responsive: true,
      buttons: [
        {
          extend: 'print',
          className: 'btn-inverse',
          exportOptions: {
              columns: [0,1,2]
          }
        },
        'copy',
        {
            extend: 'excel',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0,1,2]
            }
        },
        'csvHtml5',
        {
            extend: 'pdf',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0,1,2]
            }
        }
			],
      searchDelay: 500,
      processing: true,
      // serverSide: true,
      ajax: {
          url: "{{url('api/satuan-kerja')}}?data=all",
          dataSrc: ''
      },
      columns: [
        {data: 'id'},
        {data: 'name'},
				{data: 'status'},
				{data: 'id', responsivePriority: -1},
      ],
      columnDefs: [
        {
          targets: 2,
          title: "@lang('satuanKerja.field.status')",
          render: function(data, type, full, meta) {
            if(data==0) return 'Not Available';
            return 'Available';
          },
        },
        {
          targets: -1,
          title: "@lang('global.app_action')",
          orderable: false,
          render: function(data, type, full, meta) {
            var base = "{{url('/')}}";
            return `<a class="btn btn-success btn-sm" href="javascript:void(0)" onclick="show('`+full.name+`','`+full.path_logo+`');">@lang('global.app_view') Penerima Donasi</a>`+
              @if(Sentinel::getUser()->hasAccess(['satker.updt']))
                   ` <a class="btn btn-success btn-sm" href="javascript::void(0)" onclick="edit(`+data+`,'`+full.status+`','`+full.name+`')">@lang('global.app_edit') Penerima Donasi</a>`+
              @endif
              @if(Sentinel::getUser()->hasAccess(['satker.destroy']))
                   ` <a class="btn btn-danger btn-sm" onclick="delete_satker(`+data+`)" href="javascript::void(0)">@lang('global.app_delete') Penerima Donasi</a>`+
              @endif
                   ``;
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

  function delete_satker(id) {
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
            $('#form-delete').attr('action', "{{route('satker.index')}}/"+id);
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

  function edit(id, status, name) {
    if($('#edit').is(":visible") && id==id_awal){
      $('#edit').hide('500');
    }else{
      $('#edit').show('500');
      $('#e_status').val(status);
      $('#e_name').val(name);
      $('#form-update').attr('action', "{{route('satker.index')}}/"+id);
    }

    $('#create').hide('500');
    id_awal = id;
  }

  function show(satker, logo) {
    var base = "{{url('/')}}";
    var link= base+'/img/logo/'+logo;
    if(logo=='null'){
      link = "https://seojasa.com/wp-content/uploads/2019/08/error-404.jpg";
    }
    $('#img_path').attr("src",link);
    $('#satker_name').html(satker);
    $('#modal_show').modal('show');
  }
</script>
@stop
