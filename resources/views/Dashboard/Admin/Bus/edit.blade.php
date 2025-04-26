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
            <form method="POST" id="createUserForm" action="{{ route('bus.update', $bus->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <x-inputs.h-bustype-select typeValue="{{ $bus->type }}" description="Select Type Bus" />

                    <x-inputs.h-input value="{{ $bus->seats_count }}" inputName="seats_count" inputId="seats_count" lable="Seats Count"
                        description="Enter Seats Count" placeholder="{{ translate('Enter Seats Count') }}"
                            />
                    <div class="col-sm-9 offset-sm-3">
                        <x-Button.submit />
                        <x-Button.rest />
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-Content.normal>
@endsection
@push('layout-scripts')

@endpush