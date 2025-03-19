@extends('Dashboard.Layouts.adminLayout')

@section('title')
{{ translate('Add Trip') }}
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
                    <h4 class="card-title fs-2 text-bold">{{ translate('Add Trip') }}</h4>
                </div>
                <div class="card-body">
                    <form id="createForm" class="form form-horizontal" method="POST"
                        action="{{ route('trip.storeVehicle') }}">
                        @csrf
                        <div class="row">
                            <x-inputs.h-input inputName="price" inputId="price" lable="Price"
                                description="Enter Price Trip" placeholder="{{ translate('Price Trip') }}"
                                isRequired="true" />

                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-2 col-sm-3">
                                        <label class="col-form-label fs-5 fw-bolder isRequired">{{ translate('Type') }}</label>
                                    </div>
                                    <div class="col-10 col-sm-9">
                                        <select class="select2 form-select rounded" name="Bus" id="default-select">
                                            <option value="" disabled selected>{{ translate('Select Bus') }}</option>
                                            @foreach ($buses as $bus)
                                            <option class="form-control" value="{{ $bus->id }}">{{$bus->id}} {{$bus->type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <x-Date.time-input
                            name="datetime" dateId="datetime" label="History And Time" isRequired="true"
                            description="Select Offer Start Date" enableTime="true"
                            time_24hr="false"
                            dateFormat="Y-m-d h:i K" />
                        <x-inputs.h-day-select description="Select Day" />
                        <x-inputs.governorates-select namefor="from" id="from" label="From" description="Select Governorates" isRequired="true" />
                        <x-inputs.governorates-select namefor="to1" id="to1" label="To 1" description="Select Governorates" isRequired="true" />
                        <x-inputs.governorates-select namefor="to2" id="to2" label="To 2" description="Select Governorates" isRequired="true" />
                        <x-inputs.governorates-select namefor="to3" id="to3" label="To 3" description="Select Governorates" />
                        <x-inputs.governorates-select namefor="to4" id="to4" label="To 4" description="Select Governorates" />
                        <x-inputs.governorates-select namefor="to5" id="to5" label="To 5" description="Select Governorates" />
                        <div class="col-sm-9 offset-sm-3">
                            <x-Button.submit/>
                            <x-Button.rest />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-Content.normal>
@endsection
