
@php
  $name = __('user.title');
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
@if(Sentinel::getUser()->hasAccess(['users.index']))
<a href="{{route('users.index')}}" class="btn btn-default btn-bold">
  @lang('global.app_back_to_list')
</a>
@endif
<div class="btn-group">
  @if(Sentinel::getUser()->hasAccess(['users.edit']))
  <a href="{{route('users.edit',$data->id)}}" class="btn btn-brand btn-bold">
    @lang('global.app_edit')
  </a>
  @endif
  <button type="button" class="btn btn-brand btn-bold dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  </button>
  <div class="dropdown-menu dropdown-menu-right">
    <ul class="kt-nav">
      @if($data->id != Sentinel::getUser()->id)
        @if(sizeof($data->activations) == 0)
          @if (Sentinel::getUser()->hasAccess(['users.activate']))
            <li class="kt-nav__item">
              <a href="javascript::void(0)" onclick="confirmaktivasi('{{route('users.activate', $data->id)}}')" class="kt-nav__link">
                <i class="kt-nav__link-icon flaticon2-safe"></i>
                <span class="kt-nav__link-text">@lang('global.app_active')</span>
              </a>
            </li>
          @endif
        @else
          @if (Sentinel::getUser()->hasAccess(['users.deactivate']))
            <li class="kt-nav__item">
              <a href="javascript::void(0)" onclick="confirmdeaktivasi('{{route('users.deactivate', $data->id)}}')" class="kt-nav__link">
                <i class="kt-nav__link-icon flaticon2-safe"></i>
                <span class="kt-nav__link-text">@lang('global.app_deactive')</span>
              </a>
            </li>
          @endif
        @endif
      @endif
      @if (Sentinel::getUser()->hasAccess(['users.destroy']) && $data->id != Sentinel::getUser()->id)
      <li class="kt-nav__item">
        <a href="javascript::void(0)" onclick="confirmdelete({{$data->id}})" class="kt-nav__link">
          <i class="kt-nav__link-icon flaticon-delete-1"></i>
          <span class="kt-nav__link-text">@lang('global.app_delete')</span>
        </a>
      </li>
      @endif
      @if (Sentinel::getUser()->hasAccess(['users.permissions']))
      <li class="kt-nav__item">
        <a href="{{route('users.permissions',$data->id)}}" class="kt-nav__link">
          <i class="kt-nav__link-icon la la-cog"></i>
          <span class="kt-nav__link-text">@lang('permission.p_title')</span>
        </a>
      </li>
      @endif
    </ul>
  </div>
</div>
@stop

@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <!--Begin::Section-->
  <div class="row justify-content-md-center justify-content-xl-center">
    <div class="kt-section__body">
      <div class="kt-portlet kt-portlet--tabs">
          <div class="kt-portlet__body">
            <div class="tab-content">
              <div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
                <div class="kt-form kt-form--label-right">
                  <div class="kt-form__body">
                    <div class="kt-section kt-section--first">
                      <div class="form-group text-center">
                        @if($data->avatar)
                        <a href="#" class="kt-media">
                          <img src="{{url('img/profile-pict/'.$data->avatar)}}" alt="image" height="90px" width="90px">
                        </a>
                        @else
                        <a href="#" class="kt-media  kt-media--xl kt-media--success">
                          <span>{{Helper::awalan($data->name)}}</span>
                        </a>
                        @endif
                      </div>

                      <div class="form-group row">
                        {!! Form::text('name', $data->name, ['class' => 'form-control', 'placeholder'=>'','disabled'=>'disabled']) !!}
                      </div>
                      <div class="form-group row">
                        {!! Form::text('username', $data->username, ['class' => 'form-control', 'placeholder'=>'','disabled'=>'disabled']) !!}
                      </div>
                      <div class="form-group row">
                        {!! Form::text('last_login', $data->last_login ? Helper::sekianwaktu($data->last_login) :  __('user.users_new'), ['class' => 'form-control', 'disabled'=>'disabled']) !!}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  <!--End::Section-->
  {!! Form::open(['method'=>'DELETE', 'route' => ['users.destroy', 0], 'style' => 'display:none','id'=>'deleted_users_f']) !!}
  {!! Form::close() !!}
</div>
@stop

@section('tcss')
  <link href="{{asset('theme/css/pages/wizard/wizard-4.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('tjs')
  <script src="{{asset('theme/js/pages/custom/user/edit-user.js')}}" type="text/javascript"></script>
  <script src="{{asset('theme/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
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
  </script>
@endsection
