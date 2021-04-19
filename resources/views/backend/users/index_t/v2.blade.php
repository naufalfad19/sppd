<div class="col-md-3 col-xl-3">
  <div class="kt-portlet kt-portlet--height-fluid">
    <div class="kt-portlet__head kt-portlet__head--noborder">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">

        </h3>
      </div>
      <div class="kt-portlet__head-toolbar">
        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
          <input type="checkbox">
          <span></span>
        </label>
      </div>
    </div>
    <div class="kt-portlet__body kt-portlet__body--fit-y kt-margin-b-40">
      <!--begin::Widget -->
      <div class="kt-widget kt-widget--user-profile-4">
        <div class="kt-widget__head">
          <div class="kt-widget__media">
            @if($data->avatar)
              <img class="kt-widget__img kt-hidden-" src="{{url('img/profile-pict/'.$data->avatar)}}" alt="image">
              <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-hidden">
                {{Helper::awalan($data->first_name.' '.$data->last_name)}}
              </div>
            @else
              <img class="kt-widget__img kt-hidden" src="" alt="image">
              <div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-hidden-">
                {{Helper::awalan($data->first_name.' '.$data->last_name)}}
              </div>
            @endif
          </div>
          <div class="kt-widget__content">
            <div class="kt-widget__section">
              <a href="{{route('users.show',$data->id)}}" class="kt-widget__username">
                {{$data->first_name.' '.$data->last_name}}
                <br>
                <small style="font-size:15px">{{$data->email}}</small>
              </a>

              <div class="kt-widget__button">
                <span class="btn btn-label-danger btn-sm">{{$data->roles()->first() ? $data->roles()->first()->name : 'Not Difine'}}</span>
              </div>
              {!! Form::open(['method'=>'DELETE', 'route' => ['users.destroy', $data->id], 'style' => 'display:inline']) !!}
                <div class="kt-widget__action">
                  <!-- <button type="button" class="btn btn-outline-brand btn-elevate btn-circle btn-icon"><i class="flaticon-bell"></i></button> -->
                  @if (Sentinel::getUser()->hasAccess(['users.show']))
                  <a href="{{route('users.show',$data->id)}}" class="btn btn-icon btn-circle btn-label-twitter">
                    <i class="fa fa-eye"></i>
                  </a>
                  @endif
                  <!-- <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
                  <i class="fa fa-edit"></i>
                </a> -->
                @if (Sentinel::getUser()->hasAccess(['users.destroy']) && $data->id != Sentinel::getUser()->id)
                <button onclick="confirmdelete()" type="submit" class="btn btn-icon btn-circle btn-label-google"  data-toggle="tooltip" data-placement="left" title="Hapus">
                  <i class="fa fa-trash-alt"></i>
                </button>
                @endif
                @if (Sentinel::getUser()->hasAnyAccess(['users.edit','users.permission','users.deactivate','users.activate']))
                <div class="dropdown dropdown-inline">
                  <button type="button" class="btn btn-icon btn-circle btn-label-facebook" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="flaticon-more-1"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    @if (Sentinel::getUser()->hasAccess(['users.destroy']))
                    <a class="dropdown-item" href="{{route('users.edit',$data->id)}}"><i class="la la-pencil"></i> Edit</a>
                    @endif
                    @if(sizeof($data->activations) == 0)
                      @if (Sentinel::getUser()->hasAccess(['users.activate']))
                        <a class="dropdown-item" onclick="confirmaktivasi()" href="{{route('users.activate', $data->id)}}"><i class="la la-user"></i> Activ</a>
                      @endif
                    @else
                      @if (Sentinel::getUser()->hasAccess(['users.deactivate']))
                        <a class="dropdown-item" onclick="confirmdeaktivasi()" href="{{route('users.deactivate', $data->id)}}"><i class="la la-user"></i> Deactiv</a>
                      @endif
                    @endif
                    <div class="dropdown-divider"></div>
                    @if (Sentinel::getUser()->hasAccess(['users.permissions']))
                    <a class="dropdown-item" href="{{route('users.permissions',$data->id)}}"><i class="la la-cog"></i> Permission</a>
                    @endif
                  </div>
                </div>
                @endif
              </div>
              {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
      <!--end::Widget -->
    </div>
  </div>
</div>
