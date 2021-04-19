
  <link rel="stylesheet" href="{{ url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ url('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ url('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ url('plugins/summernote/summernote-bs4.css') }}">
@php
  $name = 'Dashboard';
@endphp
@extends('layouts.L1')

@section('title') {{$name}} @stop

@section('subheader-name') {{$name}} @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="#" class="kt-subheader__breadcrumbs-link">
    {{$name}}
  </a>
@stop

@section('subheader-btn')
  <!-- <a href="{{route('users.create')}}" class="btn btn-label-brand btn-bold">Add User</a> -->
@stop

@section('content')
<div class="container">
<div class="row d-flex justify-content-center">
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{count($surat_tugas)}}</h3>
                <p>Total Surat Tugas</p>
            </div>
            <div class="icon">
                
            </div>
            <a href="{{route('tugas.index')}}" class="small-box-footer">Surat Tugas <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{count($dk)}}</h3>
                <p>Total SP dalam Kota</p>
            </div>
            <div class="icon">
                
            </div>
            <a href="{{route('tugas.index')}}?jenis_perintah=dalam_kota" class="small-box-footer">SP DK <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>


</div>
<div class="row d-flex justify-content-center">    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{count($sppd)}}</h3>
                <p>Total SPPD</p>
            </div>
            <div class="icon">
                
            </div>
            <a href="{{route('tugas.index')}}?jenis_perintah=sppd" class="small-box-footer">SPPD <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{count($non_sppd)}}</h3>
                <p>Total SP Non PD</p>
            </div>
            <div class="icon">
                
            </div>
            <a href="{{route('tugas.index')}}?jenis_perintah=non_sppd" class="small-box-footer">SP Non Pd <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div></div>
</div>


@stop

@section('tjs')

@stop
