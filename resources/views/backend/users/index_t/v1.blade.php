<div class="col-md-3 col-xl-3">
  <div class="kt-portlet kt-portlet--height-fluid">
    <div class="kt-portlet__head kt-portlet__head--noborder">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">

        </h3>
      </div>
      <div class="kt-portlet__head-toolbar">
        @if($data->id != Sentinel::getUser()->id)
        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
          <input type="checkbox" name="sel" value="{{$data->id}}">
          <span></span>
        </label>
        @endif
      </div>
    </div>
    <div class="kt-portlet__body">
      <!--begin::Widget -->
      <div class="kt-widget kt-widget--user-profile-2">
        <div class="kt-widget__head">
          <div class="kt-widget__media">
            @if($data->avatar)
              <img class="kt-widget__img kt-hidden-" src="{{url('img/profile-pict/'.$data->avatar)}}" alt="image" height="90px" width="90px">
            @else
              <div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-hidden-">
                {{Helper::awalan($data->name)}}
              </div>
            @endif
          </div>

          <div class="kt-widget__info">
            <a href="{{route('users.show',$data->id)}}" class="kt-widget__username">
              {{$data->name}}
            </a>

            <span class="kt-widget__desc">
              {{$data->roles()->first() ? $data->roles()->first()->name :  __('user.users_role')}}
            </span>
          </div>
        </div>

        <div class="kt-widget__body">
          <div class="kt-widget__section">
          </div>

          <div class="kt-widget__item">
            <div class="kt-widget__contact">
              <span class="kt-widget__label">@lang('user.field.username'):</span>
              <span class="kt-widget__data">{{$data->username}}</span>
            </div>
            <div class="kt-widget__contact">
              <span class="kt-widget__label">@lang('user.field.last_login'):</span>
              <a href="javascript::void(0)" class="kt-widget__data">{{$data->last_login ? Helper::sekianwaktu($data->last_login) :  __('user.users_new')}}</a>
            </div>
          </div>
        </div>
        <br>
        <div class="text-center">
            <div class="kt-widget__action">
              <!-- <button type="button" class="btn btn-outline-brand btn-elevate btn-circle btn-icon"><i class="flaticon-bell"></i></button> -->
              <!-- @if (Sentinel::getUser()->hasAccess(['users.show']))
              <a href="{{route('users.show',$data->id)}}" class="btn btn-icon btn-circle btn-label-twitter">
                <i class="fa fa-eye"></i>
              </a>
              @endif -->
              <!-- <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
              <i class="fa fa-edit"></i>
            </a> -->
            @if (Sentinel::getUser()->hasAccess(['users.destroy']) && $data->id != Sentinel::getUser()->id)
            <button onclick="confirmdelete({{$data->id}})" type="button" class="btn btn-icon btn-circle btn-label-google"  data-toggle="tooltip" data-placement="left" title="Hapus">
              <i class="fa fa-trash-alt"></i>
            </button>
            @endif
            <!-- @if (Sentinel::getUser()->hasAnyAccess(['users.edit','users.permissions','users.deactivate','users.activate']))
            <div class="dropdown dropdown-inline">
              <button type="button" class="btn btn-icon btn-circle btn-label-facebook" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="flaticon-more-1"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                @if (Sentinel::getUser()->hasAccess(['users.edit']))
                <a class="dropdown-item" href="{{route('users.edit',$data->id)}}"><i class="la la-pencil"></i> @lang('global.app_edit')</a>
                @endif
                @if($data->id != Sentinel::getUser()->id)
                  @if(sizeof($data->activations) == 0)
                    @if (Sentinel::getUser()->hasAccess(['users.activate']))
                      <a class="dropdown-item" onclick="confirmaktivasi('{{route('users.activate', $data->id)}}')" href="javascript::void(0)"><i class="flaticon2-safe"></i> @lang('global.app_active')</a>
                    @endif
                  @else
                    @if (Sentinel::getUser()->hasAccess(['users.deactivate']))
                      <a class="dropdown-item" onclick="confirmdeaktivasi('{{route('users.deactivate', $data->id)}}')" href="javascript::void(0)"><i class="flaticon2-safe"></i> @lang('global.app_deactive')</a>
                    @endif
                  @endif
                @endif
                <div class="dropdown-divider"></div>
                @if (Sentinel::getUser()->hasAccess(['users.permissions']))
                <a class="dropdown-item" href="{{route('users.permissions',$data->id)}}"><i class="la la-cog"></i> @lang('permission.p_title')</a>
                @endif
              </div>
            </div>
            @endif -->
          </div>
        </div>
      </div>
      <!--end::Widget -->
    </div>
  </div>
</div>
