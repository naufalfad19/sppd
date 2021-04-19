<!-- begin:: Header -->
<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">
  <!-- begin:: Header Menu -->
  <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
  <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
    <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
      <ul class="kt-menu__nav ">
        @include('komponen.backend.header.loginAsName')
      </ul>
    </div>
  </div>
  <!-- end:: Header Menu -->
  <!-- begin:: Header Topbar -->
  <div class="kt-header__topbar">
    @include('komponen.backend.header.userbar')
  </div>
  <!-- end:: Header Topbar -->
</div>
<!-- end:: Header -->
