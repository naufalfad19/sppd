<?php

    $masuk = DB::table('inventoris')
    ->join('barang','inventoris.barang_id','=','barang.id')
    ->join('inventoris_detail','inventoris.id','=','inventoris_detail.inventoris_id')
    ->select('inventoris.id','barang.name','inventoris.satuan_id','inventoris.barang_id',DB::raw('sum(inventoris_detail.total) as total'))
    ->where('satker_id',(Sentinel::getUser()->satker->id))->groupby('inventoris.barang_id','inventoris.satuan_id','inventoris.id','barang.name')->get();     

    if(Sentinel::getUser()->satker->id == 1){
    $stats = DB::table('inventoris_request')
    ->join('satuan_kerja','inventoris_request.satker_id','=','satuan_kerja.id')
    ->orderby('created_at','desc')
    ->orderby('updated_at','desc')
    ->select('inventoris_request.id','inventoris_request.updated_at','satuan_kerja.name','inventoris_request.satker_id','inventoris_request.status','inventoris_request.created_at')
    ->get();
    }else{
    $stats = DB::table('inventoris_request')
    ->join('satuan_kerja','inventoris_request.satker_id','=','satuan_kerja.id')
    ->orderby('created_at','desc')
    ->orderby('updated_at','desc')
    ->select('inventoris_request.id','inventoris_request.updated_at','satuan_kerja.name','inventoris_request.satker_id','inventoris_request.status','inventoris_request.created_at')
    ->where('inventoris_request.satker_id',(Sentinel::getUser()->satker->id))->get();
    }
    $message = 0;
    $tanggal = now();
    foreach($stats as $stat){
      if($stat->status == 0 && Sentinel::getUser()->satker->id == 1){
          $message++;
      }
      elseif($stat->status == 0 && Sentinel::getUser()->satker->id != 1){
          $message++;
      }
      elseif($stat->status == 1 && Sentinel::getUser()->satker->id != 1){
          $message++;
      }
      elseif($stat->status == 2 && Sentinel::getUser()->satker->id != 1){
          $message++;
      }
    }
    if(Sentinel::getUser()->satker->id==1){
      foreach($masuk as $in){
        $keluar1 = DB::table('inventoris')
        ->join('inventoris_detail','inventoris.id','=','inventoris_detail.inventoris_id')
        ->select('inventoris_detail.total')
        ->where('inventoris_detail.status',1)
        ->where('barang_id',$in->barang_id)
        ->where('satuan_id',$in->satuan_id)->get();

        $keluar2 = DB::table('inventoris_keluar')
        ->select('inventoris_keluar.total')
        ->where('inventoris_keluar.inventoris_id',$in->id)->get();

        $total = $in->total - ($keluar1->sum('total') + $keluar2->sum('total'));
        if($total<=3 && $total>0){
          $message++;
        }
        elseif($total<=0){
          $message++;
        }
      }
    }
    else{
      foreach($masuk as $in){
        $total = $in->total;
        if($total<=3 && $total>0){
          $message++;
        }
        elseif($total<=0){
          $message++;
        }
      }
    }
?>
<div class="kt-header__topbar-item dropdown">
    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="30px,0px" aria-expanded="true">
                <span class="kt-header__topbar-icon @if($message > 0) kt-pulse kt-pulse--brand @endif">
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <rect x="0" y="0" width="24" height="24" />
                      <path
                        d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                        fill="#000000" opacity="0.3" />
                      <path
                        d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                        fill="#000000" />
                    </g>
                  </svg> <span class="kt-pulse__ring"></span>
                </span>
                <!--
                Use dot badge instead of animated pulse effect:
                <span class="kt-badge kt-badge--dot kt-badge--notify kt-badge--sm kt-badge--brand"></span>
            -->
    </div>
    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-lg">
        <form>
          <!--begin: Head -->
          <div class="kt-head kt-head--skin-dark kt-head--fit-x kt-head--fit-b" style="background-image: url({{asset('theme/media/misc/bg-1.jpg')}})">
            <h3 class="kt-head__title">
            @lang('global.app_notification')
              &nbsp;
              <span class="btn btn-success btn-sm btn-bold btn-font-md">{{$message}} @lang('menu.u_notifikasi')</span>
            </h3>
            <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-success kt-notification-item-padding-x" role="tablist">
              <li class="nav-item">
                <a class="nav-link active show" data-toggle="tab" href="#topbar_notifications_notifications" role="tab" aria-selected="true">Alerts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#topbar_notifications_events" role="tab" aria-selected="false">Events</a>
              </li>
            </ul>
          </div>
          <!--end: Head -->
          <div class="tab-content">
            <div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">
                <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">

                @if(Sentinel::getUser()->satker->id==1)
                  @foreach($masuk as $in)
                  <?php
                     $keluar1 = DB::table('inventoris')
                     ->join('inventoris_detail','inventoris.id','=','inventoris_detail.inventoris_id')
                     ->select('inventoris_detail.total')
                     ->where('inventoris_detail.status',1)
                     ->where('barang_id',$in->barang_id)
                     ->where('satuan_id',$in->satuan_id)->get();
             
                     $keluar2 = DB::table('inventoris_keluar')
                     ->select('inventoris_keluar.total')
                     ->where('inventoris_keluar.inventoris_id',$in->id)->get();

                    $total = $in->total - ($keluar1->sum('total'));
                    ?>
                    @if($total<=3 && $total>0)
                    <a href="{{route('inventoris.show',[$in->id])}}" class="kt-notification__item">
                      <div class="kt-notification__item-icon">
                          <i class="flaticon-security kt-font-warning"></i>
                      </div>
                      <div class="kt-notification__item-details">
                          <div class="kt-notification__item-title">
                          @lang('notification.r_field.r_stok') {{$in->name}} @lang('notification.r_field.r_status2')
                          </div>
                      </div>
                    </a>
                    @elseif($total<=0)
                    <a href="{{route('inventoris.show',[$in->id])}}" class="kt-notification__item">
                      <div class="kt-notification__item-icon">
                          <i class="flaticon-download-1 kt-font-danger"></i>
                      </div>
                      <div class="kt-notification__item-details">
                          <div class="kt-notification__item-title">
                          @lang('notification.r_field.r_stok') {{$in->name}} @lang('notification.r_field.r_status1')
                          </div>
                      </div>
                    </a>
                    @endif
                  @endforeach
                @else
                  @foreach($masuk as $in)
                  <?php
                    $keluar2 = DB::table('inventoris_keluar')
                    ->select('inventoris_keluar.total')
                    ->where('inventoris_keluar.inventoris_id',$in->id)->get();

                    $total = $in->total - $keluar2->sum('total');
                  ?>
                @if($total<=3 && $total>0)
                    <a href="{{route('inventoris.show',[$in->id])}}" class="kt-notification__item">
                      <div class="kt-notification__item-icon">
                          <i class="flaticon-security kt-font-warning"></i>
                      </div>
                      <div class="kt-notification__item-details">
                          <div class="kt-notification__item-title">
                          @lang('notification.r_field.r_stok') {{$in->name}} @lang('notification.r_field.r_status2')
                          </div>
                      </div>
                    </a>
                    @elseif($total<=0)
                    <a href="{{route('inventoris.show',[$in->id])}}" class="kt-notification__item">
                      <div class="kt-notification__item-icon">
                          <i class="flaticon-download-1 kt-font-danger"></i>
                      </div>
                      <div class="kt-notification__item-details">
                          <div class="kt-notification__item-title">
                          @lang('notification.r_field.r_stok') {{$in->name}} @lang('notification.r_field.r_status1')
                          </div>
                      </div>
                    </a>
                    @endif
                  @endforeach
                @endif
              </div>
            </div>
            <div class="tab-pane" id="topbar_notifications_events" role="tabpanel">
              <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
              @foreach($stats as $stat)     
                @if($stat->status == 0 && Sentinel::getUser()->satker->id == 1)    
                <a href="{{route('inreq.show',[$stat->id])}}" class="kt-notification__item">
                  <div   class="kt-notification__item-icon">
                    <i class="flaticon2-favourite kt-font-brand"></i>
                  </div>
                  <div class="kt-notification__item-details">
                    <div class="kt-notification__item-title">
                      Donasi baru sedang dalam pengiriman
                    </div>
                    <div class="kt-notification__item-time">
                      {{$stat->created_at}}
                    </div>
                  </div>
                </a>
                @elseif($stat->status == 1 && Sentinel::getUser()->satker->id != 1)
                <a href="{{route('inreq.show',[$stat->id])}}" class="kt-notification__item">
                  <div class="kt-notification__item-icon">
                    <i class="flaticon2-box-1 kt-font-brand"></i>
                  </div>
                  <div class="kt-notification__item-details">
                    <div class="kt-notification__item-title">
                      Barang telah sampai
                    </div>
                    <div class="kt-notification__item-time">
                    {{$stat->updated_at}}
                    </div>
                  </div>
                </a>
                @elseif($stat->status == 0 && Sentinel::getUser()->satker->id != 1)
                <a href="{{route('inreq.show',[$stat->id])}}" class="kt-notification__item">
                  <div   class="kt-notification__item-icon">
                    <i class="flaticon2-favourite kt-font-brand"></i>
                  </div>
                  <div class="kt-notification__item-details">
                    <div class="kt-notification__item-title">
                      Barang sedang dalam proses pengiriman
                    </div>
                    <div class="kt-notification__item-time">
                      {{$stat->created_at}}
                    </div>
                  </div>
                </a>
                @elseif($stat->status == 2 && Sentinel::getUser()->satker->id != 1)
                <a href="{{route('inreq.show',[$stat->id])}}" class="kt-notification__item">
                  <div   class="kt-notification__item-icon">
                    <i class="flaticon2-chart2 kt-font-danger"></i>
                  </div>
                  <div class="kt-notification__item-details">
                    <div class="kt-notification__item-title">
                      Donasi dibatalkan
                    </div>
                    <div class="kt-notification__item-time">
                      {{$stat->updated_at}}
                    </div>
                  </div>
                </a>
                @endif
              @endforeach
              </div>
            </div>

          </div>
        </form>
    </div>
</div>
