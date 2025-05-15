@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\Permission')

@section('title')
    {{ translate('All Requests') }}
@endsection

@section('content')
    <x-Content.normal>
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div id="page-data">
                        @include('Dashboard.Admin.Withdraw.sections.indexTable', ['requests' => $requests])
                    </div>
                </div>
            </div>
        </div>
    </x-Content.normal>
@endsection

@section('modal')

    <x-Modals.input modalId="acceptModal" inputId="image" inputName="image" inputType="file"
        description="Please Upload The Evidence document" title="Accept Withdraw Request" label="Document File"
        accept="image/*" method="PUT" />

    <x-Modals.input modalId="rejectModal" inputId="excuse" inputName="excuse" inputType="text"
        description="Please Enter An Excuse To Display For Seller" title="Reject Withdraw Request" label="Excuse"
        method="PUT" />
@endsection
