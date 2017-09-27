<div class="row">
    <div class="col col-xs-4">@lang('admin/pagination.page') {{$paginationObject->currentPage()}} @lang('admin/pagination.of') {{$paginationObject->lastPage()}}</div>
    <div class="col col-xs-8">
        <ul class="pagination hidden-xs pull-right  pagination-mi">
            <li class="{{$paginationObject->previousPageUrl() == null ? 'disabled' : ''}}">
                @if($paginationObject->previousPageUrl())
                    {!! link_to($paginationObject->previousPageUrl(), __('admin/pagination.previous')) !!}
                @else
                    <a href="javascript:void(0)">@lang('admin/pagination.previous')</a>
                @endif
            </li>
            @php
                $startPage = 1;
                $endPage = $paginationObject->lastPage();
                if($endPage > 5){
                    $startPage = $paginationObject->currentPage() - 2;
                    $endPage = $paginationObject->currentPage() + 2;
                }
                if($startPage < 1){
                    $endPage = $endPage + (0 - $startPage) + 1;
                    $startPage = 1;
                }
                if($endPage > $paginationObject->lastPage()){
                    $startPage = $startPage + ($paginationObject->lastPage() - $endPage);
                    $endPage = $paginationObject->lastPage();
                }
            @endphp
            @for($i = $startPage; $i <= $endPage; $i++)
                @php $a = Request::all(); $a['page'] = $i; @endphp
                <li class="{{$i == $paginationObject->currentPage() ? 'active' : ''}}">
                    {!! link_to(Request::fullUrlWithQuery($a), $i) !!}
                </li>
            @endfor
            <li class="{{$paginationObject->nextPageUrl() == null ? 'disabled' : ''}}">
                @if($paginationObject->nextPageUrl())
                    {!! link_to($paginationObject->nextPageUrl(), __('admin/pagination.next')) !!}
                @else
                    <a href="javascript:void(0)">@lang('admin/pagination.next')</a>
                @endif
            </li>
        </ul>
    </div>
</div>