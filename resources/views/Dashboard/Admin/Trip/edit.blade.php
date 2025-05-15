@extends('Dashboard.Layouts.adminLayout')
@use('App\Enums\BusType');
@section('title')
{{ translate('Edit Trip') }}
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
                    <h4 class="card-title fs-2 text-bold">{{ translate('Edit Trip') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('trip.update', $trip->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- تعديل بيانات الرحلة -->
                        <div class="row">
                            <x-inputs.h-input inputName="price" inputId="price" lable="Price"
                                placeholder="Enter Price"
                                description="Enter the price of the trip"
                                value="{{ $trip->price }}"
                                isRequired='true' />

                            <x-inputs.h-bus-select typeValue="{{$trip->bus_id}} " description="Select Bus" />

                            <x-Date.time-inputU
                                typeValue="{{$trip->take_off_at}}" name="datetime" dateId="datetime" label="Date"    
                                description="Select Offer Start Date" enableTime="true"
                                time_24hr="false"
                                dateFormat="Y-m-d h:i K" />
                            <x-inputs.h-day-select typeValue="{{$trip->day}}" description="Select Day" />


                            <x-inputs.governorates-select typeValue="{{$trip->path->from}}" namefor="from" id="from" label="From" description="Select Governorates"     />
                            <x-inputs.governorates-select typeValue="{{$trip->path->to1}}" namefor="to1" id="to1" label="To 1" description="Select Governorates"     />
                            <x-inputs.governorates-select typeValue="{{$trip->path?->to2}}" namefor="to2" id="to2" label="To 2" description="Select Governorates"     />
                            <x-inputs.governorates-select typeValue="{{$trip->path?->to3}}" namefor="to3" id="to3" label="To 3" description="Select Governorates"     />
                            <x-inputs.governorates-select typeValue="{{$trip->path?->to4}}" namefor="to4" id="to4" label="To 4" description="Select Governorates"     />
                            <x-inputs.governorates-select typeValue="{{$trip->path?->to5}}" namefor="to5" id="to5" label="To 5" description="Select Governorates"     />


                            <div class="col-sm-9 offset-sm-3">
                                <x-Button.submit />
                                <x-Button.rest />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-Content.normal>
@endsection