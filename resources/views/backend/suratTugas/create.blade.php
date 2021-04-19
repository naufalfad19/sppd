@php
$name = 'Surat Tugas';
@endphp
@extends('layouts.L1')

@section('title')@lang('global.app_create') {{$name}} @stop

@section('subheader-name')@lang('global.app_create') {{$name}} @stop

@section('subheader-link')
<span class="kt-subheader__breadcrumbs-separator"></span>
<a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
    @lang('global.app_create') {{$name}}
</a>
@stop

@section('subheader-btn')
<div class="btn-group">
<button type="button" class="btn btn-brand btn-bold" onclick="$('#user_create_f').click()">
    @lang('global.app_save')
</button>
</div>
@stop

@section('content')
<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__body">
    {{ Form::open(array('url' => route('tugas.store'), 'files' => true)) }}
        <div class="tab-content">
        <div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
            <div class="kt-form kt-form--label-right">
            <div class="kt-form__body">
                <div class="kt-section kt-section--first">
                @include('backend.suratTugas._field')
                </div>
                <div class="text-center">
                <button class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" name="button" id="user_create_f">
                    Halaman Selanjutnya
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
