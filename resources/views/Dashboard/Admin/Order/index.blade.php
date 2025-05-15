@extends('Dashboard.Layouts.adminLayout')

@section('title')
    {{ translate('Orders') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bolder fw-bold">{{ translate('All Orders') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <x-inputs.Multi-Vertical.input onkeyup="onSearchOrderNumber(event)"
                                    inputId="orderNumber_search" label="Order Number" placeholder="Search By Order Number"
                                    size="col-12" />
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <x-inputs.Multi-Vertical.select title="Status" selectId="status_search" lable="Status"
                                    size="col-12" onchange="onSearchSelect(event,'status_search','status')">
                                    <x-inputs.option lable="All" value="all" selected />
                                    <x-inputs.option lable="Pending" value="pending" translationFile="orders" />
                                    <x-inputs.option lable="Accepted" value="accepted" translationFile="orders" />
                                    <x-inputs.option lable="Rejected" value="rejected" translationFile="orders" />
                                    <x-inputs.option lable="Refund" value="refund" translationFile="orders" />
                                    <x-inputs.option lable="Completed" value="completed" translationFile="orders" />
                                    <x-inputs.option lable="Out For Delivery" value="out_for_delivery"
                                        translationFile="orders" />
                                </x-inputs.Multi-Vertical.select>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <x-inputs.Multi-Vertical.select lable="Payment Method" title="Filter By Payment Method"
                                    size="col-6 col-sm-12" selectId="paymentMethod_search"
                                    onchange="onSearchSelect(event,'paymentMethod_search','payment')">
                                    <x-inputs.option lable="All" value="all" selected />
                                    <x-inputs.option lable="Syriatel Cash" value="syriatel_cash" />
                                    <x-inputs.option lable="MTN Cash" value="mtn_cash" />
                                    <x-inputs.option lable="Fatora" value="fatora" />
                                    <x-inputs.option lable="Cash on delivery" value="cash_on_delivery" />
                                </x-inputs.Multi-Vertical.select>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <x-inputs.Multi-Vertical.select selectId="shipping_search" lable="Shipping"
                                    title="Filter By Shipping Status" size="col-12"
                                    onchange="onSearchSelect(event,'shipping_search','shipping')">
                                    <x-inputs.option lable="All" value="all" selected />
                                    <x-inputs.option lable="Delivered" value="delivered" translationFile="orders" />
                                    <x-inputs.option lable="Not delivered" value="on_delivery" translationFile="orders" />
                                </x-inputs.Multi-Vertical.select>
                            </div>
                        </div>
                    </div>
                    <div id="page-data">
                        @include('Dashboard.Admin.Order.Sections.indexTable', ['orders' => $orders])
                    </div>
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection


@push('layout-scripts')
    <script>
        $(function() {
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.delete('orderNumber');
            urlParams.delete('payment');
            urlParams.delete('shipping');
            urlParams.delete('status');
            urlParams.delete('search');
            $('#orderNumber_search').val('');
            const url = window.location.href.split('?')[0];
            const fullurl = `${url}?${urlParams}`;
            history.pushState({}, document.title, fullurl);
        });

        function submitForm(elemnt,orderId) {
            $(`#order-update-status-${orderId}`).attr('action', $(elemnt).data('url'));
            $(`#order-update-status-${orderId}`).submit();
        }

        function onSearchSelect(event, id, param) {
            event.preventDefault();
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set(`${param}`, $(`#${id}`).val());
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

        function onSearchOrderNumber(event) {
            event.preventDefault();
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('orderNumber', event.target.value);
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

        function updateStatus(element, type) {
            var url = $(element).data('url');
            $.ajax({
                type: "PUT",
                url: url,
                data: {
                    "_token": '{{ csrf_token() }}',
                    status: type
                },
                dataType: "json",
                success: function(response) {
                    successToast(`${response.message}`);
                    setTimeout(() => {
                        window.location.reload()
                    }, 800);
                },
                error: function(error) {
                    errorToast('{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endpush
