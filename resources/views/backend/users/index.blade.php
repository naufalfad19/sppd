
@php
  $name = __('user.title');
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
@if (Sentinel::getUser()->hasAccess(['users.create']))
<div class="btn-group">
  <a href="{{route('users.create')}}" class="btn btn-label-brand btn-bold">@lang('global.app_create') {{$name}}</a>
</div>
@endif
@stop

@section('content')

<!--Begin::Section-->
<div class="row">
  @foreach($datas as $data)
    @include('backend.users.index_t.v1')
  @endforeach

  {!! Form::open(['method'=>'DELETE', 'route' => ['users.destroy', 0], 'style' => 'display:none','id'=>'deleted_users_f']) !!}
  {!! Form::close() !!}
</div>
<!--End::Section-->
<div class="row">
  <div class="col-xl-12">
    <!--begin:: Components/Pagination/Default-->
    <div class="kt-portlet text-center">
      <div class="kt-portlet__body text-center">
        {{ $datas->links() }}
      </div>
    </div>
    <!--end:: Components/Pagination/Default-->
  </div>
</div>

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
