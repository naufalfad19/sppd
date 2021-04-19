
@php
  $name = __('user.title');
@endphp
@extends('layouts.L1')

@section('title') {{$name}} @lang('permission.p_title')@stop

@section('subheader-name') {{$name}} @lang('permission.p_title') @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
    {{$name}} @lang('permission.p_title')
  </a>
@stop

@section('subheader-btn')
  <a href="{{route('users.index')}}" class="btn btn-default btn-bold">
    @lang('global.app_back_to_list')
  </a>
  <div class="btn-group">
    <button type="button" class="btn btn-brand btn-bold" onclick="$('#f_create').click()">
      @lang('global.app_save')
    </button>
  </div>
@stop

@section('tjs')
  <script type="text/javascript">
    $('.myselects2').select2({
        placeholder: "@lang('global.app_select_a_value')"
    });
  </script>
  <script src="{{asset('theme/js/pages/crud/forms/widgets/select2.js')}}" type="text/javascript"></script>
@stop

@section('content')
  <div class="kt-portlet kt-portlet--tabs">
      <div class="kt-portlet__body">
        {{ Form::open(array('url' => route('users.simpan',$user->id) )) }}
          <div class="tab-content">
            <div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
              <div class="kt-form kt-form--label-right">
                <div class="kt-form__body">
                  <div class="kt-section kt-section--first">

                    @foreach($actions as $action)
                      <div class="form-group row">
                          <?php
                            $first= array_values($action)[0];
                            $firstname =explode(".", $first)[0];
                          ?>
                          {{Form::label($firstname, $firstname, ['class' => 'col-xl-3 col-lg-3 col-form-label'])}}
                          <div class="col-lg-9 col-xl-6">
                              <select name="permissions[]" class="form-control kt-select2 myselects2" multiple="multiple">
                                  @foreach($action as $act)
                                      @if(explode(".", $act)[0]=="api")
                                          <option value="{{$act}}" {{array_key_exists($act, $user->permissions)?"selected":""}}>
                                          {{isset(explode(".", $act)[2])?explode(".", $act)[1].".".explode(".", $act)[2]:explode(".", $act)[1]}}</option>
                                      @else
                                          <option value="{{$act}}" {{array_key_exists($act, $user->permissions)?"selected":""}}>

                                          {{explode(".", $act)[1]}}

                                          </option>
                                      @endif
                                  @endforeach
                              </select>
                          </div>
                      </div>
                    @endforeach

                  </div>
                  <div class="text-center">
                    <button class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" name="button" id="f_create">
                      @lang('global.app_save')
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        {{ Form::close() }}
      </div>
    </div>
@stop
