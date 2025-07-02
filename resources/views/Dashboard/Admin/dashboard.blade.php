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
    <div class="content-body">
        <!-- Dashboard Ecommerce Starts -->
        <section id="dashboard-ecommerce">
            <div class="row match-height">
                <div class="col-lg-12 col-12">
                    <div class="row match-height">
                        <!-- Bar Chart - Orders -->
                        <div class="col-lg-4 col-md-3 col-6">
                            <div class="card">
                                <div class="card-body pb-50">
                                    <h6>{{ translate('Buses') }}</h6>
                                    <h2 class="fw-bolder mb-1">{{ auth()->user()->bus()->count() }}</h2>
                                    <div id="statistics-order-chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3 col-6">
                            <div class="card card-tiny-line-stats">
                                <div class="card-body pb-50">
                                    <h6 class="nowrap">{{ translate('Trips') }}</h6>
                                    <h2 class="fw-bolder mb-1">{{ auth()->user()->trip()->count() }}</h2>
                                    <div id="statistics-profit-chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3 col-6">
                            <div class="card card-tiny-line-stats">
                                <div class="card-body pb-50">
                                    <h6>{{ translate('Plans') }}</h6>
                                    <h2 class="fw-bolder mb-1">{{ auth()->user()->plan()->count() }}</h2>
                                    <div id="statistics-profit-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row match-height">
                <div class="col-12">
                    <div class="card card-company-table">
                        <div class="card-body p-0">
                            <div class="table-responsive overflow-y-scroll custom-content-style" style="height: 400px">
                                <h4 class="text-center m-1 sticky-top w-100 fs-2 fw-bolder">
                                    {{ translate('Today Trips') }}
                                </h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Trip No') }}</th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Departure Time') }}</th>
                                            <th class="text-center fs-4 fw-bolder">{{ translate('Bus') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($todayTrips as $trip)
                                        <tr>
                                            <td class="text-center">{{ $trip->id }}</td>
                                            <td class="text-center">{{ $trip->take_off_at }}</td>
                                            <td class="text-center">{{ $trip->bus_id }}</td>

                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center">{{ translate('No trips scheduled for today') }}</td>
                                        </tr>
                                        @endforelse
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
