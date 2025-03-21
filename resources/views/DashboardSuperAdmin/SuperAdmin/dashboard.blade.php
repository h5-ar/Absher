@extends('DashboardSuperAdmin.Layouts.adminLayout')
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

@section('content')
<x-Content.normal>

    <div class="content-body">
        <div class="row match-height">
            <div class="col-12 ">
                <div class="card card-company-table">
                    <div class="card-body p-0">
                        <div class="table-responsive overflow-y-scroll custom-content-style" style="height: 400px">
                            <h4 class="text-center m-1 sticky-top w-100 fs-2 fw-bolder">
                                {{ translate('Managers') }}
                            </h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center fs-4 fw-bolder">#</th>
                                        <th class="text-center fs-4 fw-bolder">{{ translate('Name') }}</th>
                                        <th class="text-center fs-4 fw-bolder">{{ translate('Phone') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($managers as $manager)
                                    <tr>
                                        <td class="text-center fs-5 fw-bold">
                                            <div class="fw-bolder">
                                                {{ $loop->index + 1 }}
                                            </div>
                                        </td>
                                        <td class="text-center fs-5 fw-bold">
                                            {{ $manager->first_name }} {{ $manager->last_name }}
                                        </td>
                                        <td class="text-center fs-5 fw-bold">
                                            {{ $manager->phone }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row match-height">
            <div class="col-lg-12 col-12">
                <div class="card card-company-table">
                    <div class="card-body p-0">
                        <div class="table-responsive overflow-y-scroll custom-content-style"
                            style="height: 400px">
                            <h4 class="text-center m-1 sticky-top w-100 fs-2 fw-bolder">
                                {{ translate('Companies') }}
                            </h4>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center fs-4 fw-bolder">#</th>
                                        <th class="text-center fs-4 fw-bolder">{{ translate('Company Name') }}</th>
                                        <th class="text-center fs-4 fw-bolder">{{ translate('Phone') }}</th>
                                        <th class="text-center fs-4 fw-bolder">{{ translate('Email') }}</th>
                                        <th class="text-center fs-4 fw-bolder">{{ translate('Manager Name') }}</th>
                                    </tr>
                                <tbody>
                                    @foreach ($companies as $company)
                                    <tr>

                                        <td class="text-center fs-5 fw-bold">
                                            <div class="fw-bolder">
                                                {{ $loop->index + 1 }}
                                            </div>
                                        </td>
                                        <td class="text-center fs-5 fw-bold">
                                            {{ $company->name }}
                                        </td>
                                        <td class="text-center fs-5 fw-bold">
                                            {{ $company->phone }}
                                        </td>
                                        <td class="text-center fs-5 fw-bold">
                                            {{ $company->email }}
                                        </td>
                                        <td class="text-center fs-5 fw-bold">
                                            {{ $company->manager->first_name }} {{ $company->manager->last_name }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </div>
</x-Content.normal>
@endsection