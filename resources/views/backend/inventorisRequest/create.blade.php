
@php
  $name = __('inventorisRequest.title');
@endphp
@extends('layouts.L1')

@section('title')@lang('global.app_create') Donasi @stop

@section('subheader-name')@lang('global.app_create') Donasi @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
    @lang('global.app_create') Donasi
  </a>
@stop

@section('subheader-btn')
<a href="{{route('inreq.index')}}" class="btn btn-default btn-bold">
  @lang('global.app_back_to_list')
</a>
<div class="btn-group">
  <button type="button" class="btn btn-brand btn-bold" onclick="$('#create_f').click()">
    @lang('global.app_save')
  </button>
</div>
@stop

@section('content')
<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__body">
      {{ Form::open(array('url' => route('inreq.store'), 'files' => true)) }}
        <div class="tab-content">
          <div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
            <div class="kt-form">
              <div class="kt-form__body">
                <div class="kt-section kt-section--first">
                  <div id="backgound">
                    <div class="form-group form-group-last row repet" id="repet">
                      <!-- <label class="col-lg-2 col-form-label"></label> -->
                      <div data-repeater-list="" class="col-lg-12">
                        <div data-repeater-item class="form-group row align-items-center">
                          <div class="col-md-3">
                            <div class="kt-form__group--inline">
                              <div class="kt-form__label">
                                <label>@lang('inventorisRequest.field.barang'):</label>
                              </div>
                              <div class="kt-form__control">
                                {!! Form::select('barang[]', $barang, null, ['class' => 'form-control kt-select2 myselect2']) !!}
                                @error('barang[]')
                                  <div class="form-text text-danger">{{$message}}</div>
                                @enderror
                              </div>
                            </div>
                            <div class="d-md-none kt-margin-b-10"></div>
                          </div>
                          <div class="col-md-3">
                            <div class="kt-form__group--inline">
                              <div class="kt-form__label">
                                <label class="kt-label m-label--single">@lang('inventorisRequest.field.satuan'):</label>
                              </div>
                              <div class="kt-form__control">
                                {!! Form::select('satuan[]', $satuan, null, ['class' => 'form-control kt-select2 myselect2']) !!}
                                @error('satuan[]')
                                  <div class="form-text text-danger">{{$message}}</div>
                                @enderror
                              </div>
                            </div>
                            <div class="d-md-none kt-margin-b-10"></div>
                          </div>
                          <div class="col-md-3">
                            <div class="kt-form__group--inline">
                              <div class="kt-form__label">
                                <label class="kt-label m-label--single">@lang('inventorisRequest.field.total'):</label>
                              </div>
                              <div class="kt-form__control">
                                <input name="total[]" type="number" min="1" class="form-control" placeholder="Enter number">
                                @error('total[]')
                                  <div class="form-text text-danger">{{$message}}</div>
                                @enderror
                              </div>
                            </div>
                            <div class="d-md-none kt-margin-b-10"></div>
                          </div>
                          <div class="col-md-2">
                            <div class="kt-form__label">
                              <label class="kt-label m-label--single"></label>
                            </div>
                            <div class="kt-form__control">
                              <a href="javascript:;" onclick="delmyclone(this)" class="btn-sm btn btn-label-danger btn-bold">
                                <i class="la la-trash-o"></i>
                                Delete
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group form-group-last row">
                      <!-- <label class="col-lg-2 col-form-label"></label> -->
                      <div class="col-lg-4">
                        <a href="javascript:;" onclick="myclone()" class="btn btn-bold btn-sm btn-label-brand">
                          <i class="la la-plus"></i> Add
                        </a>
                      </div>
                    </div>
                </div>
                <div class="text-center">
                  <button class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" name="button" id="create_f">
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

@section('tjs')
  <script type="text/javascript">

  function myclone() {
    $(".myselect2").select2("destroy");
    // var itm = document.getElementById("repet");
    // var cln = itm.cloneNode(true);
    // document.getElementById("backgound").appendChild(cln);
    $("#repet")
      .eq(0)
      .clone()
      .find("input").val("").end() // ***
      .find(".myselect2").val(0).change().end() // ***
      .show()
      .insertAfter(".repet:last");

    $(".myselect2").select2({
        placeholder: "Select a state",
    });
  }

  function delmyclone(data) {
    if($('.repet').length>1)data.closest('.repet').remove();
  }

  $(".myselect2").select2({
      placeholder: "Select a state",
  });
  $('.myselect2').val(0).change();
  </script>
@endsection
