@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\Permission')

@section('title')
    {{ translate('Products') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bolder fw-bold">{{ translate('All Products') }}</h3>
                    </div>
                    {{-- <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <x-inputs.Multi-Vertical.input onkeyup="onSearchName(event)" inputId="nameSearch"
                                    label="Product Name" placeholder="Search By Product Name" size="col-12" />
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <x-inputs.Multi-Vertical.select selectId="searchPublished" lable="Status"
                                    title="Filter By Status" size="col-12" onchange="onSearchPublished(event)">
                                    <x-inputs.option lable="all" value="all" selected />
                                    <x-inputs.option lable="Published" value="published" />
                                    <x-inputs.option lable="Unpublished" value="unpublished" />
                                </x-inputs.Multi-Vertical.select>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <x-inputs.Multi-Vertical.select title="Brands" selectId="search_brand_id" lable="Brands"
                                    size="col-12" onchange="onSearchBrands(event)">
                                    <x-inputs.option lable="all" value="all" selected />
                                    @foreach ($brands as $brand)
                                        <x-inputs.option lable2="{{ $brand->name }}" value="{{ $brand->id }}" />
                                    @endforeach
                                </x-inputs.Multi-Vertical.select>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <x-inputs.Multi-Vertical.select title="Categories"
                                    selectId="search_category_id" lable="Categories" size="col-12" onchange="onSearchCategory(event)">
                                    <x-inputs.option lable="all" value="all" selected />
                                    @foreach ($categories as $category)
                                        <optgroup label="{{ $category->name }}">
                                            @foreach ($category->children as $subCategory)
                                                @if ($subCategory->name == 'main')
                                                    <x-inputs.option lable2="{{ $category->name }}"
                                                        value="{{ $subCategory->id }}" />
                                                @else
                                                    <x-inputs.option lable2="{{ $subCategory->name }}"
                                                        value="{{ $subCategory->id }}" />
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </x-inputs.Multi-Vertical.select>
                            </div>
                        </div>
                    </div> --}}
                    <div id="page-data">
                        @include('Dashboard.Admin.Product.sections.edit-stocks-table', [
                            'stocks' => $stocks,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection


{{-- @push('layout-scripts')
    <script>
        $(function() {
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.delete('name');
            urlParams.delete('published');
            urlParams.delete('search');
            urlParams.delete('category');
            urlParams.delete('brand');
            $('#nameSearch').val('');
            const url = window.location.href.split('?')[0];
            const fullurl = `${url}?${urlParams}`;
            history.pushState({}, document.title, fullurl);
        });

        function updateApproved(element) {
            oldValue = $(element).data('value');
            productId = $(element).data('productid');
            newValue = oldValue == 0 ? 1 : 0;
            $.ajax({
                type: "PUT",
                url: "{{ route('dashboard.products.approve') }}",
                data: {
                    product_id: productId,
                    approved: newValue,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function(response) {
                    successToast(response.message);
                    $(element).data('value', newValue);
                },
                error: function(error) {
                    errorToast(error?.responseJSON?.message);
                    element.checked = !element.checked;
                }
            });
        }

        function onSearchPublished(event) {
            event.preventDefault();
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('published', event.target.value);
            urlParams.set('search', 1);
            urlParams.set('page', 1);
            const url = window.location.href.split('?')[0];
            const fullurl = `${url}?${urlParams}`;
            $.ajax({
                type: "GET",
                url: `${fullurl}`,
                dataType: "html",
                success: function(response) {
                    $('#page-data').html(response);
                    history.pushState({}, document.title, fullurl);
                },
                error: function(res) {
                    errorToast('{{ translate('Something went wrong') }}');
                }
            });
        }

        function onSearchName(event) {
            event.preventDefault();
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('name', event.target.value);
            urlParams.set('search', 1);
            urlParams.set('page', 1);
            const url = window.location.href.split('?')[0];
            const fullurl = `${url}?${urlParams}`;
            $.ajax({
                type: "GET",
                url: `${fullurl}`,
                dataType: "html",
                success: function(response) {
                    $('#page-data').html(response);
                    history.pushState({}, document.title, fullurl);
                },
                error: function(res) {
                    errorToast('{{ translate('Something went wrong') }}');
                }
            });
        }

        function onSearchBrands() {
            event.preventDefault();
            const urlParams = new URLSearchParams(window.location.search);
            var brand_id = $('#search_brand_id').val();
            urlParams.set('brand', brand_id);
            urlParams.set('search', 1);
            urlParams.set('page', 1);
            const url = window.location.href.split('?')[0];
            const fullurl = `${url}?${urlParams}`;
            $.ajax({
                type: "GET",
                url: `${fullurl}`,
                dataType: "html",
                success: function(response) {
                    $('#page-data').html(response);
                    history.pushState({}, document.title, fullurl);
                },
                error: function(res) {
                    errorToast('{{ translate('Something went wrong') }}');
                }
            });
        }

        function onSearchCategory() {
            event.preventDefault();
            const urlParams = new URLSearchParams(window.location.search);
            var category_id = $('#search_category_id').val();
            urlParams.set('category', category_id);
            urlParams.set('search', 1);
            urlParams.set('page', 1);
            const url = window.location.href.split('?')[0];
            const fullurl = `${url}?${urlParams}`;
            $.ajax({
                type: "GET",
                url: `${fullurl}`,
                dataType: "html",
                success: function(response) {
                    $('#page-data').html(response);
                    history.pushState({}, document.title, fullurl);
                },
                error: function(res) {
                    errorToast('{{ translate('Something went wrong') }}');
                }
            });
        }

        function updatePublished(element) {
            oldValue = $(element).data('value');
            productId = $(element).data('productid');
            newValue = oldValue == 0 ? 1 : 0;

            $.ajax({
                type: "PUT",
                url: "{{ route('dashboard.products.publish') }}",
                data: {
                    product_id: productId,
                    published: newValue,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function(response) {
                    successToast(response.message);
                    $(element).data('value', newValue);
                },
                error: function(error) {
                    errorToast(error?.responseJSON?.message);
                    element.checked = !element.checked;
                }
            });
        }
    </script>
@endpush --}}
