@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Shipments') }}
@endsection
@section('content')
    <x-Content.normal>
        <div class="card shadow">
            <div class="card-body ">
                <div id="page-data">
                    @include('Dashboard.Admin.Shipping.Section.indexTable',['shipments' => $shipments])
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection

