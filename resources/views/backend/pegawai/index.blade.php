
@php
  $name = 'Pegawai';
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
@if (Sentinel::getUser()->hasAccess(['pegawai.create']))
<div class="btn-group">
  <a href="{{route('pegawai.create')}}" class="btn btn-label-brand btn-bold">@lang('global.app_create') {{$name}}</a>
</div>
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
        @lang('global.app_list') Pegawai
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
    <table class="table table-striped- table-bordered table-hover table-checkable" id="tbl_roles">
      <thead>
        <tr>
          <th>No</th>
          <th>NIP</th>
          <th>@lang('sumber.r_field.r_name')</th>
          <th>TTL</th>
          <th>Pangkat / Golongan</th>
          <th>Jabatan</th>
          <th>@lang('global.app_action')</th>
        </tr>
      </thead>


    </table>
    <!--end: Datatable -->
  </div>
</div>
{!! Form::open(['method'=>'DELETE', 'route' => ['roles.destroy', 0], 'style' => 'display:inline','id'=>'form-delete']) !!}
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
    var table = $('#tbl_roles').DataTable({
      responsive: true,
      buttons: [
        {
          extend: 'print',
          className: 'btn-inverse',
          exportOptions: {
              columns: [0,1]
          }
        },
        'copy',
        {
            extend: 'excel',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0,1]
            }
        },
        'csvHtml5',
        {
            extend: 'pdf',
            className: 'btn-inverse',
            exportOptions: {
                columns: [0,1]
            }
        }
			],
      searchDelay: 500,
      processing: true,
      // serverSide: true,
      ajax: {
          url: "{{url('api/pegawai')}}?data=all",
          dataSrc: ''
      },
      columns: [
				{data: 'id'},
				{data: 'nip'},
				{data: 'name'},
				{data: 'ttl'},
				{data: 'pangkat'},
				{data: 'jabatan'},
				{data: 'id', responsivePriority: -1},
      ],
      columnDefs: [
        {
          targets: -1,
          title: "@lang('global.app_action')",
          orderable: false,
          render: function(data, type, full, meta) {
            var base = "{{url('/')}}";
            return ``+
              @if(Sentinel::getUser()->hasAccess(['pegawai.updt']))
                   ` <a class="btn btn-success btn-sm" href="`+base+'/pegawai/edit/'+data+`">@lang('global.app_edit') {{$name}}</a>`+
              @endif
              @if(Sentinel::getUser()->hasAccess(['pegawai.destroy']))
                   ` <a class="btn btn-danger btn-sm" onclick="delete_pegawai(`+data+`)" href="javascript::void(0)">@lang('global.app_delete') {{$name}}</a>`+
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
  function delete_pegawai(id) {
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
            $('#form-delete').attr('action', "{{route('pegawai.index')}}/"+id);
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

  function edit(id, name) {
    if($('#edit').is(":visible") && id==id_awal){
      $('#edit').hide('500');
    }else{
      $('#edit').show('500');
      $('#e_name').val(name);
      $('#form-update').attr('action', "{{route('pegawai.index')}}/"+id);
    }

    $('#create').hide('500');
    id_awal = id;
  }
</script>

@stop

@section('tjs')
  <script type="text/javascript">
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
              $('#deleted_users_f').attr('action', "{{route('users.index')}}/"+id);
              $('#deleted_users_f').submit();
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

    function confirmaktivasi(link) {
      event.preventDefault();
      swal.fire({
          title: "@lang('user.users_actived_ask')",
          text: "@lang('user.users_actived_description')",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: "@lang('user.users_actived_confirm')",
          cancelButtonText: "@lang('user.users_actived_cancel')",
          reverseButtons: true
      }).then(
        function(result){
          if (result.value) {
              swal.fire(
                  "@lang('user.users_actived_confirm_massage_1')",
                  "@lang('user.users_actived_confirm_massage_2')",
                  'success'
              )
              window.open(link,"_self");
          } else if (result.dismiss === 'cancel') {
              swal.fire(
                  "@lang('global.app_delete_cancel')",
                  "@lang('user.users_actived_cancel_massage_2')",
                  'warning'
              )
          }
      });
    }

    function confirmdeaktivasi(link) {
      event.preventDefault();
      swal.fire({
          title: "@lang('user.users_deactived_ask')",
          text: "@lang('user.users_deactived_description')",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: "@lang('user.users_deactived_confirm')",
          cancelButtonText: "@lang('user.users_deactived_cancel')",
          reverseButtons: true
      }).then(
        function(result){
          if (result.value) {
              swal.fire(
                  "@lang('user.users_deactived_confirm_massage_1')",
                  "@lang('user.users_deactived_confirm_massage_2')",
                  'success'
              )
              window.open(link,"_self");
          } else if (result.dismiss === 'cancel') {
              swal.fire(
                  "@lang('global.app_delete_cancel')",
                  "@lang('user.users_deactived_cancel_massage_2')",
                  'warning'
              )
          }
      });
    }

    function get_Selected_id() {
      var searchIDs = $("input[name=sel]:checked").map(function(){
        return $(this).val();
      }).get();
      return searchIDs;
    }

    $("#delete_all").click(function(event){
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
              var value=get_Selected_id();
              if (value!='') {
               $.ajax({
                  type: "POST",
                  cache: false,
                  url : "{{action('backend\UserController@ajax_all')}}",
                  data: {"_token": "{{ csrf_token() }}",all_id:value,action:'delete'},
                      success: function(data) {
                        location.reload()
                      }
                  })
              }else{return confirm("@lang('user.users_any_item_selected')");}
          } else if (result.dismiss === 'cancel') {
              swal.fire(
                  "@lang('global.app_deleted_cancel_massage_1')",
                  "@lang('global.app_deleted_cancel_massage_2')",
                  'error'
              )
              event.preventDefault();
          }
      });
    });
  //End Delete All Function
  //Start Deactivate all Function
    $("#deactivate_all").click(function(event){
      event.preventDefault();
      swal.fire({
          title: "@lang('user.users_deactived_ask_selected')",
          text: "@lang('user.users_deactived_description_selected')",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: "@lang('user.users_deactived_confirm')",
          cancelButtonText: "@lang('user.users_deactived_cancel')",
          reverseButtons: true
      }).then(
        function(result){
          if (result.value) {
              swal.fire(
                  "@lang('user.users_deactived_confirm_massage_1')",
                  "@lang('user.users_deactived_confirm_massage_2_selected')",
                  'success'
              )
              var value=get_Selected_id();
              if (value!='') {
               $.ajax({
                  type: "POST",
                  cache: false,
                  url : "{{action('backend\UserController@ajax_all')}}",
                  data: {"_token": "{{ csrf_token() }}",all_id:value,action:'deactivate'},
                      success: function(data) {
                        location.reload()
                      }
                  })
              }
              else{
                swal.fire(
                    "@lang('global.app_delete_cancel')",
                    "@lang('user.users_any_item_selected')",
                    'warning'
                )
              }
          } else if (result.dismiss === 'cancel') {
              swal.fire(
                  "@lang('global.app_delete_cancel')",
                  "@lang('user.users_deactived_cancel_massage_2_selected')",
                  'warning'
              )
          }
      });
    });
    //End Deactivate Function
      //Start Activate all Function
    $("#activate_all").click(function(event){
      event.preventDefault();
      swal.fire({
          title: "@lang('user.users_actived_ask_selected')",
          text: "@lang('user.users_actived_description_selected')",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: "@lang('user.users_actived_confirm')",
          cancelButtonText: "@lang('user.users_actived_cancel')",
          reverseButtons: true
      }).then(
        function(result){
          if (result.value) {
              swal.fire(
                  "@lang('user.users_actived_confirm_massage_1')",
                  "@lang('user.users_actived_confirm_massage_2_selected')",
                  'success'
              )
              var value=get_Selected_id();
              if (value!='') {
               $.ajax({
                  type: "POST",
                  cache: false,
                  url : "{{action('backend\UserController@ajax_all')}}",
                  data: {"_token": "{{ csrf_token() }}",all_id:value,action:'activate'},
                      success: function(data) {
                        location.reload()
                      }
                  })
              }
              else{
                swal.fire(
                    "@lang('global.app_delete_cancel')",
                    "@lang('user.users_any_item_selected')",
                    'warning'
                )
              }
          } else if (result.dismiss === 'cancel') {
              swal.fire(
                  "@lang('global.app_delete_cancel')",
                  "@lang('user.users_actived_cancel_massage_2_selected')",
                  'warning'
              )
          }
      });
    });
  </script>
@endsection
