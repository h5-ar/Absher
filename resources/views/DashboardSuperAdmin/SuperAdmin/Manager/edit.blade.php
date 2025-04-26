@extends('DashboardSuperAdmin.Layouts.adminLayout')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/pickers/form-flat-pickr.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
@endpush

@section('title')
{{ translate('Edit Manager') }}
@endsection

@section('content')
<x-Content.normal>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title fs-2 text-bold">{{ translate('Edit Manager') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" id="createUserForm" action="{{ route('update.manager', $manager->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <x-inputs.h-input inputName="first_name" inputId="first_name" lable="First Name" placeholder="First Name"
                                description="Enter First Name" value="{{ $manager->first_name }}" isRequired='true' />
                            <x-inputs.h-input inputName="last_name" inputId="last_name" lable="Last Name" placeholder="Last Name"
                                description="Enter last Name" value="{{ $manager->last_name }}" isRequired='true' />
                            <x-inputs.h-input inputName="phone" inputId="phone" lable="Phone Number"
                                placeholder="09XXXXXXXX" onkeypress="return isNumberKey(event,10)"
                                description="Enter Phone Number" value="{{ $manager->phone }}"     />
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