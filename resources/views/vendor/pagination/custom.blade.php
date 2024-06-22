{{-- <div class="pagination-area" style="width: 200px; margin:0 auto;">
    <ul class="pagination">
        <li><a href=""><i class="fa fa-angle-double-left"></i></a></li>
        <li><a href="" class="active">1</a></li>
        <li><a href="">2</a></li>
        <li><a href="">3</a></li>
        <li><a href=""><i class="fa fa-angle-double-right"></i></a></li>
    </ul>
</div> --}}

@if ($paginator->hasPages())
<div class="pagination-area" style="width: 200px; margin:0 auto;">
    <ul class="pagination">
        @if ($paginator->onFirstPage())
            <li class="disabled page-item" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span aria-hidden="true"><i class="fa fa-angle-double-left"></i></i></span>
            </li>
        @else
            <li class="page-item">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="fa fa-angle-double-left"></i></i></a>
            </li>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="fa fa-angle-double-right"></i></i></a>
            </li>
        @else
            <li class="disabled page-item" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span aria-hidden="true"><i class="fa fa-angle-double-right"></i></i></span>
            </li>
        @endif
    </ul>
</div>
@endif
