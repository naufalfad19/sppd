
@php
  $name = 'Profile';
@endphp
@extends('layouts.L1')

@section('title') Profile @stop

@section('subheader-name') Profile @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
    Profile
  </a>
@stop

@section('subheader-btn')

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
                          <span>{{Helper::awalan($data->first_name.' '.$data->last_name)}}</span>
                        </a>
                        @endif
                      </div>

                      <div class="form-group row">
                        {!! Form::text('first_name', $data->first_name, ['class' => 'form-control', 'placeholder'=>'','disabled'=>'disabled']) !!}
                      </div>
                      <div class="form-group row">
                        {!! Form::text('last_name', $data->last_name, ['class' => 'form-control', 'disabled'=>'disabled']) !!}
                      </div>
                      <div class="form-group row">
                        {!! Form::text('satker', $data->satker->name, ['class' => 'form-control', 'placeholder'=>'','disabled'=>'disabled']) !!}
                      </div>
                      <div class="form-group row">
                        {!! Form::text('email', $data->email, ['class' => 'form-control', 'placeholder'=>'','aria-describedby'=>'basic-addon1','disabled'=>'disabled']) !!}
                      </div>
                      <div class="form-group row">
                        {!! Form::text('username', $data->username, ['class' => 'form-control', 'placeholder'=>'','disabled'=>'disabled']) !!}
                      </div>
                      <div class="form-group row">
                        {!! Form::text('no_hp', $data->no_hp ? $data->no_hp : '000 000 0000', ['class' => 'form-control', 'disabled'=>'disabled']) !!}
                      </div>
                      <div class="form-group row">
                        {!! Form::text('last_login', $data->last_login ? Helper::sekianwaktu($data->last_login) :  __('user.users_new'), ['class' => 'form-control', 'disabled'=>'disabled']) !!}
                      </div>
                      <div class="form-group row">
                        {!! Form::textarea('alamat', $data->alamat, ['class' => 'form-control', 'disabled'=>'disabled']) !!}
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
</div>
@stop
