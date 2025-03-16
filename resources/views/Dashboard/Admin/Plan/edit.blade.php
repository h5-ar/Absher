@extends('Dashboard.Layouts.adminLayout')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/pickers/form-flat-pickr.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
@endpush

@section('title')
{{ translate('Edit Plan') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card">
        <div class="card-body">
            <form method="POST" id="createUserForm" action="{{ route('plan.update', $plan->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <x-inputs.h-input inputName="name" inputId="name" lable="Name" placeholder="Category Name"
                        description="Enter Category Name" value="{{ $plan->name }}" isRequired='true' />
                    <x-inputs.h-input inputName="trips_number" inputId="trips_number" lable="Trips Number"
                        description="Enter Trips Number" value="{{ $plan->trips_number }}" isRequired='true' />
                        <x-inputs.h-gender namefor="select2-type-container" id="select2-type-container" typeValue="{{ $plan->type_bus }}" description="Select Type Bus" />

                    <x-inputs.available-select typeValue="{{ $plan->available }}" label="Status" description="Select Status Of Plan" />
                    <x-inputs.h-input inputName="price" inputId="price" lable="Price"
                        description="Enter Price Plan" value="{{ $plan->price}}"
                        isRequired="true" />
                </div>


                <x-Button.submit />
                <x-Button.rest />

            </form>
        </div>
    </div>
</x-Content.normal>
@endsection