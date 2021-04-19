<!--begin: Language bar -->

<div class="kt-header__topbar-item kt-header__topbar-item--langs">
  <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
    <span class="kt-header__topbar-icon">
      <img class="" src="@lang('menu.language-picker.langs.'.app()->getLocale().'.icon')" alt="" />
    </span>
  </div>
  <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround">
    <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
      <li class="kt-nav__item kt-nav__item--active">
        <a href="javascript::void(0)" class="kt-nav__link">
          <span class="kt-nav__link-icon"><img src="@lang('menu.language-picker.langs.'.app()->getLocale().'.icon')" alt="" /></span>
          <span class="kt-nav__link-text">@lang('menu.language-picker.langs.'.app()->getLocale().'.name')</span>
        </a>
      </li>
      @foreach(array_keys(config('locale.languages')) as $lang)
        @if($lang != app()->getLocale())
            <li class="kt-nav__item">
              <a href="{{ url('lang/'.$lang) }}" class="kt-nav__link">
                <span class="kt-nav__link-icon"><img src="@lang('menu.language-picker.langs.'.$lang.'.icon')" alt="" /></span>
                <span class="kt-nav__link-text">@lang('menu.language-picker.langs.'.$lang.'.name')</span>
              </a>
            </li>
        @endif
      @endforeach
    </ul>
  </div>
</div>
<!--end: Language bar -->
