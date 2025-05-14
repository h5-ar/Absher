@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\Permission')

@section('title')
    {{ translate('All Invoices') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div id="page-data">
                        @include('Dashboard.Admin.Invoice.sections.indexTable', ['invoices' => $invoices])
                    </div>
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection
