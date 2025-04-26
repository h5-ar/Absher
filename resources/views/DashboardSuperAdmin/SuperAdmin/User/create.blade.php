@extends('DashboardSuperAdmin.Layouts.adminLayout')

@section('title')
{{ translate('Add User') }}
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
                    <h4 class="card-title fs-2 text-bold">{{ translate('Add User') }}</h4>
                </div>
                <div class="card-body">
                    <form id="createForm" class="form form-horizontal" method="POST"
                        action="{{ route('store.user') }}">
                        @csrf

                        <div class="row">
                            <x-inputs.h-input inputName="first_name" inputId="first_name" lable="First Name"
                                description="Enter First Name" placeholder="{{ translate('First Name') }}" />
                            <x-inputs.h-input inputName="last_name" inputId="last_name" lable="Last Name"
                                description="Enter Last Name" placeholder="{{ translate('Last Name') }}" />

                            <x-inputs.h-input inputName="phone" inputId="phone" lable="Phone Number"
                                description="Enter Company Name" placeholder="09XXXXXXXX" onkeypress="return isNumberKey(event,10)"
                                description="Enter Phone Number" />
                            <x-inputs.h-input inputName="email" inputId="email" lable="User Email"
                                description="Enter User Email" placeholder="{{ translate('User Email') }}"
                                type="email" />

                            <x-inputs.h-input inputName="username" inputId="username" lable="Username"
                                description="Enter Username" placeholder="{{ translate('Username') }}" />
                            <x-inputs.h-input inputName="password" inputId="password" lable="Password"
                                description="Enter Password" placeholder="{{ translate('Password') }}"
                                type="password" />
                            <x-inputs.h-input inputName="password_confirmation" inputId="password_confirmation" lable="Confirm Password"
                                description="Enter User Password Again" placeholder="{{ translate('Company Password') }}"
                                type="password" />
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