@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\Permission')

@section('title')
    {{ translate('Offers') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bolder fw-bold">{{ translate('All Offers') }}</h3>
                    </div>
                    <div class="card-body">
                        {{-- <div class="row">
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
                        </div> --}}
                    </div>
                    <div id="page-data">
                        @include('Dashboard.Admin.Offer.sections.indexTable', ['offers' => $offers])
                    </div>
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection
@section('modal')
    <x-Modals.delete message="Are you sure to delete this Offer ?"></x-Modals.delete>
@endsection


@push('layout-scripts')
    <script>
        function openDeleteModal(elment) {
            $("#deleteFormModal").attr("action", $(elment).attr('deleteUrl'));
        }

        function updateActivate(element) {
            oldValue = $(element).data('value');
            offer_id = $(element).data('offerid');
            newValue = oldValue == 0 ? 1 : 0;

            $.ajax({
                type: "PUT",
                url: "{{ route('dashboard.offers.activate') }}",
                data: {
                    offer_id: offer_id,
                    is_active: newValue,
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
@endpush
