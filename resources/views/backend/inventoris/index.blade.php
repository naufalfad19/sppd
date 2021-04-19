@php
  $name = __('inventoris.title');
  $status = 0;
  $status_name = 'available';
  if(isset($_GET['status'])){
    if($_GET['status']=='available'){
      $status = 1;
    }
    elseif($_GET['status']=='not-available'){
      $status = 0;
    }
    $status_name = $_GET['status'];
  }
@endphp

@extends('layouts.L1')

@section('title') {{$name}} @stop

@section('subheader-name') {{$name}} @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
    {{$name}}
  </a>
@stop

@section('subheader-btn')
  @if (Sentinel::getUser()->hasAccess(['inventoris.create']))
    <a href="{{route('salurkan.create')}}?status={{$status_name}}" class="btn btn-outline-success">Salurkan Bantuan</a>
  @endif
  @if (Sentinel::getUser()->hasAccess(['inventoris.create']))
    <a href="{{route('inventoris.create')}}?status={{$status_name}}" class="btn btn-label-brand btn-bold">@lang('global.app_create') {{$name}}</a>
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
        @lang('global.app_list') @lang('inventoris.title')
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
    <!--begin: Search Form -->
		<form class="kt-form kt-form--fit kt-margin-b-20">
			<div class="row kt-margin-b-20">
				<div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
					<label>Gudang:</label>
					<select class="form-control kt-input myselect2" data-col-index="1">
						<option value="">Select</option>
					</select>
				</div>
				<div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
					<label>@lang('inventoris.field.barang'):</label>
          <select class="form-control kt-input myselect2" data-col-index="2">
						<option value="">Select</option>
					</select>
				</div>
        <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
					<label>@lang('inventoris.field.satuan'):</label>
          <select class="form-control kt-input myselect2" data-col-index="3">
						<option value="">Select</option>
					</select>
				</div>
        <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
					<label>@lang('inventoris.field.total'):</label>
					<input type="text" class="form-control kt-input" placeholder="@lang('inventoris.field.total')" data-col-index="4">
				</div>

			</div>

			<!-- <div class="kt-separator kt-separator--md kt-separator--dashed"></div> -->

			<div class="row">
				<div class="col-lg-12 text-center">
					<button class="btn btn-primary btn-brand--icon" id="kt_search">
						<span>
							<i class="la la-search"></i>
							<span>Search</span>
						</span>
					</button>
					&nbsp;&nbsp;
					<button class="btn btn-secondary btn-secondary--icon" id="kt_reset">
						<span>
							<i class="la la-close"></i>
							<span>Reset</span>
						</span>
					</button>
				</div>
			</div>
		</form>
    <!--begin: Datatable -->
    <table class="table table-striped- table-bordered table-hover table-checkable" id="tbl_inventoris">
      <thead>
        <tr>
          <th>No</th>
          <th>Gudang</th>
          <th>@lang('inventoris.field.barang')</th>
          <th>@lang('inventoris.field.satuan')</th>
          <th>@lang('inventoris.field.total')</th>
          <th>@lang('global.app_action')</th>
        </tr>
      </thead>

    </table>
    <!--end: Datatable -->
  </div>
</div>
{!! Form::open(['method'=>'DELETE', 'route' => ['inventoris.destroy', 0], 'style' => 'display:inline','id'=>'form-delete']) !!}
{!! Form::close() !!}

<!--begin::Modal-->
<div class="modal fade" id="f_modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      {{ Form::open(array('method'=>'PATCH', 'url' => '#', 'files' => true, 'id'=>'form_edit')) }}
        <div class="modal-body">
          <div class="col-md-12">
            <div class="kt-form__group--inline">
              <div class="kt-form__label">
                <label class="kt-label m-label--single">@lang('inventorisRequest.field.barang'):</label>
              </div>
              <div class="kt-form__control">
                {!! Form::select('barang', $barang, null, ['class' => 'form-control kt-select2 myselect2', 'id'=>'s_barang_update']) !!}
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
                {!! Form::select('satuan', $satuan, null, ['class' => 'form-control kt-select2 myselect2', 'id'=>'s_satuan_update']) !!}
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

@stop

@section('tcss')
<link href="{{asset('theme/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('tjs')
<script src="{{asset('theme/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script type="text/javascript">
  var id_awal = 0;
  jQuery(document).ready(function() {
    $.fn.dataTable.Api.register('column().title()', function() {
  		return $(this.header()).text().trim();
  	});

    var table = $('#tbl_inventoris').DataTable({
      responsive: true,
			dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
      lengthMenu: [5, 10, 25, 50],

      pageLength: 10,

      language: {
        'lengthMenu': 'Display _MENU_',
      },
      buttons: [
        {
          extend: 'print',
          className: 'btn-inverse',
          exportOptions: {
              columns: [0, 1, 2, 3, 4]
          }
        },
        'copy',
        {
            extend: 'excel',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0, 1, 2, 3, 4]
            }
        },
        'csvHtml5',
        {
            extend: 'pdf',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0, 1, 2, 3, 4]
            }
        }
			],
      searchDelay: 500,
      processing: true,
      // serverSide: true,
      ajax: {
          url: "{{url('api/inventoris')}}?data=all&status={{$status}}",
          dataSrc: ''
      },
      columns: [
        {data: 'id'},
        {data: 'satker'},
        {data: 'barang'},
        {data: 'satuan'},
				{data: 'total'},
				{data: 'id', responsivePriority: -1},
      ],
      initComplete: function() {
				this.api().columns().every(function() {
					var column = this;

					switch (column.index()) {
						case 1:
							column.data().unique().sort().each(function(d, j) {
								$('.kt-input[data-col-index="1"]').append('<option value="' + d + '">' + d + '</option>');
							});
							break;
            case 2:
							column.data().unique().sort().each(function(d, j) {
								$('.kt-input[data-col-index="2"]').append('<option value="' + d + '">' + d + '</option>');
							});
							break;
            case 3:
							column.data().unique().sort().each(function(d, j) {
								$('.kt-input[data-col-index="3"]').append('<option value="' + d + '">' + d + '</option>');
							});
							break;
					}
				});
			},
      columnDefs: [
        {
          targets: -1,
          title: "@lang('global.app_action')",
          orderable: false,
          render: function(data, type, full, meta) {
            var base = "{{url('/')}}";
            return ``+
              @if(Sentinel::getUser()->hasAccess(['inventoris.updt']))
                   ` <a class="btn btn-success btn-sm" href="javascript::void(0)" onclick="edit_inventoris(`+data+`,`+full.barang_id+`,`+full.satuan_id+`)">@lang('global.app_edit')</a>`+
              @endif
              @if(Sentinel::getUser()->hasAccess(['inventoris.show']))
                   ` <a class="btn btn-success btn-sm" href="`+base+'/inventoris/'+data+`">@lang('global.app_detail')</a>`+
              @endif
              @if(Sentinel::getUser()->hasAccess(['inventoris.destroy']))
                   ` <a class="btn btn-danger btn-sm" onclick="delete_inventoris(`+data+`)" href="javascript::void(0)">@lang('global.app_delete')</a>`+
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

    var filter = function() {
			var val = $.fn.dataTable.util.escapeRegex($(this).val());
			table.column($(this).data('col-index')).search(val ? val : '', false, false).draw();
		};

    var asdasd = function(value, index) {
			var val = $.fn.dataTable.util.escapeRegex(value);
			table.column(index).search(val ? val : '', false, true);
		};

		$('#kt_search').on('click', function(e) {
			e.preventDefault();
			var params = {};
			$('.kt-input').each(function() {
				var i = $(this).data('col-index');
				if (params[i]) {
					params[i] += '|' + $(this).val();
				}
				else {
					params[i] = $(this).val();
				}
			});
			$.each(params, function(i, val) {
				// apply search params to datatable
				table.column(i).search(val ? val : '', false, false);
			});
			table.table().draw();
		});

		$('#kt_reset').on('click', function(e) {
			e.preventDefault();
			$('.kt-input').each(function() {
				$(this).val('');
				table.column($(this).data('col-index')).search('', false, false);
			});
			table.table().draw();
		});

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
  function delete_inventoris(id) {
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
            $('#form-delete').attr('action', "{{route('inventoris.index')}}/"+id);
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

  function emptyform() {
    $("#d_tanggal_awal").val('');
    $("#d_tanggal_akhir").val('');
  }

  function edit_inventoris(id, barang, satuan) {
    $("#s_barang_update").val(barang).trigger('change');
    $("#s_satuan_update").val(satuan).trigger('change');
    $('#f_modal_edit').modal('show');
    var base = "{{url('/')}}";
    $('#form_edit').attr('action', base+'/inventoris/'+id);
  }

  $('#f_modal_edit').on('shown.bs.modal', function () {
      $(".myselect2").select2({
          placeholder: "Select a state",
      });
  });

  $(".myselect2").select2({
      placeholder: "Select a state",
      allowClear: true
  });
  $('.myselect2').val(0).change();
</script>
@stop
