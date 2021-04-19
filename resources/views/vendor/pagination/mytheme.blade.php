@if ($paginator->hasPages())
  <!--begin: Pagination-->
  <div class="kt-pagination kt-pagination--brand text-center" style="display:inline">
    <ul class="kt-pagination__links">
      @if ($paginator->onFirstPage())
          <li class="kt-pagination__link--first disabled">
            <a href="javascipt::void(0)"><i class="fa fa-angle-double-left kt-font-brand"></i></a>
          </li>
          <li class="kt-pagination__link--next disabled">
            <a href="javascipt::void(0)"><i class="fa fa-angle-left kt-font-brand"></i></a>
          </li>
      @else
          <li class="kt-pagination__link--first">
            <a href="{{ $paginator->url(1)}}"><i class="fa fa-angle-double-left kt-font-brand"></i></a>
          </li>
          <li class="kt-pagination__link--next">
            <a href="{{ $paginator->previousPageUrl() }}"><i class="fa fa-angle-left kt-font-brand"></i></a>
          </li>
      @endif

      {{-- Pagination Elements --}}
      @foreach ($elements as $element)
          {{-- "Three Dots" Separator --}}
          @if (is_string($element))
              <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
          @endif

          {{-- Array Of Links --}}
          @if (is_array($element))
              @foreach ($element as $page => $url)
                  @if ($page == $paginator->currentPage())
                      <li class="kt-pagination__link--active"><a href="javascipt::void(0)">{{$page}}</a></li>
                  @else
                      <li><a href="{{ $url }}">{{ $page }}</a></li>
                  @endif
              @endforeach
          @endif
      @endforeach

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
          <li class="kt-pagination__link--prev">
            <a href="{{ $paginator->nextPageUrl() }}"><i class="fa fa-angle-right kt-font-brand"></i></a>
          </li>
          <li class="kt-pagination__link--last">
            <a href="{{ $paginator->url($paginator->lastPage()) }}"><i class="fa fa-angle-double-right kt-font-brand"></i></a>
          </li>
      @else
          <li class="kt-pagination__link--prev disabled">
            <a href="javascipt::void(0)"><i class="fa fa-angle-right kt-font-brand"></i></a>
          </li>
          <li class="kt-pagination__link--last disabled">
            <a href="javascipt::void(0)"><i class="fa fa-angle-double-right kt-font-brand"></i></a>
          </li>
      @endif
    </ul>
  </div>
  <!--end: Pagination-->
@endif
