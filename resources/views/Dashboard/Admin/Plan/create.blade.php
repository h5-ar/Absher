@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Add Plan') }}
@endsection



@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/pickers/form-flat-pickr.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/pickers/form-pickadate.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
@endpush

@section('content')
<x-Content.normal>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title fs-2 text-bold">{{ translate('Add Plan') }}</h4>
                </div>
                <div class="card-body">
                    <form id="createForm" class="form form-horizontal" method="POST"
                        action="{{ route('store.plan') }}">
                        @csrf
                        <div class="row">
                            <x-inputs.h-input inputName="name" inputId="name" lable="Plan Name"
                                description="Enter Plan Name" placeholder="{{ translate('Plan Name') }}"
                                isRequired="true" />
                            <x-inputs.h-input inputName="trips_number" inputId="trips_number" lable="Trips Number"
                                description="Enter Trips Number" placeholder="{{ translate('Trips Number') }}"
                                isRequired="true" />
                            <x-inputs.h-gender-select namefor="TypeBusOfPlan" id="TypeBusOfPlan" description="Select Type Bus" />

                            <x-inputs.available-select label="Status" description="Select Status Of Plan" />
                            <x-inputs.h-input inputName="price" inputId="price" lable="Price"
                                description="Enter Price Plan" placeholder="{{ translate('Price Plan') }}"
                                isRequired="true" />
                        </div>

                        <div class="col-sm-9 offset-sm-3">
                            <x-Button.submit />
                            <x-Button.rest />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-Content.normal>
@endsection

