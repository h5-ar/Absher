@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\Permission')

@section('title')
    {{ translate('All New Stocks') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    </div>
                    <div id="page-data">
                        @include('Dashboard.Admin.NewStock.sections.indexTable', ['stocks' => $stocks])
                    </div>
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection
