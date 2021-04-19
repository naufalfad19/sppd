
@php
$name = __('user.title');
@endphp
@extends('layouts.L1')

@section('title')@lang('global.app_edit') {{$name}} @stop

@section('subheader-name')@lang('global.app_edit') {{$name}} @stop

@section('subheader-link')
<span class="kt-subheader__breadcrumbs-separator"></span>
<a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
    @lang('global.app_edit') {{$name}}
</a>
@stop

@section('subheader-btn')
<a href="{{route('users.index')}}" class="btn btn-default btn-bold">
@lang('global.app_back_to_list')
</a>
<div class="btn-group">
<button type="button" class="btn btn-brand btn-bold" onclick="$('#user_edit_f').click()">
    @lang('global.app_update')
</button>
</div>
@stop

@section('content')
<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__body">
    {{ Form::model($data, array('method' => 'PATCH', 'url' => route('pegawai.updt', $data->id), 'files' => true)) }}
        <div class="tab-content">
        <div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
            <div class="kt-form kt-form--label-right">
            <div class="kt-form__body">
                <div class="kt-section kt-section--first">
                @include('backend.pegawai._field')
                </div>
                <div class="text-center">
                <button class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" name="button" id="user_edit_f">
                    @lang('global.app_update')
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