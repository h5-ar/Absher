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
{{ translate('Edit Bus') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="card">
        <div class="card-body">
            <form id="createForm" class="form form-horizontal" method="POST"
                action="{{ route('bus.store') }}">
                @csrf
                <div class="row">
                    <x-inputs.h-gender-select namefor="type" id="type" description="Select Type Bus" />

                    <x-inputs.Multi-Vertical.input label="Seats Count" name="seats_count"
                        placeholder="Seats Count" inputId="seats_count" required isRequired="true"
                        description="Enter Seats Count" />
                </div>
                <x-Button.submit />
                <x-Button.rest />

            </form>
        </div>
    </div>
</x-Content.normal>
@endsection
