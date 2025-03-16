@extends('Dashboard.Layouts.adminLayout')
@section('title')
{{ translate('Dashboard') }}
@endsection

@push('styles')
<style>
    .custom-content-style::-webkit-scrollbar {
        width: 0 !important;
    }

    .custom-content-style {
        scrollbar-width: none;
        /* For Firefox */
    }

    th,
    .sticky-top {
        background: white;
        position: sticky;
        top: 0;
        z-index: 1;
    }
</style>
@endpush
@push('layout-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
@endpush
@section('content')
<x-Content.normal>
    <div class="content-header row">
        <h1>{{ translate('Statistics') }}</h1>
    </div>
    <div class="content-body">
        <!-- Dashboard Ecommerce Starts -->
        <section id="dashboard-ecommerce">
            <div class="row match-height">
                <div class="col-lg-12 col-12">
                    <div class="row match-height">
                        <!-- Bar Chart - Orders -->
                        <div class="col-lg-3 col-md-3 col-6">
                            <div class="card">
                                <div class="card-body pb-50">
                                    <h6>{{ translate('Buses') }}</h6>
                                    <h2 class="fw-bolder mb-1"></h2>
                                    <div id="statistics-order-chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6">
                            <div class="card card-tiny-line-stats">
                                <div class="card-body pb-50">
                                    <h6 class="nowrap">Trips</h6>
                                    <h2 class="fw-bolder mb-1"></h2>
                                    <div id="statistics-profit-chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6">
                            <div class="card card-tiny-line-stats">
                                <div class="card-body pb-50">
                                    <h6>Subscribtion</h6>
                                    <h2 class="fw-bolder mb-1"></h2>
                                    <div id="statistics-profit-chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6">
                            <div class="card card-tiny-line-stats">
                                <div class="card-body pb-50">
                                    <h6>{{ translate('Total Profits') }}</h6>
                                    <h2 class="fw-bolder mb-1"></h2>
                                    <div id="statistics-profit-chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="card">
                                <canvas style="margin: 10px" id="orders-chart"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="card">
                                <canvas style="margin: 10px" id="profits-chart"></canvas>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-12">
                    <div class="row match-height">
                        <div class="col-lg-2 col-md-2 col-6">
                            <div class="card">
                                <div class="card-body pb-50">
                                    <h6>{{ translate('Active Products') }}</h6>
                                    <h2 class="fw-bolder mb-1"></h2>
                                    <div id="statistics-order-chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-6">
                            <div class="card card-tiny-line-stats">
                                <div class="card-body pb-50">
                                    <h6 class="nowrap">{{ translate('Active Offers') }}</h6>
                                    <h2 class="fw-bolder mb-1"></h2>
                                    <div id="statistics-profit-chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-6">
                            <div class="card card-tiny-line-stats">
                                <div class="card-body pb-50">
                                    <h6>{{ translate('Active Coupons') }}</h6>
                                    <h2 class="fw-bolder mb-1"></h2>
                                    <div id="statistics-profit-chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-6">
                            <div class="card card-tiny-line-stats">
                                <div class="card-body pb-50">
                                    <h6>{{ translate('Users') }}</h6>
                                    <h2 class="fw-bolder mb-1"></h2>
                                    <div id="statistics-profit-chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-6">
                            <div class="card card-tiny-line-stats">
                                <div class="card-body pb-50">
                                    <h6>{{ translate('Sellers') }}</h6>
                                    <h2 class="fw-bolder mb-1"></h2>
                                    <div id="statistics-profit-chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-6">
                            <div class="card card-tiny-line-stats">
                                <div class="card-body pb-50">
                                    <h6>{{ translate('Staffs') }}</h6>
                                    <h2 class="fw-bolder mb-1"></h2>
                                    <div id="statistics-profit-chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="card">
                                <canvas style="margin: 10px" id="products-chart"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="card">
                                <canvas style="margin: 10px" id="users-chart"></canvas>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="row match-height">
                <div class="col-12 ">
                    <div class="card card-company-table">
                        <div class="card-body p-0">
                            <div class="table-responsive overflow-y-scroll custom-content-style" style="height: 400px">
                                <h4 class="text-center m-1 sticky-top w-100 fs-2 fw-bolder">
                                    {{ translate('Best Users') }}
                                </h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Image') }}
                                            </th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Name') }}</th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Phone Number') }}</th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Total Orders') }}</th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Total Payments') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td class="text-center">

                                            </td>
                                            <td class="text-center">
                                                <span>holle</span>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="fw-bolder mb-25">holle</span>
                                            </td>
                                            <td class="text-center">holle</td>
                                            <td class="text-center">
                                                <span
                                                    class="fw-bolder me-1">holle</span>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row match-height">
                <div class="col-12 ">
                    <div class="card card-company-table">
                        <div class="card-body p-0">
                            <div class="table-responsive overflow-y-scroll custom-content-style"
                                style="height: 400px">
                                <h4 class="text-center m-1 sticky-top w-100 fs-2 fw-bolder">
                                    {{ translate('Best Sellers') }}
                                </h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center fs-4 fw-bolder">#</th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Company Name') }}
                                            </th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Name') }}</th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Total Sales') }}</th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('items count') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row match-height">
                <!-- Company Table Card -->
                <h4></h4>
                <div class="col-lg-12 col-12">
                    <div class="card card-company-table">
                        <div class="card-body p-0">
                            <div class="table-responsive overflow-y-scroll custom-content-style"
                                style="height: 400px">
                                <h4 class="text-center m-1 sticky-top w-100 fs-2 fw-bolder">
                                    {{ translate('Best Products') }}
                                </h4>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center fs-4 fw-bolder">#</th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Image') }}</th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Seller') }}</th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Product') }}</th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Category') }}</th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Brand') }}</th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Price') }}</th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Quantity Bought') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Dashboard Ecommerce ends -->

    </div>
</x-Content.normal>
@endsection