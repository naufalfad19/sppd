<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
  <div class="kt-container  kt-container--fluid ">
    <div class="kt-subheader__main">
      <h3 class="kt-subheader__title">
        @yield('subheader-name')
      </h3>
      <span class="kt-subheader__separator kt-subheader__separator--v"></span>
      <div class="kt-subheader__breadcrumbs">
        <a href="#" class="kt-subheader__breadcrumbs-home">
          <i class="flaticon2-shelter"></i>
        </a>
         @yield('subheader-link')
        <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
      </div>
    </div>
    <div class="kt-subheader__toolbar">
      @yield('subheader-btn')
    </div>
  </div>
</div>
<!-- end:: Subheader -->
