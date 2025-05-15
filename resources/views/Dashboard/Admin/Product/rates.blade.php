@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\Permission')

@section('title')
    {{ translate('Rates') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bolder fw-bold">{{ translate('All Rates') }}</h3>
                    </div>
                    <div id="page-data">
                        @include('Dashboard.Admin.Product.sections.ratesTable', [
                            'rates' => $rates,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection


