<?php
/**
 * @var  Arcanedev\LogViewer\Entities\Log            $log
 * @var  Illuminate\Pagination\LengthAwarePaginator  $entries
 * @var  string|null                                 $query
 */
?>

@extends('layouts.L1')

@php
  $name = 'Log Viewwer';
@endphp

@section('title') {{$name}} @stop

@section('subheader-name') {{$name}} @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
    System
  </a>
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="{{route('log-viewer::logs.dashboard')}}" class="kt-subheader__breadcrumbs-link">
    Log Viewer
  </a>
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="{{route('log-viewer::logs.list')}}" class="kt-subheader__breadcrumbs-link">
    Logs
  </a>
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
    Log [{{ $log->date }}]
  </a>
@stop

@section('tcss')
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700|Source+Sans+Pro:400,600' rel='stylesheet' type='text/css'>
  <style>
      html {
          position: relative;
          min-height: 100%;
      }

      body {
          font-size: .875rem;
          margin-bottom: 60px;
      }

      .main-footer {
          position: absolute;
          bottom: 0;
          width: 100%;
          height: 60px;
          line-height: 60px;
          background-color: #E8EAF6;
      }

      .main-footer p {
          margin-bottom: 0;
      }

      .main-footer .fa.fa-heart {
          color: #C62828;
      }

      .page-header {
          border-bottom: 1px solid #8a8a8a;
      }

      /*
       * Navbar
       */

      .navbar-brand {
          padding: .75rem 1rem;
          font-size: 1rem;
      }

      .navbar-nav .nav-link {
          padding-right: .5rem;
          padding-left: .5rem;
      }

      /*
       * Boxes
       */

      .box {
          display: block;
          padding: 0;
          min-height: 70px;
          background: #fff;
          width: 100%;
          box-shadow: 0 1px 1px rgba(0,0,0,0.1);
          border-radius: .25rem;
      }

      .box > .box-icon > i,
      .box .box-content .box-text,
      .box .box-content .box-number {
          color: #FFF;
          text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
      }

      .box > .box-icon {
          border-radius: 2px 0 0 2px;
          display: block;
          float: left;
          height: 70px; width: 70px;
          text-align: center;
          font-size: 40px;
          line-height: 70px;
          background: rgba(0,0,0,0.2);
      }

      .box .box-content {
          padding: 5px 10px;
          margin-left: 70px;
      }

      .box .box-content .box-text {
          display: block;
          font-size: 1rem;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
          font-weight: 600;
      }

      .box .box-content .box-number {
          display: block;
      }

      .box .box-content .progress {
          background: rgba(0,0,0,0.2);
          margin: 5px -10px 5px -10px;
      }

      .box .box-content .progress .progress-bar {
          background-color: #FFF;
      }

      /*
       * Log Menu
       */

      .log-menu .list-group-item.disabled {
          cursor: not-allowed;
      }

      .log-menu .list-group-item.disabled .level-name {
          color: #D1D1D1;
      }

      /*
       * Log Entry
       */

      .stack-content {
          color: #AE0E0E;
          font-family: consolas, Menlo, Courier, monospace;
          white-space: pre-line;
          font-size: .8rem;
      }

      /*
       * Colors: Badge & Infobox
       */

      .badge.badge-env,
      .badge.badge-level-all,
      .badge.badge-level-emergency,
      .badge.badge-level-alert,
      .badge.badge-level-critical,
      .badge.badge-level-error,
      .badge.badge-level-warning,
      .badge.badge-level-notice,
      .badge.badge-level-info,
      .badge.badge-level-debug,
      .badge.empty {
          color: #FFF;
          text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
      }

      .badge.badge-level-all,
      .box.level-all {
          background-color: {{ log_styler()->color('all') }};
      }

      .badge.badge-level-emergency,
      .box.level-emergency {
          background-color: {{ log_styler()->color('emergency') }};
      }

      .badge.badge-level-alert,
      .box.level-alert  {
          background-color: {{ log_styler()->color('alert') }};
      }

      .badge.badge-level-critical,
      .box.level-critical {
          background-color: {{ log_styler()->color('critical') }};
      }

      .badge.badge-level-error,
      .box.level-error {
          background-color: {{ log_styler()->color('error') }};
      }

      .badge.badge-level-warning,
      .box.level-warning {
          background-color: {{ log_styler()->color('warning') }};
      }

      .badge.badge-level-notice,
      .box.level-notice {
          background-color: {{ log_styler()->color('notice') }};
      }

      .badge.badge-level-info,
      .box.level-info {
          background-color: {{ log_styler()->color('info') }};
      }

      .badge.badge-level-debug,
      .box.level-debug {
          background-color: {{ log_styler()->color('debug') }};
      }

      .badge.empty,
      .box.empty {
          background-color: {{ log_styler()->color('empty') }};
      }

      .badge.badge-env {
          background-color: #6A1B9A;
      }
  </style>
@endsection


@section('content')

    <div class="row">
        <div class="col-lg-2">
            {{-- Log Menu --}}
            <div class="card mb-4">
                <div class="card-header"><i class="fa fa-fw fa-flag"></i> Levels</div>
                <div class="list-group list-group-flush log-menu">
                    @foreach($log->menu() as $levelKey => $item)
                        @if ($item['count'] === 0)
                            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center disabled">
                                <span class="level-name">{!! $item['icon'] !!} {{ $item['name'] }}</span>
                                <span class="badge empty">{{ $item['count'] }}</span>
                            </a>
                        @else
                            <a href="{{ $item['url'] }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center level-{{ $levelKey }}{{ $level === $levelKey ? ' active' : ''}}">
                                <span class="level-name">{!! $item['icon'] !!} {{ $item['name'] }}</span>
                                <span class="badge badge-level-{{ $levelKey }}">{{ $item['count'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-10">
            {{-- Log Details --}}
            <div class="card mb-4">
                <div class="card-header">
                    Log info :
                    <div class="group-btns pull-right">
                        <a href="{{ route('log-viewer::logs.download', [$log->date]) }}" class="btn btn-sm btn-success">
                            <i class="fa fa-download"></i> DOWNLOAD
                        </a>
                        <a href="#delete-log-modal" class="btn btn-sm btn-danger" data-toggle="modal">
                            <i class="fa fa-trash"></i> DELETE
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-condensed mb-0">
                        <tbody>
                            <tr>
                                <td>File path :</td>
                                <td colspan="7">{{ $log->getPath() }}</td>
                            </tr>
                            <tr>
                                <td>Log entries : </td>
                                <td>
                                    <span class="badge badge-primary">{{ $entries->total() }}</span>
                                </td>
                                <td>Size :</td>
                                <td>
                                    <span class="badge badge-primary">{{ $log->size() }}</span>
                                </td>
                                <td>Created at :</td>
                                <td>
                                    <span class="badge badge-primary">{{ $log->createdAt() }}</span>
                                </td>
                                <td>Updated at :</td>
                                <td>
                                    <span class="badge badge-primary">{{ $log->updatedAt() }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{-- Search --}}
                    <form action="{{ route('log-viewer::logs.search', [$log->date, $level]) }}" method="GET">
                        <div class=form-group">
                            <div class="input-group">
                                <input id="query" name="query" class="form-control"  value="{!! $query !!}" placeholder="Type here to search">
                                <div class="input-group-append">
                                    @unless (is_null($query))
                                        <a href="{{ route('log-viewer::logs.show', [$log->date]) }}" class="btn btn-secondary">
                                            ({{ $entries->count() }} results) <i class="fa fa-fw fa-times"></i>
                                        </a>
                                    @endunless
                                    <button id="search-btn" class="btn btn-primary">
                                        <span class="fa fa-fw fa-search"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Log Entries --}}
            <div class="card mb-4">
                @if ($entries->hasPages())
                    <div class="card-header">
                        <span class="badge badge-info float-right">
                            Page {{ $entries->currentPage() }} of {{ $entries->lastPage() }}
                        </span>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="entries" class="table mb-0">
                        <thead>
                            <tr>
                                <th>ENV</th>
                                <th style="width: 120px;">Level</th>
                                <th style="width: 65px;">Time</th>
                                <th>Header</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($entries as $key => $entry)
                                <?php /** @var  Arcanedev\LogViewer\Entities\LogEntry  $entry */ ?>
                                <tr>
                                    <td>
                                        <span class="badge badge-env">{{ $entry->env }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-level-{{ $entry->level }}">
                                            {!! $entry->level() !!}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ $entry->datetime->format('H:i:s') }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $entry->header }}
                                    </td>
                                    <td class="text-right">
                                        @if ($entry->hasStack())
                                            <a class="btn btn-sm btn-light" role="button" data-toggle="collapse" href="#log-stack-{{ $key }}" aria-expanded="false" aria-controls="log-stack-{{ $key }}">
                                                <i class="fa fa-toggle-on"></i> Stack
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @if ($entry->hasStack())
                                    <tr>
                                        <td colspan="5" class="stack py-0">
                                            <div class="stack-content collapse" id="log-stack-{{ $key }}">
                                                {!! $entry->stack() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <span class="badge badge-secondary">{{ trans('log-viewer::general.empty-logs') }}</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
              <div class="col-xl-12">
                <!--begin:: Components/Pagination/Default-->
                <div class="kt-portlet text-center">
                  <div class="kt-portlet__body text-center">
                    {!! $entries->appends(compact('query'))->render() !!}
                  </div>
                </div>
                <!--end:: Components/Pagination/Default-->
              </div>
            </div>
        </div>
    </div>

    <div id="delete-log-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="delete-log-form" action="{{ route('log-viewer::logs.delete') }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="date" value="{{ $log->date }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">DELETE LOG FILE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to <span class="badge badge-danger">DELETE</span> this log file <span class="badge badge-primary">{{ $log->date }}</span> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary mr-auto" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">DELETE FILE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('tjs')
    <script>
        $(function () {
            var deleteLogModal = $('div#delete-log-modal'),
                deleteLogForm  = $('form#delete-log-form'),
                submitBtn      = deleteLogForm.find('button[type=submit]');

            deleteLogForm.on('submit', function(event) {
                event.preventDefault();
                submitBtn.button('loading');

                $.ajax({
                    url:      $(this).attr('action'),
                    type:     $(this).attr('method'),
                    dataType: 'json',
                    data:     $(this).serialize(),
                    success: function(data) {
                        submitBtn.button('reset');
                        if (data.result === 'success') {
                            deleteLogModal.modal('hide');
                            location.replace("{{ route('log-viewer::logs.list') }}");
                        }
                        else {
                            alert('OOPS ! This is a lack of coffee exception !')
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert('AJAX ERROR ! Check the console !');
                        console.error(errorThrown);
                        submitBtn.button('reset');
                    }
                });

                return false;
            });

            
        });
    </script>
@endsection
