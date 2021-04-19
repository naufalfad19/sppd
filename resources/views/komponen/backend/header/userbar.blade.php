<!--begin: User Bar -->
<div class="kt-header__topbar-item kt-header__topbar-item--user">
  <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
    <div class="kt-header__topbar-user">
      <span class="kt-header__topbar-welcome kt-hidden-mobile">@lang('global.app_hi'),</span>
      <span class="kt-header__topbar-username kt-hidden-mobile">{{Sentinel::getUser()->name}}</span>
      @if(Sentinel::getUser()->avatar)
        <img class="" alt="Pic" src="{{url('img/profile-pict/'.Sentinel::getUser()->avatar)}}" />
      @else
        <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold">{{Helper::awalan(Sentinel::getUser()->name)}}</span>
      @endif
      <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
    </div>
  </div>

  <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
    <!--begin: Head -->
    <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url({{asset('theme/media/misc/bg-1.jpg')}})">
      <div class="kt-user-card__avatar">
        @if(Sentinel::getUser()->avatar)
          <img class="" alt="Pic" src="{{url('img/profile-pict/'.Sentinel::getUser()->avatar)}}" />
        @else
          <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">{{Helper::awalan(Sentinel::getUser()->name)}}</span>
        @endif
        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
      </div>
      <div class="kt-user-card__name">
        {{Sentinel::getUser()->name}}
        <small>{{Sentinel::getUser()->nip}}</small>
      </div>
      <div class="kt-user-card__badge">
        <!-- <span class="btn btn-success btn-sm btn-bold btn-font-md">23 messages</span> -->
      </div>
    </div>
    <!--end: Head -->

    <!--begin: Navigation -->
    <div class="kt-notification">

      <a href="{{url('edit-password')}}" class="kt-notification__item">
        <div class="kt-notification__item-icon">
          <i class="flaticon2-lock kt-font-danger"></i>
        </div>
        <div class="kt-notification__item-details">
          <div class="kt-notification__item-title kt-font-bold">
            Ganti Password
          </div>
        </div>
      </a>
      <!-- <a href="../../custom/apps/user/profile-1/overview.html" class="kt-notification__item">
        <div class="kt-notification__item-icon">
          <i class="flaticon2-cardiogram kt-font-warning"></i>
        </div>
        <div class="kt-notification__item-details">
          <div class="kt-notification__item-title kt-font-bold">
            Billing
          </div>
          <div class="kt-notification__item-time">
            billing & statements <span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded">2 pending</span>
          </div>
        </div>
      </a> -->
      <div class="kt-notification__custom kt-space-between">
        <a href="#" target="_blank" class="btn btn-clean btn-sm btn-bold"></a>
        <a href="{{ route('logout') }}"  onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-label btn-label-brand btn-sm btn-bold">@lang('global.app_logout')</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
        </form>
      </div>
    </div>
    <!--end: Navigation -->
  </div>
</div>
<!--end: User Bar -->
