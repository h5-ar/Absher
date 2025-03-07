@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" onclick="submitPage(this)" href="{{ $paginator->previousPageUrl() }}"
                            rel="prev">@lang('pagination.previous')</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" onclick="submitPage(this)" href="{{ $paginator->nextPageUrl() }}"
                            rel="next">@lang('pagination.next')</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <div>
                <p class="small text-muted">
                    {!! __('Showing') !!}
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    {!! __('of') !!}
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" onclick="submitPage(this)" href="{{ $paginator->previousPageUrl() }}"
                                rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span
                                    class="page-link">{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><span
                                            class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}"
                                            onclick="submitPage(this)">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" onclick="submitPage(this)"
                                rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
@push('scripts')
    <script>
        function submitPage(elem) {
            event.preventDefault();
            const urlParams = new URLSearchParams(window.location.search);
            const oldPage = urlParams.get('page');
            let getUrl = '';
            const url = $(elem).attr('href');
            if (!oldPage) {
                var indexOf = window.location.href.indexOf('?');
                var connection = window.location.href;
                if (indexOf != -1) {
                    connection = window.location.href.slice(0, indexOf + 1);
                }
                const newPage = url.slice(url.indexOf("=") + 1, url.length);
                if (indexOf != -1) {
                    getUrl = urlParams.size == 0 ? `${connection}page=${newPage}` :
                        `${connection}page=${newPage}&${urlParams}`;
                } else {
                    getUrl = urlParams.size == 0 ? `${connection}?page=${newPage}` :
                        `${connection}?page=${newPage}&${urlParams}`;
                }
            } else {
                var newUrl = new URL(window.location.href);
                const newPage = url.slice(url.indexOf("=") + 1, url.length);
                newUrl.searchParams.set('page', newPage);
                getUrl = `${newUrl.href}`;
            }

            $.ajax({
                type: "GET",
                url: `${getUrl}`,
                dataType: "html",
                success: function(response) {
                    $('#page-data').html(response);
                    history.pushState({}, document.title, getUrl);
                },
                error: function(res) {
                    errorToast('{{ translate('Something went wrong') }}');
                }
            });
        }
        window.addEventListener('popstate', function(event) {
            // Access the new URL
            var newUrl = document.location.href; // or window.location.href

            // var poppedState = event.state;

            window.location.href = newUrl;
        });
    </script>
@endpush
