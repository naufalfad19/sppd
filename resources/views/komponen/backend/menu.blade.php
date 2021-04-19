<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
  <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
    <ul class="kt-menu__nav ">
      @if (Sentinel::getUser()->hasAccess(['home.dashboard']))
      <li class="kt-menu__item " aria-haspopup="true">
        <a href="{{route('home.dashboard')}}" class="kt-menu__link ">
          <span class="kt-menu__link-icon">
            <i class="fa fa-layer-group"></i>
          </span>
          <span class="kt-menu__link-text">@lang('global.app_dashboard')</span>
        </a>
      </li>
      @endif
      <!-- @if (Sentinel::getUser()->hasAccess(['tugas.store']))
      <li class="kt-menu__item " aria-haspopup="true">
        <a href="{{route('tugas.create')}}" class="kt-menu__link ">
          <span class="kt-menu__link-icon">
            <i class="fa fa-envelope-open"></i>
          </span>
          <span class="kt-menu__link-text">Form Surat Tugas</span>
        </a>
      </li>
      @endif -->
      @if (Sentinel::getUser()->hasAccess(['tugas.index']))
      <li class="kt-menu__item " aria-haspopup="true">
        <a href="{{route('tugas.index')}}" class="kt-menu__link ">
          <span class="kt-menu__link-icon">
            <i class="fa fa-envelope-open"></i>
          </span>
          <span class="kt-menu__link-text">Surat Tugas</span>
        </a>
      </li>
      @endif

      @if(Sentinel::getUser()->hasAnyAccess(['tugas.index']))
      <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
          <span class="kt-menu__link-icon">
            <i class="fa fa-file"></i>
          </span>
          <span class="kt-menu__link-text">Surat Perintah</span>
          <i class="kt-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="kt-menu__submenu ">
          <span class="kt-menu__arrow"></span>
          <ul class="kt-menu__subnav">
            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
              <span class="kt-menu__link">
                <span class="kt-menu__link-text">Surat Perintah</span>
              </span>
            </li>
            @if(Sentinel::getUser()->hasAnyAccess(['tugas.index']))
                <div class="kt-menu__item kt-menu__item--submenu">
                  <span class="kt-menu__arrow"></span>
                  <ul class="kt-menu__subnav">
                    <li class="kt-menu__item " aria-haspopup="true">
                      <a href="{{route('tugas.index')}}?jenis_perintah=sppd" class="kt-menu__link ">
                        <i class="kt-menu__link-bullet kt-menu__link-bullet--line">
                          <span></span>
                        </i>
                        <span class="kt-menu__link-text">Perjalanan Dinas</span>
                      </a>
                    </li>
                    <li class="kt-menu__item kt-menu__item--submenu" aria-haspopup="true">
                      <a href="{{route('tugas.index')}}?jenis_perintah=non_sppd" class="kt-menu__link ">
                        <i class="kt-menu__link-bullet kt-menu__link-bullet--line">
                          <span></span>
                        </i>
                        <span class="kt-menu__link-text">Non Perjalanan Dinas</span>
                      </a>
                    </li>
                    <li class="kt-menu__item kt-menu__item--submenu" aria-haspopup="true">
                      <a href="{{route('tugas.index')}}?jenis_perintah=dalam_kota" class="kt-menu__link ">
                        <i class="kt-menu__link-bullet kt-menu__link-bullet--line">
                          <span></span>
                        </i>
                        <span class="kt-menu__link-text">Dalam Kota</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            @endif
          </ul>
        </div>
      </li>
      @endif
   
      @if(Sentinel::getUser()->hasAnyAccess(['roles.index','users.index','log-viewer::logs.dashboard','log-viewer::logs.list']))
      <li class="kt-menu__section ">
        <h4 class="kt-menu__section-text">@lang('global.app_system')</h4>
        <i class="kt-menu__section-icon flaticon-more-v2"></i>
      </li>
      @endif
      @if(Sentinel::getUser()->hasAnyAccess(['roles.index','users.index']))
      <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
          <span class="kt-menu__link-icon">
            <i class="fa fa-user-alt"></i>
          </span>
          <span class="kt-menu__link-text">@lang('menu.m_user')</span>
          <i class="kt-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="kt-menu__submenu ">
          <span class="kt-menu__arrow"></span>
          <ul class="kt-menu__subnav">
            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
              <span class="kt-menu__link">
                <span class="kt-menu__link-text">@lang('menu.m_user')</span>
              </span>
            </li>
            @if(Sentinel::getUser()->hasAnyAccess(['roles.index']))
              <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{route('roles.index')}}" class="kt-menu__link ">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i><span class="kt-menu__link-text">@lang('menu.u_role')</span>
                </a>
              </li>
            @endif

            @if(Sentinel::getUser()->hasAnyAccess(['pegawai.index']))
              <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{route('pegawai.index')}}" class="kt-menu__link ">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i>
                  <span class="kt-menu__link-text">Pegawai</span>
                </a>
              </li>
            @endif
            @if(Sentinel::getUser()->hasAnyAccess(['users.index']))
              <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{route('users.index')}}" class="kt-menu__link ">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i>
                  <span class="kt-menu__link-text">Pengguna</span>
                </a>
              </li>
            @endif
            @if(Sentinel::getUser()->hasAnyAccess(['pejabat.updt']))
              <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{route('pejabat.edit')}}" class="kt-menu__link ">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i>
                  <span class="kt-menu__link-text">Pejabat</span>
                </a>
              </li>
            @endif
          </ul>
        </div>
      </li>
      @endif
    </ul>
  </div>
</div>
<!-- end:: Aside Menu -->
